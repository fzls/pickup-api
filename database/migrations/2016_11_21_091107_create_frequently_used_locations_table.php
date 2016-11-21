<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrequentlyUsedLocationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('frequently_used_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
                  ->comment('该常用地点所属的用户的id');
            $table->string('name')
                  ->comment('常用地点的名称');
            $table->decimal('latitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('纬度');
            $table->decimal('longitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('经度');
            $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('frequently_used_locations');
    }
}
