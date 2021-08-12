<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'result' => true,
    ];
});

// 作成済みミーティング情報を一覧で取得
Route::get('/meetings/list', 'Zoom\MeetingController@getListMeetings')->name('meetings.list');
// 作成済みミーティングの、「開始日」と「ステータスをチェック」し、過去のミーティングを削除する
Route::get('/meetings/check', 'Zoom\MeetingController@checkStartTimeAndStatusOfMeetings')->name('meetings.check');
// 指定したミーティング情報の取得
Route::get('/meetings/{meeting_id}', 'Zoom\MeetingController@getMeeting')->name('meetings.get');
