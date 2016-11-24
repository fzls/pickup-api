<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\Models\User;
use PickupApi\Models\Vehicle;
use PickupApi\Utils\TokenUtil;

class VehicleController extends Controller
{
    public function getVehiclesForCurrentUser(){
        return RestResponse::paginated(TokenUtil::getUser()->vehicles()->getQuery());
    }

    public function addNewVehicleForCurrentUser(){
        $this->validate(
            $this->request,
            [
                'type_id'=>'required|numeric|exists:vehicle_types,id',
                'name'=> 'required|string|max:255',
                'pic'=>'string|max:2083',
            ]
        );

        $vehicle_info = $this->inputsWithUserId();
        $vehicle = Vehicle::firstOrCreate($vehicle_info);

        return RestResponse::created($vehicle, '哇，主人様又有新的豪车了呢~');
    }

    public function getVehicleForCurrentUser(Vehicle $vehicle){
        /*检测该车是否是当前用户的*/

        return RestResponse::single($vehicle,'找到主人様的帅车了呢');
    }

    public function updateVehicleForCurrentUser(Vehicle $vehicle){

    }

    public function removeVehicleForCurrentUser(Vehicle $vehicle){

    }

    public function getVehiclesOfThatUser(User $user){

    }

    public function getVehicleOfThatUser(User $user, Vehicle $vehicle){

    }
}
