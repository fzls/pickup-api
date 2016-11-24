<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\Models\FrequentlyUsedLocation;
use PickupApi\TokenUtil;

class FrequentUsedLocationController extends Controller {
    /**
     * 获取当前用户的常用地点
     */
    public function getFrequentUsedLocations() {
        return RestResponse::paginated(TokenUtil::getUser()->frequent_used_locations()->getQuery());

    }

    /**
     * 增加新的常用地点
     */
    public function addNewFrequentUsedLocation() {

    }

    /**
     * 获取当前用户某个常用地点
     *
     * @param FrequentlyUsedLocation $location
     *
     * @internal param $location_id
     */
    public function getFrequentUsedLocation(FrequentlyUsedLocation $location) {

    }

    /**
     * 更新某个常用地点
     *
     * @param FrequentlyUsedLocation $location
     *
     * @internal param $location_id
     */
    public function updateFrequentUsedLocation(FrequentlyUsedLocation $location) {

    }

    /**
     * 删除常用地点
     *
     * @param FrequentlyUsedLocation $location
     *
     * @internal param $location_id
     */
    public function removeFrequentUsedLocation(FrequentlyUsedLocation $location) {

    }
}
