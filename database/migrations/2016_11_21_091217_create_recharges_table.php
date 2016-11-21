<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechargesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('recharges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
                  ->comment('充值订单的用户id');
            $table->decimal('amount', config('app.money_precision.total'), config('app.money_precision.digits'))
                  ->comment('充值金额');
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
        Schema::dropIfExists('recharges');
    }
}
