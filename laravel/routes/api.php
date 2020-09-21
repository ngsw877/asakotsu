<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [
        'result' => true,
    ];
});

// Route::middleware('web')->group(function(){
Route::middleware('web','auth')->group(function(){
    // Get list of meetings.
    Route::get('/meetings/index', 'Zoom\getIndexController@index');
    Route::get('/meetings/list', 'Zoom\MeetingController@list');

    // Create meeting room using topic, agenda, start_time.
    Route::post('/meetings/store', 'Zoom\MeetingController@store')->name('meetings.store');

    // Route::get('/meetings/create', 'Zoom\MeetingController@showCreateForm')->name('meetings.form');
});



// Get information of the meeting room by ID.
// Route::get('/meetings/{id}', 'Zoom\MeetingController@get')->where('id', '[0-9]+');
// Route::patch('/meetings/{id}', 'Zoom\MeetingController@update')->where('id', '[0-9]+');
Route::delete('/meetings/{id}', 'Zoom\MeetingController@delete')->where('id', '[0-9]+');

