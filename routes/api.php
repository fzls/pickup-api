<?php

use Illuminate\Http\Request;

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
    return Cache::get($request->bearerToken())['user'];
});

// RE: all the path in this file start with api, like /api/users

Route::get('/user', function (Request $request) {
    return $request->user();
});
