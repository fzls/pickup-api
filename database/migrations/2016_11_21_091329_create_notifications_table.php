<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('receiver_id')
                  ->comment('接收者id');
            $table->text('content')
                  ->comment('通知内容');
            $table->timestamp('read_at')->nullable()
                  ->comment('已读于');
            $table->softDeletes();
            $table->timestamps();

//            $table->foreign('receiver_id')->references('id')->on('users');
            $table->index(['receiver_id', 'deleted_at', 'read_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('notifications');
    }
}
