<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-23
 * Time: 17:22
 */

namespace PickupApi\Exceptions;


use Illuminate\Contracts\Support\Jsonable;
use PickupApi\Http\RestResponse;

class PickupApiException extends \Exception implements Jsonable {
    /**
     * PickupApiException constructor.
     *
     * @param int    $code
     * @param string $message
     */
    public function __construct($code=404, $message='Meow? 主人様要找的东西不见啦~') {
        $this->code=$code;
        $this->message=$message;
    }


    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 0) {
        return RestResponse::exception($this->getCode(),$this->getMessage())->toJson();
    }}