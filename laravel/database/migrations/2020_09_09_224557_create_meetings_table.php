<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('meeting_id')->comment('ミーティングID');
            $table->string('topic')->comment('ミーティング名');
            $table->string('agenda')->nullable()->comment('テーマ');
            $table->string('start_time')->comment('ミーティング開始時間');
            $table->text('start_url')->comment('ホスト用URL');
            $table->text('join_url')->comment('参加者URL');
            $table->bigInteger('user_id')->unsigned()->comment('ユーザーID');
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('meetings');
    }
}
