<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id')
                  ->comment('继承自认证服务器(当利用token去服务器取回有效用户，发现该用户在本地不存在，则在本地创建该用户,并且将公共信息加入缓存中user_id->common_info)');
            $table->unsignedInteger('school_id')
                  ->comment('学校id');
            $table->text('description')->nullable()
                  ->comment('自我介绍');
            $table->decimal('money', 13, 4)
                  ->comment('余额');
            $table->unsignedInteger('checkin_points')
                  ->comment('签到赠送的积分，可在购买礼物时使用(1000积分等于1RMB，每次赠送100~500(暂定))');
            $table->unsignedInteger('charm_points')
                  ->comment('魅力值 //仅更新，和当redis中无该记录时取回');
            $table->timestamp('freezed_at')->nullable()->default(null)
                  ->comment('冻结于');
            $table->softDeletes()
                  ->comment('注销于');
            $table->timestamps();

            /* 索引 */
            $table->primary('id');
//            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('users');
    }
}
