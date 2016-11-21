<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('history_id')
                ->comment('评论对应行程id');
            $table->unsignedInteger('reviewer_id')
                ->comment('评论者id');
            $table->unsignedInteger('reviewee_id')
                ->comment('被评论者id');
            $table->integer('rating')
                ->comment('评分');
            $table->text('comment')
                ->comment('评论');
            $table->timestamps();

//            $table->foreign('history_id')->references('id')->on('history');
//            $table->foreign('reviewer_id')->references('id')->on('users');
//            $table->foreign('reviewee_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
