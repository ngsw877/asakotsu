<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * 既にログイン済みのユーザーが、ログイン画面にアクセスした時のリダイレクト先を指定
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // 一般ユーザーの場合
        if (Auth::guard($guard)->check() && $guard === 'user') {
            return redirect(RouteServiceProvider::HOME);
        }

        // 管理者ユーザーの場合
        if (Auth::guard($guard)->check() && $guard === 'admin') {
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }

        return $next($request);
    }
}
