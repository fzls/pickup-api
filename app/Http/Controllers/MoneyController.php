<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Exceptions\InvalidOperationException;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\User;
use PickupApi\Utils\TokenUtil;

/**
 * Class MoneyController
 * @package PickupApi\Http\Controllers
 */
class MoneyController extends Controller {
    /**
     * 获取余额
     *
     * @return RestResponse
     */
    public function getRemainingMoney() {
        $money = TokenUtil::getUser()->money;

        return RestResponse::single_without_link($money, '主人还有这么多money呀');
    }

    /**
     * 用户进行充值，用户的实际转账在客户端用第三方支付的sdk进行
     *
     * @return RestResponse
     */
    public function recharge() {
        $this->validate(
            $this->request,
            [
                'recharge_amount'=>'required|numeric|min:0',
            ]
        );

        /* 支付在客户端进行*/
        return $this->updateMoney($this->request->get('recharge_amount'), '哇，主人你又氪金了嘛');
    }

    /**
     * 用户提现，在服务端进行实际地转账到用户账号，如每周六进行统一转账等等
     *
     * @return RestResponse
     */
    public function withdraw() {
        $this->validate(
            $this->request,
            [
                'withdraw_amount'=>'required|numeric|min:0',
            ]
        );
        $response = $this->updateMoney(-$this->request->get('withdraw_amount'), '呜呜呜，主人为什么要把钱拿回去呀TAT');

        /*NOTE：这里处理实际的提现流程，如加入一个消息队列中，又另一个服务器专门处理转账到指定用户账户中，如支付宝中*/
        /*TODO*/

        return $response;
    }

    /**
     * 更新用户的余额，用于充值或提现的辅助方法
     *
     * @param $change
     * @param $message
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\InvalidOperationException
     * @throws \PickupApi\Exceptions\UserNotFoundException
     */
    public function updateMoney($change, $message) {
        $user = TokenUtil::getUser();

        $this->updateMoneyFor($user, $change);

        return RestResponse::single_without_link($user->money, $message);
    }

    /**
     * 为该用户更新账户余额
     *
     * @param User $user
     * @param      $change
     *
     * @throws InvalidOperationException
     */
    public function updateMoneyFor(User $user, $change){
        $after_change = $user->money + $change;
        if ($after_change < 0) {
            throw new InvalidOperationException('主人没有这么多钱可以拿回去哟');
        }

        $user->update(
            [
                'money' => $after_change,
            ]
        );
    }

    /**
     * 用户在行程后向司机进行支付操作，不需要涉及第三方支付，在系统内部解决
     *
     * @return RestResponse
     * @throws \Throwable
     * @throws \Exception
     */
    public function transfer() {
        $this->validate(
            $this->request,
            [
                'to'=>'required|integer|exists:users,id',
                'amount'=>'required|numeric|min:0'
            ]
        );

        $from = TokenUtil::getUser();
        $to = User::find($this->request->get('to'));
        $amount = $this->request->get('amount');
        /*TODO: 添加赠送礼品的逻辑处理*/

        $details = [];
        $details['amount']=$amount;
        $details['old_from']=$from->money;
        $details['old_to']=$to->money;

        \DB::transaction(function () use ($from, $to, $amount) {
            $this->updateMoneyFor($from, -$amount);
            $this->updateMoneyFor($to, $amount);
        });

        $details['new_from']=$from->money;
        $details['new_to']=$to->money;

        return RestResponse::single_without_link($details, '又完成了一次愉快的py交易了呢');
    }
}
