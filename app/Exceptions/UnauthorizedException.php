<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-27
 * Time: 11:46
 */

namespace PickupApi\Exceptions;


class UnauthorizedException extends PickupApiException {
    public function __construct($message='主人不能碰别人的东西哟', $code=403) {
        parent::__construct($code, $message);
    }

}