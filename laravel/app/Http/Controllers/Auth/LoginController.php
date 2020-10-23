<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // ゲストユーザーログイン
    private const GUEST_USER_EMAIL = 'guest@guest.com';

    public function guestLogin()
    {
        $user = User::where('email', self::GUEST_USER_EMAIL)->first();
        if ($user && Auth::login($user)) {
            return redirect('/');
        }

        session()->flash('flash_message', 'ゲストユーザーでログインしました');
        return back();
    }

    protected function redirectTo() {
        session()->flash('flash_message', 'ログインしました');
        return redirect('/');
    }
}
