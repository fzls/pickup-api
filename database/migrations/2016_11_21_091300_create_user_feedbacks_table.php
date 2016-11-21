<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_feedback_session_id')
                ->comment('用户反馈单号');
            $table->unsignedInteger('user_id')
                ->comment('用户id，可能是反馈的用户，也可以是回复的客服的用户id{比如1}');
            $table->text('content')
                ->comment('内容');
            $table->timestamps();

//            $table->foreign('user_feedback_session_id')->references('id')->on('user_feedback_sessions');
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
        Schema::dropIfExists('user_feedbacks');
    }
}
