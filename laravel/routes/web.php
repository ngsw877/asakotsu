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
Route::get('articles/{article}', 'ArticleController@show')->name('articles.show')->where('article', '[0-9]+'); // 正規表現追加 (※createメソッド実行時に404エラーが発生するため)


# 投稿のタグ機能
Route::get('/tags/{name}', 'TagController@show')->name('tags.show');

# ユーザー関連機
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


### ログイン状態で使用可能 ###
Route::group(['middleware' => 'auth'], function() {

  // ユーザー投稿関係(create, edit, update, destroy)
  Route::resource('/articles', 'ArticleController')->except(['index', 'show']);

  // いいね機能
  Route::prefix('articles')->name('articles.')->group(function () {
    Route::put('/{article}/like', 'ArticleController@like')->name('like');
    Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike');
  });

  # ユーザー関係
  Route::prefix('users/{name}')->name('users.')->group(function () {
    // フォロー機能
    Route::put('/follow', 'UserController@follow')->name('follow');
    Route::delete('/follow', 'UserController@unfollow')->name('unfollow');

    // ユーザープロフィール関係(edit, update, destroy)
    Route::get('/edit', 'UserController@edit')->name('edit');
    Route::patch('/update', 'UserController@update')->name('update');
    // Route::delete('/', 'UserController@destroy')->name('destroy');
  });

  // コメント機能
  Route::resource('/comments', 'CommentController')->only(['store']);

  // Zoomミーティング関連機能(CRUD)
  Route::resource('/meetings', 'Zoom\MeetingController');

});
