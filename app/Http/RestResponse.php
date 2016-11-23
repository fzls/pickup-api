<?php
/**
 * Created by PhpStorm.
 * User: Chen
 * Date: 2016-11-07
 * Time: 18:20
 */

namespace PickupApi\Http;


use Illuminate\Contracts\Support\Jsonable;
use PickupApi\Models\User;

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

    /*定义一些常见的操作*/

    /**
     * 返回通用json结果的辅助函数
     *
     * @param null   $data
     * @param null   $pagination
     * @param int    $code
     * @param string $message
     *
     * @return static
     */
    public static function json($data=null, $pagination=null, $code=200, $message='主人，这是你要找的蓝白胖次哟~'){
        return new static(
            new Meta($code, $message),
            $data,
            $pagination
        );
    }

    /**
     * 返回发生错误情况下结果的辅助函数
     *
     * @param int    $code
     * @param string $message
     *
     * @return RestResponse
     */
    public static function error($code=404, $message='Meow? 主人様要找的东西不见啦~'){
        return self::json(null,null,$code,$message);
    }

    /**
     * 返回抛出异常情况下结果的辅助函数
     *
     * @param int    $code
     * @param string $message
     *
     * @return RestResponse
     */
    public static function exception($code=404, $message='Meow? 主人様要找的东西不见啦~'){
        return self::error($code,$message);
    }

    /**
     * 返回分页的数据
     *
     * @param $query \Illuminate\Database\Eloquent\Builder
     *
     * @return RestResponse
     * @throws \InvalidArgumentException
     */
    public static function paginated($query){
        /*TODO: 对于集合类资源，实现下列功能
                [ ] 选择
                [ ] 投影
                [ ] 排序
                [X] 分页
        */
        /*选择符合条件的集合*/
        $filter = \Request::input('filter');
        if($filter){
            self::filter($query,$filter);
        }

        /*投影所需的字段*/
        $projection = \Request::input('projection');
        if($projection){
            self::projection($query,$projection);
        }

        /*对结果进行排序*/
        $sort = \Request::input('sort');
        if($sort){
            self::sort($query,$sort);
        }

        /*获取每页数目*/
        $per_page =  \Request::input('per_page') ?: (new User())->getPerPage();
        /*获取当前页面的信息，并将系统默认的分页类结果改为数组类型*/
        $data_with_pagination = $query->paginate($per_page)->appends(compact('filter','projection','per_page','sort'))->toArray();
        /*将数据与分页情况分离*/
        $data = $data_with_pagination['data'];
        unset($data_with_pagination['data']);
        $pagination = $data_with_pagination;
        /*返回分离后的数据*/
        return self::json($data,$pagination);
    }

    private static function filter(&$query, $filter) {
        /*TODO: 添加搜索选择功能*/
    }

    private static function projection(&$query, $projection) {
        /*TODO：添加投影部分字段功能*/
    }

    private static function sort(&$query, $sort) {
        /*TODO：添加排序功能*/
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
    public function toJson($options = JSON_PRETTY_PRINT) {
        return json_encode(
            [
                'meta'       => $this->meta,
                'data'       => $this->data,
                'pagination' => $this->pagination,
            ],
            $options
        );
    }
}