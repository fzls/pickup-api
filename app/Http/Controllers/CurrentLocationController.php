<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\Models\User;
use PickupApi\Utils\TokenUtil;

class CurrentLocationController extends Controller
{
    public function getCurrentLocationOf(User $user){
        $current_location = json_decode($this->redis->get($this->getRedisKey($user->id)),true);

        return RestResponse::single_without_link($current_location, $current_location?'主人现在在这个地方哦':'人家不知道主人去哪里去了TAT');
    }

    public function getCurrentLocation(){
        return $this->getCurrentLocationOf(TokenUtil::getUser());
    }

    public function updateCurrentLocation(){
        $this->validate(
            $this->request,
            [
                'latitude'  => 'required|numeric|min:-180|max:180',
                'longitude' => 'required|numeric|min:-90|max:90',
            ]
        );

        $location = $this->request->only('latitude', 'longitude');
        $this->redis->set($this->getRedisKey(TokenUtil::getUserId()), json_encode($location,JSON_PRETTY_PRINT));
        return RestResponse::created($location, '人家知道主人的最新位置啦',PICKUP_NO_LINK_NEEDED);
    }

    public function removeCurrentLocation(){
        $this->redis->del($this->getRedisKey(TokenUtil::getUserId()));

        return RestResponse::deleted('帮主人成功消除踪迹了呢');
    }

    public function getRedisKey($uid){
        return "current_location:$uid";
    }
}
