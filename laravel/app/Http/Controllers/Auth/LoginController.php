<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * ログイン後の処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @override \Illuminate\Http\Foundation\Auth\AuthenticatesUsers
     */
    protected function authenticated(Request $request)
    {
        // フラッシュメッセージを表示
        toastr()->success('ログインしました');
        return redirect($this->redirectTo);
    }

    // ゲストユーザーログイン
    public function guestLogin()
    {
        if (Auth::loginUsingId(config('user.guest_user.id'))) {

            toastr()->success('ゲストユーザーでログインしました');

            return redirect($this->redirectTo);
        }

        toastr()->error('ゲストログインに失敗しました');
        return redirect($this->redirectTo);
    }

    /**
     * ユーザーをログアウトさせる
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @override \Illuminate\Http\Foundation\Auth\AuthenticatesUsers
     */
    protected function loggedOut(Request $request)
    {
        $this->guard()->logout();
        $request->session()->regenerateToken();
        $request->session()->invalidate();

        // フラッシュメッセージを表示
        toastr()->success('ログアウトしました');
        return redirect($this->redirectTo);
    }
}
