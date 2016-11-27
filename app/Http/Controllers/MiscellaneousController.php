<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;

class MiscellaneousController extends Controller
{
    public function about(){
        $about = config('app.about');

        return RestResponse::single_without_link($about, '主人知道人家是干什么的了嘛');
    }

    public function help(){
        $help = config('app.help');

        return RestResponse::single_without_link($help, '主人还有什么疑问吗？');
    }

    public function contact(){
        $contact = config('app.about.contact');

        return RestResponse::single_without_link($contact, '主人酷爱来找人家玩呀');
    }

    public function version(){
        $version = config('app.about.version');

        return RestResponse::single_without_link($version, '哇，看来好久没更新的样子呢');
    }
}
