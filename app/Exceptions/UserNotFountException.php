<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-23
 * Time: 17:32
 */

namespace PickupApi\Exceptions;


class UserNotFountException extends PickupApiException {
    public function __construct($code = 404, $message = null) {
        $default_message = '大哥哥我不认识你欸，试试 post ' . \Request::getHttpHost() . '/users，让我知道你是谁哦~';

        parent::__construct($code, $message ?: $default_message);
    }
}