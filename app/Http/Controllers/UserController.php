<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\Models\User;
use PickupApi\TokenUtil;

class UserController extends Controller
{
    public $request;

    public function __construct(Request $request) {
        $this->request=$request;
        /* 如果在这里初始化当前的用户，则当无法找到用户时报错时，在terminate阶段容器会重新初始化该类，导致再次触发错误，故现在只在需要当前用户的时候调用它 */
    }

    /**
     * 获取用户们的信息
     * @throws \InvalidArgumentException
     */
    public function getUsersProfile(){
        return RestResponse::paginated(User::query());
    }

    /**
     * 添加一个新的用户
     */
    public function addNewUser(){
        /*验证validator*/
        $this->validate(
            $this->request,
            [
                'id'=>'required|unique:users,id',
                'school_id'=>'required|exists:schools,id',
                'money'=>'numeric|max:0',
                'checkin_points'=>'numeric|max:0',
                'charm_points'=>'numeric|max:0',
            ]
        );
        User::create($this->request->all());

        return RestResponse::json(null,null,201,'新的小伙伴加入了呢');
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
        return RestResponse::json(TokenUtil::getUser());
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
