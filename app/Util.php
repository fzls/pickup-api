<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-21
 * Time: 15:21
 */

namespace PickupApi;


use PickupApi\Models\User;

/**
 * Class Util
 *
 * 封装一些经常用到的操作
 *
 * @package PickupApi
 */
class Util {
    /**
     * 获取本次会话的token
     *
     * @return null|string
     */
    public static function getToken(){
        return \Request::bearerToken();
    }

    /**
     * 获取本次会话的token对应的数据
     *
     * @return mixed
     */
    public static function getPayload(){
        return \Cache::get(self::getToken())
    }

    /**
     * 获取本次会话的token信息
     *
     * @return mixed
     */
    public static function getTokenInfo(){
        return self::getPayload()['token'];
    }

    /**
     * 获取本次会话的token所代理的用户的通用信息（从认证服务器处获得）
     *
     * @return mixed
     */
    public static function getUserInfo(){
        return self::getPayload()['user'];
    }

    /**
     * 返回本次会话的token所代理的用户的应用相关信息（从应用服务器处获得）
     *
     * TODO：设置一层middleware，用以确定到达应用系统内时，用户已经完善应用相关信息，具体措施如下
     * 如果在应用服务器中无该用户的信息，则新创建一个id为该id的记录，并将用户重定向到完善基本应用相关信息的页面
     * ps：同一个用户在两处的id是相同的，其中应用服务器的id从属于认证服务器的id
     *
     * @return mixed
     */
    public static function getUser(){
        return User::find(self::getUserInfo()['id']);
    }
}