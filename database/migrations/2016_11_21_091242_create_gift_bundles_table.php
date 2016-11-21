<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftBundlesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('gift_bundles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('history_id')
                  ->comment('这个礼品包在哪次行程中送出');
            $table->unsignedInteger('gift_id')
                  ->comment('这个礼品包包含的礼品的id');
            $table->unsignedInteger('amount')
                  ->comment('这个礼品包包含的礼品的个数');
            $table->timestamps();

//            $table->foreign('history_id')->references('id')->on('history');
//            $table->foreign('gift_id')->references('id')->on('gift_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('gift_bundles');
    }
}
