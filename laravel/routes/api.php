<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'result' => true,
    ];
});

Route::get('/meetings/list', 'Zoom\MeetingController@getListMeetings');







