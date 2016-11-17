<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-07
 * Time: 18:20
 */

namespace PickupApi\Http;


use Illuminate\Contracts\Support\Jsonable;

class RestResponse implements Jsonable {
    /**
     * @var Meta
     */
    public $meta;

    public $data;

    public $pagination;

    /**
     * RestResponse constructor.
     *
     * @param $meta
     * @param $data
     * @param $pagination
     */
    public function __construct($meta, $data=null, $pagination=null) {
        $this->meta       = $meta;
        $this->data       = $data;
        $this->pagination = $pagination;
    }

    /**
     * @return mixed
     */
    public function getMeta() {
        return $this->meta;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getPagination() {
        return $this->pagination;
    }


    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     *
     * @return string
     */
    public function toJson($options = 0) {
        return json_encode(
            [
                'meta'       => $this->meta,
                'data'       => $this->data,
                'pagination' => $this->pagination,
            ]
        );
    }
}