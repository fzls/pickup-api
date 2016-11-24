<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\User;
use PickupApi\Models\Vehicle;
use PickupApi\Utils\TokenUtil;

class VehicleController extends Controller {
    public function getVehiclesForCurrentUser() {
        return RestResponse::paginated(TokenUtil::getUser()->vehicles()->getQuery());
    }

    public function addNewVehicleForCurrentUser() {
        $this->validate(
            $this->request,
            [
                'type_id' => 'required|numeric|exists:vehicle_types,id',
                'name'    => 'required|string|max:255',
                'pic'     => 'string|max:2083',
            ]
        );

        $vehicle_info = $this->inputsWithUserId();
        $vehicle      = Vehicle::firstOrCreate($vehicle_info);

        return RestResponse::created($vehicle, '哇，主人様又有新的豪车了呢~');
    }

    public function getVehicleForCurrentUser(Vehicle $vehicle) {
        $this->makeSureVehicleBelongsToUser($vehicle);

        return RestResponse::single($vehicle, '找到主人様的帅车了呢');
    }

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

        $vehicle->update($this->inputsWithUserId());

        return RestResponse::updated($vehicle);
    }

    public function removeVehicleForCurrentUser(Vehicle $vehicle) {
        $this->makeSureVehicleBelongsToUser($vehicle);

        $vehicle->delete();

        return RestResponse::deleted();
    }

    public function getVehiclesOfThatUser(User $user) {
        return RestResponse::paginated($user->vehicles()->getQuery());
    }

    public function getVehicleOfThatUser(User $user, Vehicle $vehicle) {
        $this->makeSureVehicleBelongsToUser($vehicle, $user->id);

        return RestResponse::single($vehicle);
    }

    public function makeSureVehicleBelongsToUser($vehicle, $user_id = null) {
        /*检测该车是否是当前用户的*/
        if ($vehicle->user->id !== ($user_id ?: TokenUtil::getUserId())) {
            throw new PickupApiException(403, '喵喵喵！这不是主人様的车子啦，是不是睡迷糊了呀~？');
        }
    }
}
