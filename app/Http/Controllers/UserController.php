<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Models\User;
use PickupApi\TokenUtil;

class UserController extends Controller
{
    public $request;
    public $user;

    public function __construct(Request $request) {
        $this->request=$request;
        $this->user = TokenUtil::getUser();
    }

    /**
     * 获取用户们的信息
     */
    public function getUsersProfile(){
        /*TODO*/
    }

    /**
     * 添加一个新的用户
     */
    public function addNewUser(){
        /*TODO*/
    }

    /**
     * 获取该id对应用户的信息
     *
     * @param $user_id
     */
    public function getUserProfile($user_id){
        /*TODO*/
    }

    /**
     * 获取当前请求的token所代理的用户的信息
     */
    public function getCurrentUserProfile(){
        /*TODO*/
    }

    /**
     * 更新当前请求的token所代理的用户的信息
     */
    public function updateCurrentUserProfile(){
        /*TODO*/
    }

    /**
     * 更新当前请求的token所代理的用户的部分信息
     */
    public function updatePartialCurrentUserProfile(){
        /*TODO*/
    }

    /**
     * 将当前请求的token所代理的用户账户注销掉（用户手动停用）
     */
    public function markAsDeleted(){
        /*TODO*/
    }
}
