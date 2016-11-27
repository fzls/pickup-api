<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Exceptions\UnauthorizedException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\GiftBundle;
use PickupApi\Models\GiftCategory;
use PickupApi\Utils\TokenUtil;

/**
 * Class GiftController
 * @package PickupApi\Http\Controllers
 */
class GiftController extends Controller
{
    /**
     * 返回系统中所有的礼品种类
     *
     * @return RestResponse
     */
    public function getGiftCategories(){
        return RestResponse::paginated(GiftCategory::query());
    }

    /**
     * 添加一种新的礼品种类
     *
     * @return RestResponse
     */
    public function addGiftCategory(){
        $this->assertHasPermission();

        $this->validate(
            $this->request,
            [
                'name'=>'required|string|max:255',
                'description'=>'required|string',
                'pic'=>'required|string|max:2083',
                'price'=>'required|numeric|min:0'
            ]
        );

        $category_info = $this->request->only(
            [
                'name',
                'description',
                'pic',
                'price'
            ]
        );
        $category = GiftCategory::firstOrCreate($category_info);

        return RestResponse::created($category, '又有一种新的礼物了呢');
    }

    /**
     * 获取系统中的某种礼品种类
     *
     * @param GiftCategory $category
     *
     * @return RestResponse
     */
    public function getGiftCategory(GiftCategory $category){
        return RestResponse::single($category);
    }

    /**
     * 更新系统中的某种礼品种类
     *
     * @param GiftCategory $category
     *
     * @return RestResponse
     */
    public function updateGiftCategory(GiftCategory $category){
        $this->assertHasPermission();

        $this->validate(
            $this->request,
            [
                'name'=>'string|max:255',
                'description'=>'string',
                'pic'=>'string|max:2083',
                'price'=>'numeric|min:0'
            ]
        );

        $category_info = array_filter($this->request->only(
            [
                'name',
                'description',
                'pic',
                'price'
            ]
        ));

        $category->update($category_info);

        return RestResponse::single($category);
    }

    /**
     * 移除系统中的某种礼物
     *
     * @param GiftCategory $category
     *
     * @return RestResponse
     * @throws \Exception
     */
    public function removeGiftCategory(GiftCategory $category){
        $this->assertHasPermission();

        $category->delete();
        return RestResponse::deleted();
    }

    /**
     * 获取用户收到的所有礼物
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\UserNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getGifts(){
        return RestResponse::paginated(TokenUtil::getUser()->gift_bundles_received()->getQuery());
    }

    /**
     * 获取用户获得的某个礼物包
     *
     * @param GiftBundle $gift
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\UnauthorizedException
     */
    public function getGift(GiftBundle $gift){
        $this->assertIsOwner($gift->driver_id);

        return RestResponse::single($gift);
    }

    /**
     * 确保当前用户具有修改礼物种类的权限
     */
    public function assertHasPermission(){
        /*TODO: 确保具有修改礼物种类的权限*/
    }

    /**
     * 确保当前用户拥有该礼物
     *
     * @param $uid
     *
     * @throws UnauthorizedException
     */
    public function assertIsOwner($uid){
        if($uid !== TokenUtil::getUserId()){
            throw new UnauthorizedException();
        }
    }
}
