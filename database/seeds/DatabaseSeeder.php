<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use PickupApi\Models\Chat;
use PickupApi\Models\CheckinHistory;
use PickupApi\Models\FrequentlyUsedLocation;
use PickupApi\Models\GiftBundle;
use PickupApi\Models\GiftCategory;
use PickupApi\Models\History;
use PickupApi\Models\HistorySnapshot;
use PickupApi\Models\Notification;
use PickupApi\Models\Recharge;
use PickupApi\Models\Review;
use PickupApi\Models\School;
use PickupApi\Models\User;
use PickupApi\Models\UserFeedback;
use PickupApi\Models\UserFeedbackSession;
use PickupApi\Models\UserFeedbackType;
use PickupApi\Models\Vehicle;
use PickupApi\Models\VehicleType;
use PickupApi\Models\Withdraw;

/*TODO : uncomment all forign keys*/

class DatabaseSeeder extends Seeder {
    private $faker;

    public function __construct(Faker\Generator $faker) {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        /*TODO: 在config文件中设置相应的设置，并从那边获取这些配置*/
        $cnt_school=3;
        $cnt_vehicle_type=3;
        $cnt_gift_category=10;
        $cnt_feedback_type=5;
        $cnt_user = 5;
        $cnt_vehicle_per_user=2;
        $cnt_frequent_used_location_per_user=3;
        $cnt_recharge_per_user=5;
        $cnt_withdraw_per_user=2;
        $cnt_feedback_session_per_user=2;
        $cnt_feedback_per_session_per_user=5;
        $cnt_notification_per_user=6;
        $cnt_checkin_history_per_user=8;
        $cnt_chat=100;
        $cnt_history=30;
        $cnt_snapshot_per_history=10;
        $cnt_gift_bundle_per_history=3;
        $percent_passenger_review=80;
        $percent_driver_review=30;


        // $this->call(UsersTableSeeder::class);
        /*按照拓扑排序进行实体的初始化，及其关系定义*/
        /*RE： Layer 1*/
        /*创建学校*/
        $schools = factory(School::class, $cnt_school)->create();

        /*创建车辆类型*/
        $vehicle_types = factory(VehicleType::class, $cnt_vehicle_type)->create();

        /*创建礼物种类*/
        $gift_categories = factory(GiftCategory::class, $cnt_gift_category)->create();

        /*创建反馈类型*/
        $user_feedback_types = factory(UserFeedbackType::class, $cnt_feedback_type)->create();

        /*RE： Layer 2*/
        /*创建用户，并将他们分配到不同的学校*/
        $users = factory(User::class, $cnt_user)->create(
            [
                'school_id' => function () use ($schools) {
                    return $schools->random()->id;
                },
            ]
        );
        /*添加一个用于测试的用户，其id为1*/
        $users []= factory(User::class)->create(
            [
                'id'=>1,
                'school_id'=> function () use ($schools) {
                    return $schools->random()->id;
                },
            ]
        );

        /*RE： Layer 3*/
        foreach ($users as $user) {
            /* @var $user User */
            /*为每个用户添加车，其类型为之前创建的车辆类型之一*/
            $user->vehicles()->saveMany(factory(Vehicle::class, $cnt_vehicle_per_user)->make(
                [
                    'type_id' => function () use ($vehicle_types) {
                        return $vehicle_types->random()->id;
                    },
                ]
            ));
            /*为每个用户添加常用地点*/
            $user->frequent_used_locations()->saveMany(factory(FrequentlyUsedLocation::class, $cnt_frequent_used_location_per_user)->make());
            /*为每个用户添加充值订单*/
            $user->recharges()->saveMany(factory(Recharge::class, $cnt_recharge_per_user)->make());
            /*为每个用户添加提现订单*/
            $user->withdraws()->saveMany(factory(Withdraw::class, $cnt_withdraw_per_user)->make());
            /*为每个用户添加反馈会话*/
            $sessions = $user->feedback_sessions()->saveMany(factory(UserFeedbackSession::class, $cnt_feedback_session_per_user)->make(
                [
                    'type_id' => function () use ($user_feedback_types) {
                        return $user_feedback_types->random()->id;
                    },
                ]
            ));
            /*并为每次反馈会话添加对话记录*/
            foreach ($sessions as $session) {
                /* @var $session UserFeedbackSession */
                $session->feedbacks()->saveMany(factory(UserFeedback::class, $cnt_feedback_per_session_per_user)->make(
                    [
                        'user_id' => $user->id,
                    ]
                ));
                unset($session);
            }
            /*为用户添加系统消息*/
            $user->notifications()->saveMany(factory(Notification::class, $cnt_notification_per_user)->make());
            /*为用户添加签到记录*/
            $user->checkin_history()->saveMany(factory(CheckinHistory::class, $cnt_checkin_history_per_user)->make());
            /*清除本地变量*/
            unset($user);
            unset($sessions);
        }

        /*RE： Layer 4*/
        /*添加对话记录，每次记录随机指定之前创建的用户中的两名作为对话双方*/
        for ($i = 0; $i < $cnt_chat; ++$i) {
            list($sender, $receiver) = $users->random(2)->values();
            factory(Chat::class)->create(
                [
                    'sender_id'   => $sender->id,
                    'receiver_id' => $receiver->id,
                ]
            );
        }
        /*创建历史行程，每次行程随之指定两位用户分别作为司机与乘客*/
        $history       = [];
        for ($i = 0; $i < $cnt_history; ++$i) {
            list($passenger, $driver) = $users->random(2)->values();
            $history[] = factory(History::class)->create(
                [
                    'passenger_id' => $passenger->id,
                    'driver_id'    => $driver->id,
                ]
            );
        }

        foreach ($history as $h) {
            /* @var $h History */
            /*并为他们创建快照*/
            $h->snapshots()->saveMany(factory(HistorySnapshot::class, $cnt_snapshot_per_history)->make());
            /*并随机赠送多个礼物包*/
            $h->gift_bundles()->saveMany(factory(GiftBundle::class, $cnt_gift_bundle_per_history)->make(
                [

                    'gift_id' => function () use ($gift_categories) {
                        return $gift_categories->random()->id;
                    },
                ]
            ));
            /*并为这些行程分别依概率创建双向的评价与评论*/
            /*80% 乘客-->司机*/
            if (random_int(0, 100) <= $percent_passenger_review) {
                $h->reviews()->save(factory(Review::class)->make(
                    [
                        'reviewer_id' => $h->passenger_id,
                        'reviewee_id' => $h->driver_id,
                    ]
                ));
            }
            /*30% 司机-->乘客*/
            if (random_int(0, 100) < $percent_driver_review) {
                $h->reviews()->save(factory(Review::class)->make(
                    [
                        'reviewer_id' => $h->driver_id,
                        'reviewee_id' => $h->passenger_id,
                    ]
                ));
            }
        }
//        factory(User::class, 10)->create([
//                                             'school_id' => function(){
//                                                 return factory(School::class)->create()->id;
//                                             },
//                                         ]);
    }
}
