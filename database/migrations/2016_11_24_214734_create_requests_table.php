<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
                ->comment('发出请求的用户的id');
            $table->string('start_name')->default('')
                  ->comment('出发地点名');
            $table->decimal('start_latitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('出发地点经度');
            $table->decimal('start_longitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('出发地点经度');
            $table->string('end_name')->default('')
                  ->comment('终点地名');
            $table->decimal('end_latitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('终点纬度');
            $table->decimal('end_longitude', config('app.gps_precision.total'), config('app.gps_precision.digits'))
                  ->comment('终点经度');
            $table->unsignedInteger('expected_vehicle_type')
                  ->comment('用户期待的车辆类型');
            $table->text('activity')
                  ->comment('活动');
            $table->string('phone_number')
                  ->comment('用户的联系方式');
            $table->decimal('estimated_cost', config("app.money_precision.total"), config("app.money_precision.digits"))->default(0)
                  ->comment('预计金额');
            $table->timestamp('reserved_at')->nullable()
                  ->comment('预约于');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('requests');
    }
}
