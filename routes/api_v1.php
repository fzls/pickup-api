<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PickupApi\Http\RestResponse;
use PickupApi\TokenUtil;

/*
|--------------------------------------------------------------------------
| API version 1 Routes
|--------------------------------------------------------------------------
| RE: all the path in this file start with api/v1, like /api/v1/users
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* test only*/
Route::get('/test', function (Request $request) {
//    return RestResponse::json(\PickupApi\Utils\UrlUtil::getAllSupportedMethods(),NO_LINK_NEEDED);
    $token = Cache::get($request->bearerToken());
    $permissions = \PickupApi\Utils\TokenUtil::getPermissions();
    ;

    return RestResponse::json(
        [
            $permissions->has('view'),
            $permissions,
        ],
        PICKUP_NO_LINK_NEEDED
    );
});

Route::post('/test', function (\Request $request) {
    return RestResponse::json('post');
});

Route::group([/*用户相关接口*/], function () {
    /* TODO：-later 添加浙大邮箱激活流程*/
    Route::get('/users', 'UserController@getUsersProfile');
    Route::post('/users', 'UserController@addNewUser');
    Route::get('/users/{user}', 'UserController@getUserProfile');
    Route::get('/me', 'UserController@getCurrentUserProfile');
    Route::post('/me', 'UserController@markAsActivated');
    Route::put('/me', 'UserController@updateCurrentUserProfile');
    Route::delete('/me', 'UserController@markAsDeleted');
});

Route::group([/*学校*/], function (){
   Route::get('/schools',function (){
       return RestResponse::paginated(\PickupApi\Models\School::query());
   });
});

Route::group([/*常用地点接口*/], function () {
    Route::get('/frequent_used_locations', 'FrequentUsedLocationController@getFrequentUsedLocations');
    Route::post('/frequent_used_locations', 'FrequentUsedLocationController@addNewFrequentUsedLocation');
    Route::get('/frequent_used_locations/{location}', 'FrequentUsedLocationController@getFrequentUsedLocation');
    Route::put('/frequent_used_locations/{location}', 'FrequentUsedLocationController@updateFrequentUsedLocation');
    Route::delete('/frequent_used_locations/{location}', 'FrequentUsedLocationController@removeFrequentUsedLocation');
});

Route::group([/*车辆接口*/], function () {
    Route::get('/vehicles', 'VehicleController@getVehiclesForCurrentUser');
    Route::post('/vehicles', 'VehicleController@addNewVehicleForCurrentUser');
    Route::get('/vehicles/{vehicle}', 'VehicleController@getVehicleForCurrentUser');
    Route::put('/vehicles/{vehicle}', 'VehicleController@updateVehicleForCurrentUser');
    Route::delete('/vehicles/{vehicle}', 'VehicleController@removeVehicleForCurrentUser');
    Route::get('/users/{user}/vehicles', 'VehicleController@getVehiclesOfThatUser');
    Route::get('/users/{user}/vehicles/{vehicle}', 'VehicleController@getVehicleOfThatUser');
});

Route::group([/*车单接口*/], function () {
    Route::get('/requests', 'RequestController@getRequestList');
    Route::post('/requests', 'RequestController@addNewRequestToList');
    Route::put('/requests', 'RequestController@driverAcceptRequest');
    Route::delete('/requests', 'RequestController@passengerCancelRequest');

    Route::get('/request-status', function (){
       $user= \PickupApi\Utils\TokenUtil::getUser();

       if(! $user->request){
           /*获取用户当前所处的行程的信息*/
           $history = \PickupApi\Models\History::where('passenger_id', $user->id)->whereNotNull('started_at')->whereNull('finished_at')->orderBy('id', 'dsec')->take(1)->get();

           return RestResponse::single($history[0], 'accepted');
       }else{
           return RestResponse::meta_only(200, 'not yet');
       }
    });
});

Route::group([/*历史行程相关接口*/], function () {
//    Route::get('/current-history',function (){
//        $history = \PickupApi\Utils\TokenUtil::getUser()->history()->getQuery()->whereNotNull('started_at')->whereNull('finished_at')->orderBy('id', 'dsec')->take(1)->get();
//
//        return RestResponse::single(count($history)===1? $history[0]: null);
//    });

    Route::get('/history', 'HistoryController@getAllHistory');
    Route::get('/history/{history}', 'HistoryController@getHistory');
    Route::delete('/history/{history}', 'HistoryController@finishHistory');
    Route::get('/drive_history', 'HistoryController@getAllDriveHistory');
    Route::get('/drive_history/{history}', 'HistoryController@getDriveHistory');
    Route::get('/history/{history}/snapshots', 'HistoryController@getSnapshots');
    Route::post('/history/{history}/snapshots', 'HistoryController@addNewSnapshot');
});

