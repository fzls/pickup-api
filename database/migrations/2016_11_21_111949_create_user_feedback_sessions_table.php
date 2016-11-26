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
            $table->unsignedInteger('type_id')
                ->comment('反馈类型id');
            $table->unsignedInteger('user_id')
                ->comment('用户id');
            $table->string('title')
                ->comment('标题');
            $table->text('content')
                ->comment('内容');
            $table->timestamp('processed_at')->nullable()
                ->comment('处理于，由客服人员触发');
            $table->timestamp('finished_at')->nullable()
                ->comment('完成于，由用户触发');
            $table->integer('rating')->nullable()
                ->comment('用户对本次服务的评价');
            $table->timestamps();

//            $table->foreign('type_id')->references('id')->on('user_feedback_types');
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
