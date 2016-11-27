<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;

/**
 * Class MiscellaneousController
 * @package PickupApi\Http\Controllers
 */
class MiscellaneousController extends Controller
{
    /**
     * 获取关于我们的信息
     *
     * @return RestResponse
     */
    public function about(){
        $about = config('app.about');

        return RestResponse::single_without_link($about, '主人知道人家是干什么的了嘛');
    }

    /**
     * 获取系统的帮助信息
     *
     * @return RestResponse
     */
    public function help(){
        $help = config('app.help');

        return RestResponse::single_without_link($help, '主人还有什么疑问吗？');
    }

    /**
     * 获取联系方式
     *
     * @return RestResponse
     */
    public function contact(){
        $contact = config('app.about.contact');

        return RestResponse::single_without_link($contact, '主人酷爱来找人家玩呀');
    }

    /**
     * 获取系统的版本信息
     *
     * @return RestResponse
     */
    public function version(){
        $version = config('app.about.version');

        return RestResponse::single_without_link($version, '哇，看来好久没更新的样子呢');
    }
}
