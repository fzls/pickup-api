<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
                ->comment('用户id');
            $table->unsignedInteger('obtained_credit')
                ->comment('本次签到获得的积分数目');
            $table->timestamps();

//            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkin_history');
    }
}
