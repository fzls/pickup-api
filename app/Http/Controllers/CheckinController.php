<?php

namespace PickupApi\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\Models\CheckinHistory;
use PickupApi\Models\User;
use PickupApi\Utils\TokenUtil;

class CheckinController extends Controller {
    /**
     * 检测用户是否今日是否已经签到过
     *
     * @return RestResponse
     */
    public function checkIfCheckedIn() {
        $checked_in             = $this->redis->getbit($this->getCheckInKey(), TokenUtil::getUserId());
        $checked_in_message     = '主人已经签到过了呢';
        $not_checked_in_message = '主人还没签到过呀';

        return RestResponse::single_without_link($checked_in, $checked_in ? $checked_in_message : $not_checked_in_message);
    }

    /**
     * 若用户未签到，则将用户签到
     *
     * @return RestResponse
     * @throws \Throwable
     * @throws \Exception
     */
    public function checkin() {
        $user_id = TokenUtil::getUserId();
        $checked_in             = $this->redis->getbit($this->getCheckInKey(), $user_id);
        if($checked_in){
            return RestResponse::meta_only(204, '主人已经签到了呢');
        }

        /*若未签到，则签到并赠送随机的积分*/
        $this->redis->setbit($this->getCheckInKey(),$user_id,1);
        $obtained_credit = random_int(config('app.min_checkin_credit'),config('app.max_checkin_credit'));
        \DB::transaction(function () use($user_id, $obtained_credit){
            CheckinHistory::create(compact('user_id','obtained_credit'));
            TokenUtil::getUser()->newQuery()->increment('checkin_points', $obtained_credit);
        }, 3);

        return RestResponse::single_without_link(compact('obtained_credit'), '主人的积分又变多了呢');
    }

    /**
     * 返回当日的签到用的redis key
     *
     * @return string
     */
    public function getCheckInKey() {
        $today = Carbon::now()->toDateString();

        return "checkin_for_$today";
    }
}
