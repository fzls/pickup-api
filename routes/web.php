<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use PickupApi\Models\School;
use PickupApi\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index');

Route::get('/artisan', function () {
    Artisan::call('db:seed');
});

/*RE: 测试新功能区域*/
Route::get('test', function (\Illuminate\Http\Request $request) {
    return response()->json($request->all());
//    $school = School::find($request->get('id'));
//    $user   = $school->users[0];
//
//    return [
//        'school'                       => $school,
//        'school.users'                 => $school->users,
//        'user'                         => $user,
//        'user.school'                  => $user->school,
//        'user.vehicles'                => $user->vehicles,
//        'user.frequent_used_locations' => $user->frequent_used_locations,
//        'user.recharges'               => $user->recharges,
//        'user.withdraws'               => $user->withdraws,
//        'user.feedback_sessions'       => $user->feedback_sessions,
//        'user.message_sent'            => $user->message_sent(),
//        'user.message_received'        => $user->message_received(),
//        'user.notifications'           => $user->notifications(),
//        'user.history'                 => $user->history,
//        'user.gift_bundles_received'   => $user->gift_bundles_received,
//        'user.gift_bundles_sent'       => $user->gift_bundles_sent,
//        'user.reviews'                 => $user->reviews,
//    ];
});

//RE: 下面的代码作为测试本API的消费者，在生产环境中应该注释掉
Route::get('/redirect', function () {
    $query = http_build_query([
                                  'client_id'     => '1',
                                  'redirect_uri'  => 'http://localhost:888/callback',
                                  'response_type' => 'code',
                                  'scope'         => '',
                              ]);

    return redirect(config('auth.server').'/oauth/authorize?' . $query);
});

Route::get('/callback', function (\Illuminate\Http\Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post(config('auth.server').'/oauth/token', [
        'form_params' => [
            'grant_type'    => 'authorization_code',
            'client_id'     => '1',
            'client_secret' => 'DLyKBQZzuGKFnl4B7VxmtYezdwNtdJhCFWzSdRG4',
            'redirect_uri'  => 'http://localhost:888/callback',
            'code'          => $request->code,
        ],
    ]);

    // get true access token from response
    $response = json_decode((string)$response->getBody(), true);
    if (! empty($response)) {
        $jwt                      = $response['access_token'];
        $sections                 = explode('.', $jwt);
        $jwt_header               = base64_decode($sections[0]);
        $response['access_token'] = json_decode($jwt_header, true)['jti'];
    }

    return $response;
});
