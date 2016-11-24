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
    $token = Cache::get($request->bearerToken());

    return RestResponse::json(compact('token'));
});

Route::group([/*用户相关接口*/], function () {
    Route::get('/users', 'UserController@getUsersProfile');
    Route::post('/users', 'UserController@addNewUser');
    Route::get('/users/{user_id}', 'UserController@getUserProfile');
    Route::get('/me', 'UserController@getCurrentUserProfile');
    Route::put('/me', 'UserController@updateCurrentUserProfile');
    Route::patch('/me', 'UserController@updatePartialCurrentUserProfile');
    Route::delete('/me', 'UserController@markAsDeleted');
    Route::post('/me', 'UserController@markAsActivated');
});

Route::group([/*常用地点接口*/],function (){

});