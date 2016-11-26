<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\History;
use PickupApi\Models\Recharge;
use PickupApi\Models\Withdraw;
use PickupApi\Utils\TokenUtil;

class OrderController extends Controller
{
    public function getRechargeOrders(){
        return RestResponse::paginated(TokenUtil::getUser()->recharges()->getQuery());
    }

    public function getRechargeOrder(Recharge $recharge){
        $this->assertOwnIt($recharge->user_id);

        return RestResponse::single($recharge);
    }

    public function getWithdrawOrders(){
        return RestResponse::paginated(TokenUtil::getUser()->withdraws()->getQuery());
    }

    public function getWithdrawOrder(Withdraw $withdraw){
        $this->assertOwnIt($withdraw->user_id);

        return RestResponse::single($withdraw);

    }

    public function getPaymentOrders(){
        return RestResponse::paginated(TokenUtil::getUser()->history()->getQuery());
    }

    public function getPaymentOrder(History $payment){
        $this->assertOwnIt($payment->passenger_id);

        return RestResponse::single($payment);
    }

    public function getRevenueOrders(){
        return RestResponse::paginated(TokenUtil::getUser()->drive_history()->getQuery());
    }

    public function getRevenueOrder(History $revenue){
        $this->assertOwnIt($revenue->driver_id);

        return RestResponse::single($revenue);
    }

    public function assertOwnIt($uid){
        if($uid !== TokenUtil::getUserId()){
            throw new PickupApiException(403, '主人不能碰别人的东西哟');
        }
    }
}
