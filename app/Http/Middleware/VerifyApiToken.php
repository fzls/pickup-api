<?php

namespace PickupApi\Http\Middleware;

use Carbon\Carbon;
use Closure;
use GuzzleHttp\Client;
use PickupApi\Exceptions\InvalidApiTokenException;
use PickupApi\Http\Meta;
use PickupApi\Http\RestResponse;
/* 先去进行容器化，从而避免在xampp中从api处调用auth服务器时共享一个.env，而导致数据库的存取出现错误
TODO: 完成容器化-----验证token是否有效（验证身份）-----验证token是否可以进行某项操作，即scope（验证权限）
NOTE: api服务器是生产者，不需要client id，只需要验证token，不需要负责获取token
*/

/**
 * Class VerifyApiToken
 * @package PickupApi\Http\Middleware
 */
class VerifyApiToken {
    /**
     * @var string
     */
    public $token_uri;

    /**
     * VerifyApiToken constructor.
     *
     */
    public function __construct() {
        $this->token_uri = \Config::get('auth.server') . '/oauth/tokens';
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     * @throws InvalidApiTokenException
     */
    public function handle($request, Closure $next) {
        /*检查token是否有效，若无效则提示客户端去认证服务器获取token*/
        if (! $this->isValid($request->bearerToken())) {
            throw new InvalidApiTokenException();
        }

        return $next($request);
    }

    /**
     * 检测token是否有效
     *
     * @param $token
     *
     * @return bool
     */
    public function isValid($token) {
        /*检测是否为空*/
        if (empty($token)) {
            return false;
        }

        /*向认证服务器查询token信息，并缓存查询结果*/
        $token_info = \Cache::remember($token, 10, function () use ($token) {
            $http = new Client();

            return json_decode($http->get($this->token_uri . '/' . $token)->getBody(), true);
        });

        /*检查token的有效性*/
        if (empty($token_info) || $token_info["revoked"] || $this->expired($token_info['expires_at'])) {
            return false;
        }

        return true;
    }

    /**
     * 检测token是否过期
     *
     * @param $expires_at
     *
     * @return bool
     */
    public function expired($expires_at){
        $expires_at = new Carbon($expires_at);
        return Carbon::now()->gt($expires_at);
    }
}
