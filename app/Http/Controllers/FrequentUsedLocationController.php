<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\Models\FrequentlyUsedLocation;
use PickupApi\Utils\TokenUtil;

class FrequentUsedLocationController extends Controller {
    /**
     * 获取当前用户的常用地点
     * @throws \InvalidArgumentException
     */
    public function getFrequentUsedLocations() {
        return RestResponse::paginated(TokenUtil::getUser()->frequent_used_locations()->getQuery());

    }

    /**
     * 增加新的常用地点
     */
    public function addNewFrequentUsedLocation() {
        $this->validate(
            $this->request,
            [
                'name'      => 'required|string',
                'latitude'  => 'required|numeric|min:-180|max:180',
                'longitude' => 'required|numeric|min:-90|max:90',
            ]
        );

        $location_info = $this->inputsWithUserId();
        $location      = FrequentlyUsedLocation::firstOrCreate($location_info);

        return RestResponse::created($location, '又多了一个常去的地方呢~');
    }

    /**
     * 获取当前用户某个常用地点
     *
     * @param FrequentlyUsedLocation $location
     *
     * @internal param $location_id
     * @return RestResponse
     */
    public function getFrequentUsedLocation(FrequentlyUsedLocation $location) {
        return RestResponse::json($location);
    }

    /**
     * 更新某个常用地点
     *
     * @param FrequentlyUsedLocation $location
     *
     * @internal param $location_id
     * @return RestResponse
     */
    public function updateFrequentUsedLocation(FrequentlyUsedLocation $location) {
        $location->update($this->request->all());

        return RestResponse::updated($location);
    }

    /**
     * 删除常用地点
     *
     * @param FrequentlyUsedLocation $location
     *
     * @internal param $location_id
     * @return RestResponse
     */
    public function removeFrequentUsedLocation(FrequentlyUsedLocation $location) {
        $location->delete();

        return RestResponse::deleted();
    }
}
