<?php

use Illuminate\Http\Request;
use PickupApi\Http\RestResponse;
use PickupApi\TokenUtil;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* test only*/
Route::get('/test',function (Request $request){
    $user = Cache::get($request->bearerToken());
    return RestResponse::json(compact('user'));
});

// RE: all the path in this file start with api, like /api/users

Route::get('/user', function (Request $request) {
    return $request->user();
});
