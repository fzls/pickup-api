<?php

namespace PickupApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use PickupApi\Exceptions\InvalidOperationException;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Http\RestResponse;

/**
 * Class RankingController
 * @package PickupApi\Http\Controllers
 */
class RankingController extends Controller {
    /*获取某一种类型的排行榜{highest_rated_drivers, most_attractive_drivers, highest_rated_passengers}
    对象类别分三个，highest_rated_driver_rankings, most_attractive_driver_rankings, most_rated_passenger_rankings，
    时间段类别分过去一天，一周，一月，以及总排行，通过选择时间周期调整，默认显示一周的结果
    */
    /**
     * 获取所有的排行榜？ 是否有必要提供这个接口？TODO：视客户端需求而定
     */
    public function getAllRankings() {

    }

    /**
     * 获取某种类型的排行榜
     *
     * @param $type
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\InvalidOperationException
     * @internal param int $interval
     * @internal param int $count
     *
     */
    public function getRankingOfType($type) {
        $this->validate(
            $this->request,
            [
                'interval'=> 'integer|min:1',
                'count' => 'integer|min:1'
            ]
        );
        $interval = $this->request->exists('interval')? (int)$this->request->get('interval') : 7;
        $count = $this->request->exists('count')? (int)$this->request->get('count') : 10;

        $this->assertTypeIsValid($type);

        /*缓存时间=天数*5min*/
        $key     = $this->getCacheKey($type, $interval, $count);
        /*对结果进行一定时间的缓存，从而降低服务器压力*/
        $ranking = \Cache::remember($key, 5 * $interval, function () use ($type, $interval, $count) {
            $type = Str::studly($type);
            $function = "getRankingOf$type";

            return $this->$function($interval, $count);
        });

        return RestResponse::single_without_link($ranking);
    }

    /**
     * 获取风评最好的司机
     *
     * @param $interval
     * @param $count
     *
     * @return array
     */
    public function getRankingOfHighestRatedDrivers($interval, $count) {
        /*TODO: 用户表中添加name, email等信息（from oauth server）， 这样后续查询他人的相关信息可以得以实现*/
        $sql
            = 'SELECT
                      rate.average_rating,
                      users.*
                    FROM (
                           SELECT
                             driver_id,
                             avg(rating) AS average_rating
                           FROM reviews
                             JOIN history ON history_id = history.id
                           WHERE driver_id = reviewee_id AND reviews.created_at >= NOW() - INTERVAL ? DAY
                           GROUP BY driver_id
                           ORDER BY average_rating DESC
                           LIMIT ?
                         ) AS rate
                      JOIN users ON rate.driver_id = users.id;
                ';

        return \DB::select($sql, [$interval, $count]);
    }

    /**
     * 获取最有魅力的司机
     *
     * @param $interval
     * @param $count
     *
     * @return array
     */
    public function getRankingOfMostAttractiveDrivers($interval, $count) {
        $sql
            = 'SELECT
                  gift_ranking.total_value_of_gifts,
                  users.*
                FROM (
                       SELECT
                         driver_id,
                         sum(price * amount) AS total_value_of_gifts
                       FROM gift_bundles
                         JOIN gift_categories ON gift_id = gift_categories.id
                       WHERE gift_bundles.created_at >= NOW() - INTERVAL ? DAY
                       GROUP BY driver_id
                       ORDER BY total_value_of_gifts DESC
                       LIMIT ?
                     ) AS gift_ranking
                  JOIN users ON gift_ranking.driver_id = users.id;
              ';

        return \DB::select($sql, [$interval, $count]);
    }

    /**
     * 获取风评最好的乘客
     *
     * @param $interval
     * @param $count
     *
     * @return array
     */
    public function getRankingOfHighestRatedPassengers($interval, $count) {
        $sql
            = 'SELECT
                      rate.average_rating,
                      users.*
                    FROM (
                           SELECT
                             passenger_id,
                             avg(rating) AS average_rating
                           FROM reviews
                             JOIN history ON history_id = history.id
                           WHERE passenger_id = reviewee_id AND reviews.created_at >= NOW() - INTERVAL ? DAY
                           GROUP BY passenger_id
                           ORDER BY average_rating DESC
                           LIMIT ?
                         ) AS rate
                      JOIN users ON rate.passenger_id = users.id;
                ';

        return \DB::select($sql, [$interval, $count]);
    }

    /**
     * 获取排行榜的缓存key
     *
     * @param $type
     * @param $interval
     * @param $count
     *
     * @return string
     */
    public function getCacheKey($type, $interval, $count) {
        return "ranking_of_${type}_in_${interval}_days_with_count_of_$count";
    }

    /**
     * 确保支持该类型的排行榜
     *
     * @param $type
     *
     * @throws InvalidOperationException
     */
    public function assertTypeIsValid($type) {
        $types = config('app.ranking_types');
        if (! in_array($type, $types)) {
            throw new InvalidOperationException('人家不支持这种排行榜啦, 试试下面这些排行榜种类？ ' . implode(', ', $types));
        }
    }
}
