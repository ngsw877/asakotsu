<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    protected string $userRoute = 'login';
    protected string $adminRoute = 'admin.login';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * 未ログインユーザーが、ログイン状態でないとアクセスできないURLに移動しようとした時のリダイレクト先を指定
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // ルーティングに応じて未ログイン時のリダイレクト先を振り分ける
        if (! $request->expectsJson()) {
            if (Route::is('user.*')) {
                return route($this->userRoute);
            } elseif (Route::is('admin.*')) {
                return route($this->adminRoute);
            }
        }
    }
}
