<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Exceptions\UnauthorizedException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\User;
use PickupApi\Models\Vehicle;
use PickupApi\Utils\TokenUtil;

/**
 * Class VehicleController
 * @package PickupApi\Http\Controllers
 */
class VehicleController extends Controller {
    /**
     * 获取当前用户的车辆信息
     *
     * @return RestResponse
     * @throws \InvalidArgumentException
     */
    public function getVehiclesForCurrentUser() {
        return RestResponse::paginated(TokenUtil::getUser()->vehicles()->getQuery());
    }

    /**
     * 为当前用户添加一个新的车辆
     *
     * @return RestResponse
     */
    public function addNewVehicleForCurrentUser() {
        $this->validate(
            $this->request,
            [
                'type_id' => 'required|numeric|exists:vehicle_types,id',
                'name'    => 'required|string|max:255',
                'pic'     => 'string|max:2083',
            ]
        );

        $vehicle_info = $this->inputsWithUserId(['type_id', 'name', 'pic']);
        $vehicle      = Vehicle::firstOrCreate($vehicle_info);

        return RestResponse::created($vehicle, '哇，主人様又有新的豪车了呢~');
    }

    /**
     * 获取当前用户的某辆车
     *
     * @param Vehicle $vehicle
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\UnauthorizedException
     */
    public function getVehicleForCurrentUser(Vehicle $vehicle) {
        $this->makeSureVehicleBelongsToUser($vehicle);

        return RestResponse::single($vehicle, '找到主人様的帅车了呢');
    }

    /**
     * 更新当前用户的某辆车的信息
     *
     * @param Vehicle $vehicle
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\UnauthorizedException
     */
    public function updateVehicleForCurrentUser(Vehicle $vehicle) {
        $this->makeSureVehicleBelongsToUser($vehicle);

        $this->validate(
            $this->request,
            [
                'type_id' => 'numeric|exists:vehicle_types,id',
                'name'    => 'string|max:255',
                'pic'     => 'string|max:2083',
            ]
        );

        $vehicle->update($this->inputsWithUserId(['type_id', 'name', 'pic']));

        return RestResponse::updated($vehicle);
    }

    /**
     * 移除当前用户的某辆车
     *
     * @param Vehicle $vehicle
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\UnauthorizedException
     */
    public function removeVehicleForCurrentUser(Vehicle $vehicle) {
        $this->makeSureVehicleBelongsToUser($vehicle);

        $vehicle->delete();

        return RestResponse::deleted();
    }

    /**
     * 获取某用户的车辆
     *
     * @param User $user
     *
     * @return RestResponse
     * @throws \InvalidArgumentException
     */
    public function getVehiclesOfThatUser(User $user) {
        return RestResponse::paginated($user->vehicles()->getQuery());
    }

    /**
     * 获取某用户的某车辆
     *
     * @param User    $user
     * @param Vehicle $vehicle
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\UnauthorizedException
     */
    public function getVehicleOfThatUser(User $user, Vehicle $vehicle) {
        $this->makeSureVehicleBelongsToUser($vehicle, $user->id);

        return RestResponse::single($vehicle);
    }

    /**
     * 确保车辆属于该用户
     *
     * @param      $vehicle
     * @param null $user_id
     *
     * @throws UnauthorizedException
     */
    public function makeSureVehicleBelongsToUser($vehicle, $user_id = null) {
        /*检测该车是否是当前用户的*/
        if ($vehicle->user->id !== ($user_id ?: TokenUtil::getUserId())) {
            throw new UnauthorizedException('喵喵喵！这不是主人様的车子啦，是不是睡迷糊了呀~？');
        }
    }
}
