<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PickupApi\Utils\TokenUtil;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var null|\Predis\ClientInterface
     */
    public $redis;

    /**
     * Controller constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
        $this->redis = \Redis::connection();
        /* 如果在这里初始化当前的用户，则当无法找到用户时报错时，在terminate阶段容器会重新初始化该类，导致再次触发错误，故现在只在需要当前用户的时候调用它 */
    }

    /**
     * 将输入中添加用户id
     *
     * @return array
     */
    public function inputsWithUserId($fields){
        return array_merge(array_filter($this->request->only($fields)), ['user_id' => TokenUtil::getUserId()]);
    }
}