Route::group([/*当前位置接口*/], function () {
    Route::get('/users/{user}/current_location', 'CurrentLocationController@getCurrentLocationOf');
    Route::get('current_location', 'CurrentLocationController@getCurrentLocation');
    Route::post('current_location', 'CurrentLocationController@updateCurrentLocation');
    Route::delete('current_location', 'CurrentLocationController@removeCurrentLocation');
});

Route::group([/*余额相关接口*/], function () {
    Route::get('/money', 'MoneyController@getRemainingMoney');
    Route::post('/money', 'MoneyController@recharge');
    Route::delete('/money', 'MoneyController@withdraw');
    Route::post('/transfer', 'MoneyController@transfer');
});

Route::group([/*订单相关接口*/], function () {
    Route::get('/orders/recharges', 'OrderController@getRechargeOrders');
    Route::get('/orders/recharges/{recharge}', 'OrderController@getRechargeOrder');
    Route::get('/orders/withdraws', 'OrderController@getWithdrawOrders');
    Route::get('/orders/withdraws/{withdraw}', 'OrderController@getWithdrawOrder');
    Route::get('/orders/payments', 'OrderController@getPaymentOrders');
    Route::get('/orders/payments/{payment}', 'OrderController@getPaymentOrder');
    Route::get('/orders/revenues', 'OrderController@getRevenueOrders');
    Route::get('/orders/revenues/{revenue}', 'OrderController@getRevenueOrder');
});

Route::group([/*礼物相关接口*/], function () {
    Route::get('/gift-categories', 'GiftController@getGiftCategories');
    Route::post('/gift-categories', 'GiftController@addGiftCategory');
    Route::get('/gift-categories/{category}', 'GiftController@getGiftCategory');
    Route::put('/gift-categories/{category}', 'GiftController@updateGiftCategory');
    Route::delete('/gift-categories/{category}', 'GiftController@removeGiftCategory');
    Route::get('/gifts', 'GiftController@getGifts');
    Route::get('/gifts/{gift}', 'GiftController@getGift');
});

Route::group([/*评价与投诉接口*/], function (){
    Route::post('/rater', 'ReviewAndTousuController@rate');
    Route::post('/feedback_sessions', 'ReviewAndTousuController@AddFeedbackSession');
    /*TODO：获取反馈与评论的接口*/
});

Route::group([/*排行榜相关接口*/], function (){
    Route::get('/rankings', 'RankingController@getAllRankings');
    Route::get('/rankings/{type}', 'RankingController@getRankingOfType');
    /*获取某一种类型的排行榜{highest_rated_drivers, most_attractive_drivers, most_rated_passengers}
    对象类别分三个，highest_rated_driver_rankings, most_attractive_driver_rankings, most_rated_passenger_rankings，
    时间段类别分过去一天，一周，一月，以及总排行，通过选择时间周期调整，默认显示一周的结果
*/
});

/*RE: 这个还没做呢~*/
Route::group([/*聊天接口*/], function (){
    Route::get('/chats', 'ChatController@getChats');
    Route::get('/chats/{pal}', 'ChatController@getChatsWith');
    Route::post('/chats/{pal}', 'ChatController@newChatWith');
    Route::delete('/chats/{pal}', 'ChatController@deleteChatsWith');
    Route::get('/chats/{pal}/{chat}', 'ChatController@getChatWith');
    Route::put('/chats/{pal}/{chat}', 'ChatController@recallChatWith');
    Route::delete('/chats/{pal}/{chat}', 'ChatController@deleteChatWith');
});

/*RE: 这个还没做呢~*/
Route::group([/*通知相关接口*/],function (){
    Route::get('/notifications', 'NotificationController@getNotifications');
    Route::post('/notifications', 'NotificationController@newNotification');
    Route::put('/notifications', 'NotificationController@markAllNotificationsAsRead');
    Route::get('/notifications/read', 'NotificationController@getAllReadNotifications');
    Route::get('/notifications/unread', 'NotificationController@getAllUnreadNotifications');
    Route::get('/notifications/{notification}', 'NotificationController@getNotification');
    Route::put('/notifications/{notification}', 'NotificationController@markAsRead');
    Route::delete('/notifications/{notification}', 'NotificationController@deleteNotification');
});

Route::group([/*签到相关接口*/], function (){
    Route::get('/checkin', 'CheckinController@checkIfCheckedIn');
    Route::post('/checkin', 'CheckinController@checkin');
});

/*RE: 这个还没做呢~*/
Route::group([/*搜索相关接口*/], function (){
    Route::get('/search', 'SearchController@search');
});

Route::group([/*其他接口*/],function (){
    Route::get('/about', 'MiscellaneousController@about');
    Route::get('/help', 'MiscellaneousController@help');
    Route::get('/contact', 'MiscellaneousController@contact');
    Route::get('/version', 'MiscellaneousController@version');
});