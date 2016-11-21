<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sender_id')
                  ->comment('发送者id');
            $table->unsignedInteger('receiver_id')
                  ->comment('接收者id');
            $table->text('content')
                  ->comment('消息内容');
            $table->timestamp('recalled_at')->nullable()
                  ->comment('召回于');
            $table->softDeletes()
                  ->comment('删除于');
            $table->timestamps();

//            $table->foreign('sender_id')->references('id')->on('users');
//            $table->foreign('receiver_id')->references('id')->on('users');
            $table->index(['sender_id', 'receiver_id', 'deleted_at', 'recalled_at', 'created_at'],'chats_search_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('chats');
    }
}
