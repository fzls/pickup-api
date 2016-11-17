<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-07
 * Time: 18:28
 */

namespace PickupApi\Http;


use Illuminate\Contracts\Support\Jsonable;

class Meta implements Jsonable {
    /**
     * @var int
     */
    public $code;

    /**
     * @var string
     */
    public $message;

    /**
     * Meta constructor.
     *
     * @param $code
     * @param $message
     */
    public function __construct($code, $message) {
        $this->code    = $code;
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }


    public function toJson($options = 0) {
        return json_encode(
            [
                'code'=>$this->code,
                'message'=>$this->message,
            ]
        );
    }


}