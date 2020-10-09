<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name')->unique()->comment('ユーザー名');
            $table->string('profile_image')->nullable()->comment('プロフィール画像');
            $table->text('self_introduction')->nullable()->comment('自己紹介文');
            $table->time('wake_up_time')->default('07:00:00')->comment('目標起床時間');
            $table->unsignedTinyInteger('range_of_success')->default(3)->comment('早起き成功時間帯の範囲');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
