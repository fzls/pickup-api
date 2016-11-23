<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-21
 * Time: 15:21
 */

namespace PickupApi;


use PickupApi\Http\Meta;
use PickupApi\Http\RestResponse;
use PickupApi\Models\User;

/**
 * Class Util
 *
 * 封装一些经常用到的操作
 *
 * @package PickupApi
 */
class TokenUtil {
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
        return \Cache::get(self::getToken());
    }

    /**
     * 获取本次会话的token信息
     *
     * @return mixed
     */
    public static function getTokenInfo(){
        return self::getPayload();
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
        /*试图在应用服务器中查询该用户的信息*/
        $user_id = self::getUserInfo()['id'];
        $user = User::find($user_id);
        /*若未找到该用户，则返回错误，提示用户在本系统内创建账户（即添加应用必要的信息，如学校等）*/
        if(is_null($user)){
            /*TODO: 返回一个可以注册相应信息的url*/
            return RestResponse::error(404, '大哥哥我不认识你欸');
        }
        /*否则直接返回用户*/
        return RestResponse::json(compact('user'));
    }
}