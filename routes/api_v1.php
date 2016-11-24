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

Route::post('/test',function (\Request $request){
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

Route::group([/*常用地点接口*/],function (){
    Route::get('/frequent_used_locations','FrequentUsedLocationController@getFrequentUsedLocations');
    Route::post('/frequent_used_locations','FrequentUsedLocationController@addNewFrequentUsedLocation');
    Route::get('/frequent_used_locations/{location}','FrequentUsedLocationController@getFrequentUsedLocation');
    Route::put('/frequent_used_locations/{location}','FrequentUsedLocationController@updateFrequentUsedLocation');
    Route::delete('/frequent_used_locations/{location}','FrequentUsedLocationController@removeFrequentUsedLocation');
});