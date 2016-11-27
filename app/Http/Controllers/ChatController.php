<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Models\Chat;
use PickupApi\Models\User;

class ChatController extends Controller
{
    /**
     * 返回用户的聊天记录
     */
    public function getChats(){

    }

    /**
     * 返回用户与另一个用户的聊天记录
     *
     * @param User $pal
     */
    public function getChatsWith(User $pal){

    }

    /**
     * 新建一条用户与另一个用户的聊天记录
     *
     * @param User $pal
     */
    public function newChatWith(User $pal){

    }

    /**
     * 删除用户与另一个用户的聊天记录
     *
     * @param User $pal
     */
    public function deleteChatsWith(User $pal){

    }

    /**
     * 获取一条用户与另一个用户的聊天记录
     *
     * @param User $pal
     * @param Chat $chat
     */
    public function getChatWith(User $pal, Chat $chat){

    }

    /**
     * 召回一条用户与另一个用户的聊天记录
     *
     * @param User $pal
     * @param Chat $chat
     */
    public function recallChatWith(User $pal, Chat $chat){

    }

    /**
     * 删除一条用户与另一个用户的聊天记录
     *
     * @param User $pal
     * @param Chat $chat
     */
    public function deleteChatWith(User $pal, Chat $chat){

    }
}
