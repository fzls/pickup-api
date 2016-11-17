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

class InvalidApiTokenException extends Exception implements Jsonable {
    public $meta;
    public $data;

    /**
     * InvalidApiTokenException constructor.
     *
     * @param $meta
     * @param $data
     */
    public function __construct($meta, $data=null) {
        $this->meta = $meta;
        $this->data = $data;
    }


    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 0) {
        return json_encode([
            'meta'=>$this->meta,
            'data'=>$this->data,
                           ]);
    }}