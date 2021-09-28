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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        // ゲストユーザーログイン時に、ユーザー名とメールアドレスを変更できないよう対策
        if (Auth::id() == config('user.guest_user.id')) {
            return [
                'profile_image'     => ['file', 'mimes:jpeg,png,jpg,bmb', 'max:2048'],
                'self_introduction' => ['string', 'max:200', 'nullable'],
                'wake_up_time'      => ['required', 'date_format:"H:i"'],
            ];
        }

        return [
            'name'              => ['required', 'regex:/^(?!.*\s).+$/u', 'regex:/^(?!.*\/).*$/u', 'max:15', Rule::unique('users')->ignore(Auth::id())],
            'email'             => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'profile_image'     => ['file', 'mimes:jpeg,png,jpg,bmb', 'max:2048'],
            'self_introduction' => ['string', 'max:200', 'nullable'],
            'wake_up_time'      => ['required', 'date_format:"H:i"'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'              => 'ユーザー名',
            'email'             => 'メールアドレス',
            'password'          => 'パスワード',
            'profile_image'     => 'プロフィール画像',
            'self_introduction' => '自己紹介文',
            'wake_up_time'      => '目標起床時間',

        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => ':attributeに「/」と半角スペースは使用できません。'
        ];
    }
}
