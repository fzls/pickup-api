<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorySnapshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_snapshots', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('history_id')
                ->comment('快照所属行程id');
            $table->decimal('latitude',config('app.gps_precision.total'),config('app.gps_precision.digits'))
                ->comment('纬度');
            $table->decimal('longitude',config('app.gps_precision.total'),config('app.gps_precision.digits'))
                ->comment('经度');
            $table->timestamps();

//            $table->foreign('history_id')->references('id')->on('history');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_snapshots');
    }
}
