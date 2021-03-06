<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'result' => true,
    ];
});

// 作成済みのミーティング情報を一覧で取得
Route::get('/meetings/list', 'Zoom\MeetingController@getListMeetings')->name('meetings.list');
// 指定したミーティング情報の取得
Route::get('/meetings/{meeting_id}', 'Zoom\MeetingController@getMeetings')->name('meetings.get');







