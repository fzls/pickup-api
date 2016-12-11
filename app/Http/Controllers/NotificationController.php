<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\Models\Notification;
use PickupApi\Utils\TokenUtil;

/**
 * Class NotificationController
 * @package PickupApi\Http\Controllers
 */
class NotificationController extends Controller
{
    /**
     * 获取用户的所有通知
     * @throws \InvalidArgumentException
     */
    public function getNotifications(){
        return RestResponse::paginated(TokenUtil::getUser()->notifications()->getQuery());
    }

    /**
     * 添加一条新的通知
     */
    public function newNotification(){
        /*确保具有相应权限*/
    }

    /**
     * 全部标记为已读
     */
    public function markAllNotificationsAsRead(){

    }

    /**
     * 获取所有已读通知
     */
    public function getAllReadNotifications(){

    }

    /**
     * 获取所有未读通知
     */
    public function getAllUnreadNotifications(){

    }

    /**
     * 获取一条通知
     *
     * @param Notification $notification
     */
    public function getNotification(Notification $notification){

    }

    /**
     * 将该通知标记为已读
     *
     * @param Notification $notification
     */
    public function markAsRead(Notification $notification){

    }

    /**
     * 删除该通知
     *
     * @param Notification $notification
     */
    public function deleteNotification(Notification $notification){

    }
}
