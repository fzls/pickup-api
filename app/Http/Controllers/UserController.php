<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\Models\User;
use PickupApi\Utils\TokenUtil;

class UserController extends Controller {
    public $request;

    public function __construct(Request $request) {
        $this->request = $request;
        /* 如果在这里初始化当前的用户，则当无法找到用户时报错时，在terminate阶段容器会重新初始化该类，导致再次触发错误，故现在只在需要当前用户的时候调用它 */
    }

    /**
     * 获取用户们的信息
     * @throws \InvalidArgumentException
     */
    public function getUsersProfile() {
        return RestResponse::paginated(User::query());
    }

    /**
     * 添加一个新的用户
     */
    public function addNewUser() {
        $this->validate(
            $this->request,
            [
                'id'             => 'required|unique:users,id',
                'school_id'      => 'required|exists:schools,id',
                'money'          => 'numeric|max:0',
                'checkin_points' => 'numeric|max:0',
                'charm_points'   => 'numeric|max:0',
            ]
        );
        $user = User::create($this->request->all());

        return RestResponse::created($user, '新的小伙伴加入了呢');
    }

    /**
     * 获取该id对应用户的信息
     *
     * @param User $user
     *
     * @return RestResponse
     * @internal param $user_id
     *
     */
    public function getUserProfile(User $user) {
        return RestResponse::json($user);
    }

    /**
     * 获取当前请求的token所代理的用户的信息
     */
    public function getCurrentUserProfile() {
        return RestResponse::json(TokenUtil::getUser());
    }

    /**
     * 更新当前请求的token所代理的用户的信息
     */
    public function updateCurrentUserProfile() {
        $user = TokenUtil::getUser();
        $this->validate(
            $this->request,
            [
                'id'             => 'numeric|size:' . $user->id,
                'school_id'      => 'exists:schools,id',
                'money'          => 'numeric|size:' . $user->money,
                'checkin_points' => 'numeric|size:' . $user->checkin_points,
                'charm_points'   => 'numeric|size:' . $user->charm_points,
            ]
        );

        $user->update($this->request->all());

        return RestResponse::json($user);
    }

    /**
     * 更新当前请求的token所代理的用户的部分信息
     */
    public function updatePartialCurrentUserProfile() {
        return $this->updateCurrentUserProfile();
    }

    /**
     * 将当前请求的token所代理的用户账户注销掉（用户手动停用）
     */
    public function markAsDeleted() {
        $user = TokenUtil::getUser();
        $user->delete();

        return RestResponse::meta_only(204,'meow，主人被我藏起来了呢~');
    }

    public function markAsActivated(){
        $user = TokenUtil::getUser(true);
        $user->restore();

        return RestResponse::json($user);
    }
}
