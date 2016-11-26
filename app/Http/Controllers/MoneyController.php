<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\User;
use PickupApi\Utils\TokenUtil;

class MoneyController extends Controller {
    public function getRemainingMoney() {
        $money = TokenUtil::getUser()->money;

        return RestResponse::single_without_link($money, '主人还有这么多money呀');
    }

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

    public function updateMoney($change, $message) {
        $user = TokenUtil::getUser();

        $this->updateMoneyFor($user, $change);

        return RestResponse::single_without_link($user->money, $message);
    }

    public function updateMoneyFor(User $user, $change){
        $after_change = $user->money + $change;
        if ($after_change < 0) {
            throw new PickupApiException(400, '主人没有这么多钱可以拿回去哟');
        }

        $user->update(
            [
                'money' => $after_change,
            ]
        );
    }

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
