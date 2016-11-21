<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFeedbackTypesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_feedback_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->comment('反馈类型名称，如投诉用户，bug反馈，新功能建议，功能咨询等');
            $table->text('description')
                  ->comment('补充说明');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('user_feedback_types');
    }
}
