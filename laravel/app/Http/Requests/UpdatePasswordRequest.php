<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
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
        return [
            'current_password' => [
                'required',
                'string',
                'min:8',
                function ($attribute, $value, $fail) {
                    if (!(Hash::check($value, Auth::user()->password))) {
                        return $fail("現在のパスワードを正しく入力してください");
                    }
                }
            ],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password' => '現在のパスワード',
            'new_password' => '新しいパスワード',
        ];
    }
}
