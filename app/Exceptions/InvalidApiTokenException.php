<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-07
 * Time: 19:48
 */

namespace PickupApi\Exceptions;

class InvalidApiTokenException extends PickupApiException {
    public $auth_uri;

    /**
     * InvalidApiTokenException constructor.
     *
     * @param $meta
     * @param $data
     */
    public function __construct($code = 401, $message=null) {
        $this->auth_uri  = \Config::get('auth.server') . '/oauth/authorize';
        $default_message = '你不是我认识的主人，哼！ 要不去 ' . $this->auth_uri . ' 让我认识一下你？';

        parent::__construct($code, $message ?: $default_message);
    }
}