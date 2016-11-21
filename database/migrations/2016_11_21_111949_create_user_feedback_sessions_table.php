<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFeedbackSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_feedback_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_feedback_id')
                ->comment('用户反馈单号');
            $table->unsignedInteger('user_id')
                ->comment('用户id，可能是反馈的用户，也可以是回复的客服的用户id{比如1}');
            $table->text('content')
                ->comment('会话内容');
            $table->timestamps();

//            $table->foreign('user_feedback_id')->references('id')->on('user_feedbacks');
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
        Schema::dropIfExists('user_feedback_sessions');
    }
}
