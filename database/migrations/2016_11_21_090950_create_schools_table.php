<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->comment('学校名称');
            $table->text('description')->nullable()
                  ->comment('学校简介');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('schools');
    }
}
