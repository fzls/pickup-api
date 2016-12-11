<?php

namespace PickupApi\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\Models\History;
use PickupApi\Models\User;
use PickupApi\Utils\TokenUtil;

/**
 * Class RequestController
 * @package PickupApi\Http\Controllers
 */
class RequestController extends Controller {
    /**
     * 获取约车请求列表
     *
     * @return RestResponse
     * @throws \InvalidArgumentException
     */
    public function getRequestList() {
        return RestResponse::paginated(\PickupApi\Models\Request::with('vehicle'));
    }

    /**
     * 添加一条新的约车请求
     *
     * @return RestResponse
     */
    public function addNewRequestToList() {
        /*note: longitude是经度，latitude是纬度*/
        $this->validate(
            $this->request,
            [
                'start_name'            => 'string',
                'start_latitude'        => 'required|numeric|min:-90|max:90',
                'start_longitude'       => 'required|numeric|min:-180|max:180',
                'end_name'              => 'string',
                'end_latitude'          => 'required|numeric|min:-90|max:90',
                'end_longitude'         => 'required|numeric|min:-180|max:180',
                'expected_vehicle_type' => 'exists:vehicle_types,id',
                'activity'              => 'string',
                'phone_number'          => 'required|regex:/\d{11}/',
                'estimated_cost'        => 'required|numeric|min:0',
            ]
        );

        $request_info = $this->inputsWithUserId(
            [
                'start_name',
                'start_latitude',
                'start_longitude',
                'end_name',
                'end_latitude',
                'end_longitude',
                'expected_vehicle_type',
                'activity',
                'phone_number',
                'estimated_cost',
            ]
        );
        $request      = \PickupApi\Models\Request::firstOrCreate($request_info);

        return RestResponse::created($request, '又要出去了喵？');
    }

    /**
     * 司机接单
     *
     * @return RestResponse
     * @throws \Throwable
     * @throws \Exception
     */
    public function driverAcceptRequest() {
        $this->validate(
            $this->request,
            [
                'request_id' => 'required|exists:requests,id',
            ]
        );
        /*司机接单，开始一段新的行程*/
        $driver  = TokenUtil::getUser();
        $history = null;
        \DB::transaction(function () use (&$history, $driver) {
            /*从request中获取必要的信息，并删除该请求*/
            $request = \PickupApi\Models\Request::find($this->request->get('request_id'));
            $request->delete();
            /*添加新的行程记录*/
            $history = History::create(
                [
                    'passenger_id'    => $request->user_id,
                    'driver_id'       => $driver->id,
                    'start_name'      => $request->start_name,
                    'start_latitude'  => $request->start_latitude,
                    'start_longitude' => $request->start_longitude,
                    'end_name'        => $request->end_name,
                    'end_latitude'    => $request->end_latitude,
                    'end_longitude'   => $request->end_longitude,
                    'distance'        => 0,
                    'elapsed_time'    => 0,
                    'base_amount'     => 0,
                    'gift_amount'     => 0,
                    'penalty_amount'  => 0,
                    'started_at'      => Carbon::now(),
                    'reserved_at'     => $request->reserved_at,
                ]
            );
        });

        return RestResponse::created($history, '新的旅途要开始了咯');
    }

    /**
     * 用户取消约车
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\UserNotFoundException
     * @throws \Exception
     */
    public function passengerCancelRequest() {
        $user = TokenUtil::getUser();
        $user->request->delete();

        return RestResponse::deleted();
    }
}
