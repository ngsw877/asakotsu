<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'regex' => ':attributeに「/」と半角スペースは使用できません。',
        ];

        return Validator::make(
            $data,
            [
                'name'          => ['required', 'regex:/^(?!.*\s).+$/u', 'regex:/^(?!.*\/).*$/', 'max:15', 'unique:users'],
                'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],
                'profile_image' => ['file', 'mimes:jpeg,png,jpg,bmb', 'max:2048'],
                'wake_up_time'  => ['required', 'date_format:"H:i"'],
            ],
            $messages
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        ### ローカルストレージに画像をアップロード ###
        // 画像のファイル名の設定と、画像のアップロード
        // if(!isset($data['profile_image'])) {
        //     $fileName = 'default.png';
        // } else {
        //     $file = $data['profile_image'];
        //     $fileName = time() . '.' . $file->getClientOriginalName();
        //     $target_path = public_path('/images/profile/');
        //     $file->move($target_path,$fileName);
        // }

        ### S3バケットに画像をアップロード ###
        // ユーザーからプロフィール画像がアップロードされなければ、デフォルト画像を使用
        if (!isset($data['profile_image'])) {
            $image_path = asset(config('user.profile_image_path.default'));
        } else {
            // S3へアップロード開始
            $image = $data['profile_image'];

            $disk = Storage::disk('s3');
            // バケットの`image/profile`フォルダへアップロード
            $path = $disk->putFile(config('s3.dir_name.profile'), $image, 'public');
            // アップロードした画像のフルパスを取得
            $image_path = $disk->url($path);
        }


        // ユーザーの新規登録
        $user = User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'profile_image' => $image_path,
            'wake_up_time'  => $data['wake_up_time'],
        ]);

        toastr()->success('ユーザー登録が完了しました');

        return $user;
    }
}
