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
use PickupApi\Models\FrequentlyUsedLocation;
use PickupApi\Models\School;
use PickupApi\Models\User;

$factory->define(User::class , function (Faker\Generator $faker){
    return [
        'id'=>$faker->unique()->randomNumber(4),
        /* RE:如果单独生成该类，则需要指定外键的值，若从school附加生成该类，则无需指定*/
        'school_id' => $faker->randomNumber(),/*如果单独生成该类，则覆盖其为 => factory(School::class)->create()->id*/
        'description'=>$faker->text(),
        'money'=>$faker->randomNumber(3),
        'checkin_points'=>$faker->randomNumber(4),
        'charm_points'=>$faker->randomNumber(4),
    ];
});

$factory->define(School::class , function (Faker\Generator $faker){
    return [
        'name'=>$faker->name,
        'description'=>$faker->text()
    ];
});

$factory->define(FrequentlyUsedLocation::class , function (Faker\Generator $faker){
    return [
        'user_id'=>$faker->randomNumber(),
        'name'=>$faker->name,
        'latitude'=>$faker->latitude,
        'longitude'=>$faker->longitude,
    ];
});

/*TODO: start from vehicle_types*/

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
//$factory->define(FrequentlyUsedLocation::class , function (Faker\Generator $faker){
//    return [
//        'name'=>$faker->name,
//        'description'=>$faker->text()
//    ];
//});