<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-21
 * Time: 15:21
 */

namespace PickupApi;


class Util {
    public static function getToken(){
        return \Request::bearerToken();
    }

    public static function getPayload(){
        return \Cache::get(self::getToken())
    }

    public static function getTokenInfo(){
        return self::getPayload()['token'];
    }

    public static function getUserInfo(){
        return self::getPayload()['user'];
    }

    public static function getUserId(){
        return self::getUserInfo()['id'];
    }
}