<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Carbon\Carbon;
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

/**
 * 通过随机掷骰子确定该timestamp字段是否应设为当前值或null
 *
 * @param $ratio
 *
 * @return null|Carbon
 */
function set_current_time_if_win_lottery($ratio = 0.1) {
    return random_int(0, 100) <= $ratio * 100 ? Carbon::now() : null;
}

/*用户*/
$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'id'             => $faker->unique()->randomNumber(4),
        'username'       => $faker->userName,
        'email'          => $faker->email,
        'phone'          => $faker->phoneNumber,
        'avatar'         => $faker->imageUrl(),
        /* RE:如果单独生成该类，则需要指定外键的值，若从school附加生成该类，则无需指定*/
        'school_id'      => $faker->randomNumber(),/*如果单独生成该类，则覆盖其为 => factory(School::class)->create()->id*/
        'description'    => $faker->realText(),
        'money'          => $faker->randomNumber(3),
        'checkin_points' => $faker->randomNumber(4),
        'charm_points'   => $faker->randomNumber(4),
        'freezed_at'     => set_current_time_if_win_lottery(),
        'deleted_at'     => set_current_time_if_win_lottery(),
    ];
});

/*学校*/
$factory->define(School::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->company,
        'description' => $faker->realText(),
    ];
});

/*常用地点*/
$factory->define(FrequentlyUsedLocation::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => $faker->randomNumber(),
        'name'      => $faker->address,
        'latitude'  => $faker->latitude,
        'longitude' => $faker->longitude,
    ];
});

/*车辆类型*/
$factory->define(VehicleType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->lastName,
    ];
});

/*车辆*/
$factory->define(Vehicle::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'type_id' => $faker->randomNumber(),
        'name'    => $faker->firstName,
        'pic'     => $faker->imageUrl(),
    ];
});

/*历史行程*/
$factory->define(History::class, function (Faker\Generator $faker) {
    return [
        'passenger_id'    => $faker->randomNumber(),
        'driver_id'       => $faker->randomNumber(),
        'start_name'      => $faker->address,
        'start_latitude'  => $faker->latitude,
        'start_longitude' => $faker->longitude,
        'end_name'        => $faker->address,
        'end_latitude'    => $faker->latitude,
        'end_longitude'   => $faker->longitude,
        'distance'        => $faker->randomNumber(3),// 单位是km
        'elapsed_time'    => random_int(0, 3600),
        'base_amount'     => $faker->randomNumber(3),
        'gift_amount'     => $faker->randomNumber(2),
        'penalty_amount'  => $faker->randomNumber(2),
        'started_at'      => set_current_time_if_win_lottery(),
        'finished_at'     => set_current_time_if_win_lottery(),
        'paid_at'         => set_current_time_if_win_lottery(),
        'reserved_at'     => set_current_time_if_win_lottery(),
        'canceled_at'     => set_current_time_if_win_lottery(),
    ];
});

/*行程快照*/
$factory->define(HistorySnapshot::class, function (Faker\Generator $faker) {
    return [
        'history_id' => $faker->randomNumber(),
        'latitude'   => $faker->latitude,
        'longitude'  => $faker->longitude,
    ];
});

/*充值订单*/
$factory->define(Recharge::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'amount'  => $faker->randomNumber(3),
    ];
});

/*提现订单*/
$factory->define(Withdraw::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'amount'  => $faker->randomNumber(3),
    ];
});

/*礼品类别*/
$factory->define(GiftCategory::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->lastName,
        'description' => $faker->realText(),
        'pic'         => $faker->imageUrl(),
        'price'       => $faker->randomNumber(1),
    ];
});

/*礼品包*/
$factory->define(GiftBundle::class, function (Faker\Generator $faker) {
    return [
        'history_id'   => $faker->randomNumber(),
        'passenger_id' => $faker->randomNumber(),
        'driver_id'    => $faker->randomNumber(),
        'gift_id'      => $faker->randomNumber(),
        'amount'       => $faker->randomNumber(2),
    ];
});

/*评论与评价*/
$factory->define(Review::class, function (Faker\Generator $faker) {
    return [
        'history_id'  => $faker->randomNumber(),
        'reviewer_id' => $faker->randomNumber(),
        'reviewee_id' => $faker->randomNumber(),
        'rating'      => random_int(0, 5),
        'comment'     => $faker->realText(),
    ];
});

/*用户反馈会话*/
$factory->define(UserFeedbackSession::class, function (Faker\Generator $faker) {
    return [
        'type_id'      => $faker->randomNumber(),
        'user_id'      => $faker->randomNumber(),
        'title'        => $faker->title,
        'content'      => $faker->realText(),
        'rating'       => random_int(0, 5),
        'processed_at' => set_current_time_if_win_lottery(),
        'finished_at'  => set_current_time_if_win_lottery(),
    ];
});

/*用户反馈对话*/
$factory->define(UserFeedback::class, function (Faker\Generator $faker) {
    return [
        'user_feedback_session_id' => $faker->randomNumber(),
        'user_id'                  => $faker->randomNumber(),
        'content'                  => $faker->realText(),
    ];
});

/*用户反馈类型*/
$factory->define(UserFeedbackType::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->realText(10),
        'description' => $faker->realText(),
    ];
});

/*用户聊天*/
$factory->define(Chat::class, function (Faker\Generator $faker) {
    return [
        'sender_id'   => $faker->randomNumber(),
        'receiver_id' => $faker->randomNumber(),
        'content'     => $faker->realText(),
        'recalled_at' => set_current_time_if_win_lottery(),
        'deleted_at'  => set_current_time_if_win_lottery(),
    ];
});

/*系统通知*/
$factory->define(Notification::class, function (Faker\Generator $faker) {
    return [
        'receiver_id' => $faker->randomNumber(),
        'content'     => $faker->realText(),
        'read_at'     => set_current_time_if_win_lottery(),
        'deleted_at'  => set_current_time_if_win_lottery(),
    ];
});

/*签到信息*/
$factory->define(CheckinHistory::class, function (Faker\Generator $faker) {
    return [
        'user_id'         => $faker->randomNumber(),
        'obtained_credit' => $faker->randomNumber(3),
    ];
});

//$factory->define(FrequentlyUsedLocation::class , function (Faker\Generator $faker){
//    return [
//        'name'=>$faker->name,
//        'description'=>$faker->realText()
//    ];
//});

//$factory->define(FrequentlyUsedLocation::class , function (Faker\Generator $faker){
//    return [
//        'name'=>$faker->name,
//        'description'=>$faker->realText()
//    ];
//});