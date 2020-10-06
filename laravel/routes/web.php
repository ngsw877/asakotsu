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

# ユーザー新規登録、ログイン、ログアウト
Auth::routes();

# ゲストユーザーログイン
Route::get('guest', 'Auth\LoginController@guestLogin')->name('login.guest');

# ユーザー投稿関係(index, show)
Route::get('/', 'ArticleController@index')->name('articles.index');
Route::resource('/articles', 'ArticleController')->only(['show']);

# 投稿のタグ機能
Route::get('/tags/{name}', 'TagController@show')->name('tags.show');

# ユーザー関連機能
Route::prefix('users')->name('users.')->group(function () {
  // ユーザー詳細表示
  Route::get('/{name}', 'UserController@show')->name('show');
  // いいねした投稿一覧を表示
  Route::get('/{name}/likes', 'UserController@likes')->name('likes');
  // フォロー中のユーザー一覧を表示
  Route::get('/{name}/followings', 'UserController@followings')->name('followings');
  // フォロワー一覧を表示
  Route::get('/{name}/followers', 'UserController@followers')->name('followers');

});

# テスト用ルーティング
Route::get('/test', function() {
  return view('test');
});


# ログイン状態で使用可能
Route::group(['middleware' => 'auth'], function() {

  // ユーザー投稿関係(create, edit, update, destroy)
  Route::resource('/articles', 'ArticleController')->except(['index', 'show']);

  // いいね機能
  Route::prefix('articles')->name('articles.')->group(function () {
    Route::put('/{article}/like', 'ArticleController@like')->name('like');
    Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike');
  });

  // フォロー機能
  Route::prefix('users')->name('users.')->group(function () {
    Route::put('/{name}/follow', 'UserController@follow')->name('follow');
    Route::delete('/{name}/follow', 'UserController@unfollow')->name('unfollow');
  });

  // コメント機能
  Route::resource('/comments', 'CommentController')->only(['store']);

  // Zoomミーティング関連機能(CRUD)
  Route::resource('/meetings', 'Zoom\MeetingController');

});
