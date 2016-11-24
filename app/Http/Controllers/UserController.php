<?php

namespace PickupApi\Http\Controllers;

use PickupApi\Http\RestResponse;
use PickupApi\Models\User;
use PickupApi\Utils\TokenUtil;

class UserController extends Controller {
    /**
     * 获取用户们的信息
     * @throws \InvalidArgumentException
     */
    public function getUsersProfile() {
        return RestResponse::paginated(User::query());
    }

    /**
     * 添加一个新的用户, 即当前token所对应的用户，用于初始化应用相关信息
     */
    public function addNewUser() {
        $this->validate(
            $this->request,
            [
                'school_id'      => 'required|exists:schools,id',
                'money'          => 'numeric|max:0',
                'checkin_points' => 'numeric|max:0',
                'charm_points'   => 'numeric|max:0',
            ]
        );

        $id   = TokenUtil::getUserInfo()['id'];
        $info = array_merge($this->request->all(), ['id' => $id]);
        $user = User::find($id);

        if ($user) {
            /*如果用户已存在*/
            return RestResponse::meta_only(204, '人家早就知道主人様啦~');
        } else {
            /*否则新建用户,并且默认未激活，TODO:需要验证浙大邮箱后激活*/
            return RestResponse::created(User::create($info)->delete(), '新的小伙伴加入了呢，不过别忘了先去找浙大喵激活才能跟我一起玩哦~');
        }
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
        return RestResponse::single($user, '发现了一个新的主人様了呢');
    }

    /**
     * 获取当前请求的token所代理的用户的信息
     * @throws \PickupApi\Exceptions\UserNotFoundException
     */
    public function getCurrentUserProfile() {
        return RestResponse::single(TokenUtil::getUser(), 'meow, 找到主人様了耶');
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

        return RestResponse::updated($user);
    }

    /**
     * 将当前请求的token所代理的用户账户注销掉（用户手动停用）
     */
    public function markAsDeleted() {
        $user = TokenUtil::getUser();
        $user->delete();

        return RestResponse::deleted('meow，主人被我藏起来了呢~');
    }

    public function markAsActivated() {
        $user = TokenUtil::getUser(true);
        $user->restore();

        return RestResponse::json($user);
    }
}
