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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/artisan',function (){
   Artisan::call('db:seed');
});

/*RE: 测试新功能区域*/
Route::get('test', function (\Illuminate\Http\Request $request) {
    $school = School::find($request->get('id'));
    var_dump($school->toArray());
    var_dump($school->users->toArray());
});

//RE: 下面的代码作为测试本API的消费者，在生产环境中应该注释掉
Route::get('/redirect', function () {
    $query = http_build_query([
                                  'client_id'     => '4',
                                  'redirect_uri'  => 'http://localhost:888/callback',
                                  'response_type' => 'code',
                                  'scope'         => '',
                              ]);

    return redirect('http://www.chenji-meow.cn:32783/oauth/authorize?' . $query);
});

Route::get('/callback', function (\Illuminate\Http\Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://www.chenji-meow.cn:32783/oauth/token', [
        'form_params' => [
            'grant_type'    => 'authorization_code',
            'client_id'     => '4',
            'client_secret' => 'rTMVPN5GvXVsmM2erSeRMPzMI0ldEED4Q1fpypJt',
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
