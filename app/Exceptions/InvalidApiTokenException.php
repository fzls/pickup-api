<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-07
 * Time: 19:48
 */

namespace PickupApi\Exceptions;



use Exception;
use Illuminate\Contracts\Support\Jsonable;
use PickupApi\Http\Meta;
use PickupApi\Http\RestResponse;

class InvalidApiTokenException extends Exception implements Jsonable {
    /**
     * @var Meta $meta
     */
    public $meta;

    /**
     * InvalidApiTokenException constructor.
     *
     * @param $meta
     * @param $data
     */
    public function __construct($meta) {
        $this->meta = $meta;
    }


    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 0) {
        return RestResponse::exception($this->meta->getCode(),$this->meta->getMessage())->toJson();
    }}