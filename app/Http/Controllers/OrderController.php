<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Exceptions\UnauthorizedException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\History;
use PickupApi\Models\Recharge;
use PickupApi\Models\Withdraw;
use PickupApi\Utils\TokenUtil;

/**
 * Class OrderController
 * @package PickupApi\Http\Controllers
 */
class OrderController extends Controller
{
    /**
     * 获取用户的充值订单
     *
     * @return RestResponse
     */
    public function getRechargeOrders(){
        return RestResponse::paginated(TokenUtil::getUser()->recharges()->getQuery());
    }

    /**
     * 获取用户的某个充值订单
     *
     * @param Recharge $recharge
     *
     * @return RestResponse
     */
    public function getRechargeOrder(Recharge $recharge){
        $this->assertOwnIt($recharge->user_id);

        return RestResponse::single($recharge);
    }

    /**
     * 获取用户的提现订单
     *
     * @return RestResponse
     */
    public function getWithdrawOrders(){
        return RestResponse::paginated(TokenUtil::getUser()->withdraws()->getQuery());
    }

    /**
     * 获取用户的某个提现订单
     *
     * @param Withdraw $withdraw
     *
     * @return RestResponse
     */
    public function getWithdrawOrder(Withdraw $withdraw){
        $this->assertOwnIt($withdraw->user_id);

        return RestResponse::single($withdraw);

    }

    /**
     * 获取用户的支付订单
     *
     * @return RestResponse
     */
    public function getPaymentOrders(){
        return RestResponse::paginated(TokenUtil::getUser()->history()->getQuery());
    }

    /**
     * 获取用户的某个支付订单
     *
     * @param History $payment
     *
     * @return RestResponse
     */
    public function getPaymentOrder(History $payment){
        $this->assertOwnIt($payment->passenger_id);

        return RestResponse::single($payment);
    }

    /**
     * 获取用户的收益订单
     *
     * @return RestResponse
     */
    public function getRevenueOrders(){
        return RestResponse::paginated(TokenUtil::getUser()->drive_history()->getQuery());
    }

    /**
     * 获取用户的某个收益订单
     *
     * @param History $revenue
     *
     * @return RestResponse
     */
    public function getRevenueOrder(History $revenue){
        $this->assertOwnIt($revenue->driver_id);

        return RestResponse::single($revenue);
    }

    /**
     * 确保用户拥有查看当前订单的权限
     *
     * @param $uid
     *
     * @throws UnauthorizedException
     */
    public function assertOwnIt($uid){
        if($uid !== TokenUtil::getUserId()){
            throw new UnauthorizedException('主人不能碰别人的东西哟');
        }
    }
}
