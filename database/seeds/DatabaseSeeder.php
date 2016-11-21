<?php

use Illuminate\Database\Seeder;
use PickupApi\Models\FrequentlyUsedLocation;
use PickupApi\Models\School;
use PickupApi\Models\User;

/*TODO : uncomment all forign keys*/

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // $this->call(UsersTableSeeder::class);
        factory(School::class, 10)
            ->create()
            ->each(function ($school) {
                /* @var $school School */
                $school->users()->save(factory(User::class)->make());
            });
//        factory(User::class, 10)->create([
//                                             'school_id' => function(){
//                                                 return factory(School::class)->create()->id;
//                                             },
//                                         ]);
    }
}
