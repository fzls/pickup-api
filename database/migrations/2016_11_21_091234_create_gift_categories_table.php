<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()
                ->comment('礼物名称');
            $table->text('description')
                ->comment('礼物的详细介绍');
            $table->string('pic',config('app.max_url_length'))
                ->comment('礼物的图片');
            $table->decimal('price',config('app.money_precision.total'),config('app.money_precision.digits'))
                ->comment('礼物的价格');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gift_categories');
    }
}
