<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 通过redis实现数据持久化
 *
 * Class RequestController
 * @package PickupApi\Http\Controllers
 */
class RequestController extends Controller {
    public $redis;
    public $redis_key;

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->redis     =\Redis::connection();
        $this->redis_key = 'request_list';
    }


    public function getRequestList() {
        $this->redis->get($this->redis_key);
    }

    public function addNewRequestToList() {
        $this->validate(
            $this->request,
            [
                'start_name'=>'string',
                'start_latitude'=>'required|numeric|min:-180|max:180',
                'start_longitude'=>'required|numeric|min:-90|max:90',
                'end_name'=>'string',
                'end_latitude'=>'required|numeric|min:-180|max:180',
                'end_longitude'=>'required|numeric|min:-90|max:90',
                'expected_vehicle_type'=>'exists',
                'activity'=>
            ]
        )
        $this->redis->lpush($this->redis_key,[

        ]);
    }

    public function driverAcceptRequest() {

    }

    public function passengerCancelRequest() {

    }
}
