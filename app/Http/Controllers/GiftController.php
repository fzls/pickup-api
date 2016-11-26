<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\GiftBundle;
use PickupApi\Models\GiftCategory;
use PickupApi\Utils\TokenUtil;

class GiftController extends Controller
{
    public function getGiftCategories(){
        return RestResponse::paginated(GiftCategory::query());
    }

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

    public function getGiftCategory(GiftCategory $category){
        return RestResponse::single($category);
    }

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
        /*FIXME: 所有的update不止要用only只取所需要的部分，还需要用array_filter去掉本次请求中未提供的key*/

        $category->update($category_info);

        return RestResponse::single($category);
    }

    public function removeGiftCategory(GiftCategory $category){
        $this->assertHasPermission();

        $category->delete();
        return RestResponse::deleted();
    }

    public function getGifts(){
        return RestResponse::paginated(TokenUtil::getUser()->gift_bundles_received()->getQuery());
    }

    public function getGift(GiftBundle $gift){
        $this->assertIsOwner($gift->driver_id);

        return RestResponse::single($gift);
    }

    public function assertHasPermission(){
        /*TODO: 确保具有修改礼物种类的权限*/
    }

    public function assertIsOwner($uid){
        if($uid !== TokenUtil::getUserId()){
            throw new PickupApiException(403, '主人不能碰别人的东西哟');
            /*FIXME: 新建一个 PickupApiUnauthorizedException*/
        }
    }
}
