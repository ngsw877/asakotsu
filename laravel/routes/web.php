<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ユーザー新規登録、ログイン、ログアウト
Auth::routes();
// ゲストユーザーログイン
Route::get('guest', 'Auth\LoginController@guestLogin')->name('login.guest');

Route::get('/', 'ArticleController@index')->name('articles.index');
Route::resource('/articles', 'ArticleController')->except(['index', 'show'])->middleware('auth');
Route::resource('/articles', 'ArticleController')->only(['show']);
Route::prefix('articles')->name('articles.')->group(function () {
  Route::put('/{article}/like', 'ArticleController@like')->name('like')->middleware('auth');
  Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike')->middleware('auth');
});
Route::get('/tags/{name}', 'TagController@show')->name('tags.show');
Route::prefix('users')->name('users.')->group(function () {
  Route::get('/{name}', 'UserController@show')->name('show');
  Route::get('/{name}/likes', 'UserController@likes')->name('likes');
  Route::get('/{name}/followings', 'UserController@followings')->name('followings');
  Route::get('/{name}/followers', 'UserController@followers')->name('followers');
  Route::middleware('auth')->group(function () {
    Route::put('/{name}/follow', 'UserController@follow')->name('follow');
    Route::delete('/{name}/follow', 'UserController@unfollow')->name('unfollow');
  });
});

// QiitaAPIテスト
Route::get('/post', 'PostController@index');

// ZoomAPI関連
Route::middleware('auth')->group(function () {
  Route::get('/meetings', 'Zoom\MeetingController@index')->name('meetings.index');
});

// Route::get('/meetings/create', 'Zoom\MeetingController@showCreateForm')->name('meetings.form');

// Route::get('/meetings/create', 'Zoom\MeetingController@showCreateForm')->name('meetings.form');
Route::get('/meetings/create', 'Zoom\MeetingController@showCreateForm')->name('meetings.form')->middleware('auth');

// テスト用ルーティング
Route::get('/test', function() {
  return view('test');
});



