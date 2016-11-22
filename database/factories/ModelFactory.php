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

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'id'             => $faker->unique()->randomNumber(4),
        /* RE:如果单独生成该类，则需要指定外键的值，若从school附加生成该类，则无需指定*/
        'school_id'      => $faker->randomNumber(),/*如果单独生成该类，则覆盖其为 => factory(School::class)->create()->id*/
        'description'    => $faker->text(),
        'money'          => $faker->randomNumber(3),
        'checkin_points' => $faker->randomNumber(4),
        'charm_points'   => $faker->randomNumber(4),
    ];
});

$factory->define(School::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->company,
        'description' => $faker->text(),
    ];
});

$factory->define(FrequentlyUsedLocation::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => $faker->randomNumber(),
        'name'      => $faker->address,
        'latitude'  => $faker->latitude,
        'longitude' => $faker->longitude,
    ];
});

$factory->define(VehicleType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->lastName,
    ];
});

$factory->define(Vehicle::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'type_id' => $faker->randomNumber(),
        'name'    => $faker->firstName,
        'pic'     => $faker->imageUrl(),
    ];
});

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
        'distance'        => $faker->randomFloat(6),
        'elapsed_time'    => random_int(0, 3600),
        'base_amount'     => $faker->randomNumber(),
        'gift_amount'     => $faker->randomNumber(),
        'penalty_amount'  => $faker->randomNumber(),
        'started_at'      => $faker->randomElements([null, Carbon::now()]),
        'finished_at'     => $faker->randomElements([null, Carbon::now()]),
        'paid_at'         => $faker->randomElements([null, Carbon::now()]),
        'reserved_at'     => $faker->randomElements([null, Carbon::now()]),
        'canceled_at'     => $faker->randomElements([null, Carbon::now()]),
    ];
});

$factory->define(HistorySnapshot::class, function (Faker\Generator $faker) {
    return [
        'history_id' => $faker->randomNumber(),
        'latitude'   => $faker->latitude,
        'longitude'  => $faker->longitude,
    ];
});


$factory->define(Recharge::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'amount'  => $faker->randomNumber(3),
    ];
});

$factory->define(Withdraw::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'amount'  => $faker->randomNumber(3),
    ];
});

$factory->define(GiftCategory::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->lastName,
        'description' => $faker->text(),
        'pic'         => $faker->imageUrl(),
        'price'       => $faker->randomNumber(1),
    ];
});

$factory->define(GiftBundle::class, function (Faker\Generator $faker) {
    return [
        'history_id' => $faker->randomNumber(),
        'gift_id'    => $faker->randomNumber(),
        'amount'     => $faker->randomNumber(),
    ];
});

$factory->define(Review::class, function (Faker\Generator $faker) {
    return [
        'history_id'  => $faker->randomNumber(),
        'reviewer_id' => $faker->randomNumber(),
        'reviewee_id' => $faker->randomNumber(),
        'rating'      => random_int(0, 5),
        'comment'     => $faker->realText(),
    ];
});

$factory->define(UserFeedbackSession::class, function (Faker\Generator $faker) {
    return [
        'type_id'      => $faker->randomNumber(),
        'user_id'      => $faker->randomNumber(),
        'title'        => $faker->title,
        'content'      => $faker->realText(),
        'processed_at' => $faker->randomElements([null, Carbon::now()]),
        'finished_at'  => $faker->randomElements([null, Carbon::now()]),
    ];
});

$factory->define(UserFeedback::class, function (Faker\Generator $faker) {
    return [
        'user_feedback_session_id' => $faker->randomNumber(),
        'user_id'                  => $faker->randomNumber(),
        'content'                  => $faker->realText(),
    ];
});

$factory->define(UserFeedbackType::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->realText(10),
        'description' => $faker->realText(),
    ];
});

$factory->define(Chat::class, function (Faker\Generator $faker) {
    return [
        'sender_id'   => $faker->randomNumber(),
        'receiver_id' => $faker->randomNumber(),
        'content'     => $faker->realText(),
        'recalled_at' => $faker->randomElements([null, Carbon::now()]),
        'deleted_at'  => $faker->randomElements([null, Carbon::now()]),
    ];
});

$factory->define(Notification::class, function (Faker\Generator $faker) {
    return [
        'receiver_id' => $faker->randomNumber(),
        'content'     => $faker->realText(),
        'read_at'     => $faker->randomElements([null, Carbon::now()]),
        'deleted_at'  => $faker->randomElements([null, Carbon::now()]),
    ];
});

$factory->define(CheckinHistory::class, function (Faker\Generator $faker) {
    return [
        'user_id'         => $faker->randomNumber(),
        'obtained_credit' => $faker->randomNumber(3),
    ];
});

//$factory->define(FrequentlyUsedLocation::class , function (Faker\Generator $faker){
//    return [
//        'name'=>$faker->name,
//        'description'=>$faker->text()
//    ];
//});

//$factory->define(FrequentlyUsedLocation::class , function (Faker\Generator $faker){
//    return [
//        'name'=>$faker->name,
//        'description'=>$faker->text()
//    ];
//});