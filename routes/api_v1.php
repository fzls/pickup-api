<?php

use Illuminate\Http\Request;
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

    return RestResponse::json($token, PICKUP_NO_LINK_NEEDED);
});

Route::post('/test', function (\Request $request) {
    return RestResponse::json('post');
});

Route::group([/*用户相关接口*/], function () {
    Route::get('/users', 'UserController@getUsersProfile');
    Route::post('/users', 'UserController@addNewUser');
    Route::get('/users/{user}', 'UserController@getUserProfile');
    Route::get('/me', 'UserController@getCurrentUserProfile');
    Route::post('/me', 'UserController@markAsActivated');
    Route::put('/me', 'UserController@updateCurrentUserProfile');
    Route::delete('/me', 'UserController@markAsDeleted');
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
});

/*Hack: 从这里开始*/
Route::group([/*历史行程接口*/],function (){
    Route::get('/history','');
    Route::post('/history','');
    Route::get('/history/{history}','');
    Route::delete('/history/{history}','');
});

Route::group([/*历史行程快照接口*/], function (){
    Route::get('/history_snapshots', '');
    Route::post('/history_snapshots','');
});

Route::group([/*当前位置接口*/], function (){
    Route::get('/current_location', '');
    Route::post('/current_location', '');
    Route::delete('/current_location', '');
});

Route::group([/*余额相关接口*/], function (){
    Route::get('/money', '');
    Route::post('/money', '');
    Route::delete('/money', '');
    Route::post('/transfer/{to}', '');
});

Route::group([/*订单相关接口*/], function (){
    Route::get('/orders/recharges', '');
    Route::get('/orders/withdraws', '');
    Route::get('/orders/payments', '');
    Route::get('/orders/revenues', '');
});

Route::group([/*礼物相关接口*/], function (){
    Route::get('/gift-categories', '');
    Route::post('/gift-categories', '');
    Route::get('/gift-categories/{gift}', '');
    Route::put('/gift-categories/{gift}', '');
    Route::delete('/gift-categories/{gift}', '');
    Route::get('/gifts', '');
    Route::post('/gifts', '');
});

Route::group([/*评价与投诉接口*/], function (){
    Route::post('/rater/{to}', '');
    Route::post('/tousu/{to}', '');
});

Route::group([/*排行榜相关接口*/], function (){
    Route::get('/rankings', '');
    Route::get('/rankings/{type}', '');
    /*获取某一种类型的排行榜{highest_rated_drivers, most_attractive_drivers, most_rated_passengers}
    对象类别分三个，highest_rated_driver_rankings, most_attractive_driver_rankings, most_rated_passenger_rankings，
    时间段类别分过去一天，一周，一月，以及总排行，通过选择时间周期调整，默认显示一周的结果
*/
});

Route::group([/*聊天接口*/], function (){
    Route::get('/chats', '');
    Route::get('/chats/{pal}', '');
    Route::post('/chats/{pal}', '');
    Route::delete('/chats/{pal}', '');
    Route::get('/chats/{pal}/{chat}', '');
    Route::put('/chats/{pal}/{chat}', '');
    Route::delete('/chats/{pal}/{chat}', '');
});

Route::group([/*通知相关接口*/],function (){
    Route::get('/notifications', '');
    Route::post('/notifications', '');
    Route::put('/notifications', '');
    Route::get('/notifications/read', '');
    Route::get('/notifications/unread', '');
    Route::get('/notifications/{notification}', '');
    Route::put('/notifications/{notification}', '');
    Route::delete('/notifications/{notification}', '');
});

Route::group([/*签到相关接口*/], function (){
    Route::get('/checkin', '');
    Route::post('/checkin', '');
});

Route::group([/*搜索相关接口*/], function (){
    Route::get('/search', '');
});

Route::group([/*其他接口*/],function (){
    Route::get('/about', '');
    Route::get('/help', '');
    Route::get('/contact', '');
    Route::get('/version', '');
});