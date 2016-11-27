<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-27
 * Time: 11:50
 */

namespace PickupApi\Exceptions;


class InvalidOperationException extends PickupApiException {
    public function __construct($message='无法进行这个操作的说', $code=400) { parent::__construct($code, $message); }

}