<?php

namespace PickupApi\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Exceptions\UnauthorizedException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\History;
use PickupApi\Models\HistorySnapshot;
use PickupApi\Utils\TokenUtil;

/**
 * Class HistoryController
 * @package PickupApi\Http\Controllers
 */
class HistoryController extends Controller {
    /**
     * 获取用户的历史行程
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\UserNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getAllHistory() {
        return RestResponse::paginated(TokenUtil::getUser()->history()->getQuery()->with(['gift_bundles.gift', 'reviews']));
    }

    /**
     * 获取用户的某次历史行程
     *
     * @param History $history
     *
     * @return RestResponse
     */
    public function getHistory(History $history) {
        $this->assertIsPassenger($history);

        return RestResponse::single($history);
    }

    /**
     * 完成一次行程
     *
     * @param History $history
     *
     * @return RestResponse
     */
    public function finishHistory(History $history) {
        $this->assertIsPassenger($history);

        /*TODO：客户端发送两种费用*/
        $history->update(['finished_at' => Carbon::now()]);

        return RestResponse::meta_only(200, '又结束了一次旅行了呢');
    }

    /**
     * 获取所有的出车行程
     *
     * @return RestResponse
     * @throws \PickupApi\Exceptions\UserNotFoundException
     * @throws \InvalidArgumentException
     */
    public function getAllDriveHistory() {
        return RestResponse::paginated(TokenUtil::getUser()->drive_history()->getQuery()->with(['gift_bundles.gift', 'reviews']));
    }

    /**
     * 获取用户的某次出车行程
     *
     * @param History $history
     *
     * @return RestResponse
     */
    public function getDriveHistory(History $history) {
        $this->assertIsDriver($history);

        return RestResponse::single($history);
    }

    /**
     * 获取某次行程的快照集
     *
     * @param History $history
     *
     * @return RestResponse
     * @throws \InvalidArgumentException
     */
    public function getSnapshots(History $history) {
        $this->assertIsInHistory($history);

        return RestResponse::paginated($history->snapshots()->getQuery());
    }

    /**
     * 添加一个新的行程快照
     *
     * @param History $history
     *
     * @return RestResponse
     */
    public function addNewSnapshot(History $history) {
        /*由司机端负责创建*/
        $this->assertIsDriver($history);

        $this->validate(
            $this->request,
            [
                'latitude'  => 'required|numeric|min:-180|max:180',
                'longitude' => 'required|numeric|min:-90|max:90',
            ]
        );

        $snapshot = HistorySnapshot::firstOrCreate(
            array_merge(
                $this->request->only('latitude'),
                [
                    'history_id' => $history->id,
                ]
            )
        );

        return RestResponse::single($snapshot);
    }

    /**
     * 确保当前用户参与了该行程
     *
     * @param History $history
     *
     * @throws \PickupApi\Exceptions\UnauthorizedException
     */
    public function assertIsInHistory(History $history) {
        $this->assertIdentity([$history->passenger_id, $history->driver_id]);
    }

    /**
     * 确保当前用户作为乘客参与了该行程
     *
     * @param History $history
     *
     * @throws \PickupApi\Exceptions\UnauthorizedException
     */
    public function assertIsPassenger(History $history) {
        $this->assertIdentity($history->passenger_id);
    }

    /**
     * 确保当前用户作为司机参与了该行程
     *
     * @param History $history
     *
     * @throws \PickupApi\Exceptions\UnauthorizedException
     */
    public function assertIsDriver(History $history) {
        $this->assertIdentity($history->driver_id);
    }

    /**
     * 确认用户具有查看该记录的权限
     *
     * @param $id
     *
     * @throws UnauthorizedException
     */
    public function assertIdentity($id) {
        $allowed = false;
        $user_id = TokenUtil::getUserId();

        foreach (collect($id) as $_id) {
            if ($user_id === $_id) {
                $allowed = true;
            }
        }

        if (! $allowed) {
            throw new UnauthorizedException();
        }
    }
}
