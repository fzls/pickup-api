<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('passenger_id')
                  ->comment('乘客id');
            $table->unsignedInteger('driver_id')
                  ->comment('司机id');
            $table->string('start_name')->default('')
                  ->comment('起点名称');
            $table->decimal('start_latitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('起点纬度');
            $table->decimal('start_longitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('起点经度');
            $table->string('end_name')->default('')
                  ->comment('终点名称');
            $table->decimal('end_latitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('终点纬度');
            $table->decimal('end_longitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('终点经度');
            $table->decimal('distance', config('app.distance_precision.total'), config('app.distance_precision.digits'))->default(0)
                  ->comment('行程距离');
            $table->unsignedInteger('elapsed_time')->default(0)
                  ->comment('行程时间');
            $table->decimal('base_amount', config('app.money_precision.total'), config('app.money_precision.digits'))->default(0)
                  ->comment('基本金额');
            $table->decimal('gift_amount', config('app.money_precision.total'), config('app.money_precision.digits'))->default(0)
                  ->comment('额外礼物金额');
            $table->decimal('penalty_amount', config('app.money_precision.total'), config('app.money_precision.digits'))->default(0)
                  ->comment('超时未支付罚金');
            $table->timestamp('started_at')->nullable()
                  ->comment('开始于,若为null则表明未开始');
            $table->timestamp('finished_at')->nullable()
                  ->comment('结束于');
            $table->timestamp('paid_at')->nullable()
                  ->comment('支付于');
            $table->timestamp('reserved_at')->nullable()
                  ->comment('预约于');
            $table->timestamp('canceled_at')->nullable()
                  ->comment('取消于');
            $table->timestamps();

//            $table->foreign('passenger_id')->references('id')->on('users');
//            $table->foreign('driver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('history');
    }
}
