<?php

Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {

    // ログイン認証関連
    Auth::routes([
        'register' => false,
        'reset'    => false,
        'verify'   => false
    ]);

    // ログイン認証後
    Route::middleware('auth:admin')->group(function () {

        // TOPページ
        Route::get('home', 'HomeController@index')->name('home');
    });
});
