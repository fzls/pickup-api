<?php

namespace PickupApi\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use PickupApi\Exceptions\PickupApiException;
use PickupApi\Http\RestResponse;
use PickupApi\Models\History;
use PickupApi\Models\HistorySnapshot;
use PickupApi\Utils\TokenUtil;

class HistoryController extends Controller
{
    public function getAllHistory(){
        return RestResponse::paginated(TokenUtil::getUser()->history()->getQuery());
    }

    public function getHistory(History $history){
        $this->assertIsPassenger($history);

        return RestResponse::single($history);
    }

    public function finishHistory(History $history){
        $this->assertIsPassenger($history);

        $history->update(['finished_at'=>Carbon::now()]);
        return RestResponse::meta_only(200, '又结束了一次旅行了呢');
    }

    public function getAllDriveHistory(){
        return RestResponse::paginated(TokenUtil::getUser()->drive_history()->getQuery());
    }

    public function getDriveHistory(History $history){
        $this->assertIsDriver($history);

        return RestResponse::single($history);
    }

    public function getSnapshots(History $history){
        $this->assertIsInHistory($history);

        return RestResponse::paginated($history->snapshots()->getQuery());
    }

    public function addNewSnapshot(History $history){
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
                $this->request->all(),/*FIXME: 所有的创建使用的参数都显式调用，而不是直接用all*/
                                        /*比如用 $this->request->only(['latitude', 'longitude'])*/

                [
                    'history_id'=>$history->id,
                ]
            )
        );

        return RestResponse::single($snapshot);
    }

    public function assertIsInHistory(History $history){
        $this->assertIdentity([$history->passenger_id, $history->driver_id]);
    }

    public function assertIsPassenger(History $history){
        $this->assertIdentity($history->passenger_id);
    }

    public function assertIsDriver(History $history){
        $this->assertIdentity($history->driver_id);
    }

    public function assertIdentity($id){
        $allowed = false;
        $user_id = TokenUtil::getUserId();

        foreach (collect($id) as $_id){
            if($user_id === $_id){
                $allowed = true;
            }
        }

        if(! $allowed){
            throw new PickupApiException(403 ,"主人不能偷看别人的东西的呢");
        }
    }
}
