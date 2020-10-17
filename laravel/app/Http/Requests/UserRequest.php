<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|max:15|' . Rule::unique('users')->ignore(Auth::id()),
            'email' => 'string|email|max:255|' . Rule::unique('users')->ignore(Auth::id()),
            'password' => 'string|min:8|confirmed',
            'profile_image' => 'file|mimes:jpeg,png,jpg,bmb|max:2048',
            'self_introduction' => 'string|max:200',
            'wake_up_time' => 'date',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'profile_image' => 'プロフィール画像',
            'self_introduction' => '自己紹介文',
            'wake_up_time' => '目標起床時間',

        ];
    }
}
