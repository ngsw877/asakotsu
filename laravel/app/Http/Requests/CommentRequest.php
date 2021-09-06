<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'article_id' => ['required', 'integer'],
            'comment'    => ['required', 'string', 'max:250'],
            'user_id'    => ['required', 'integer'],
            'ip_address' => ['nullable', 'ip'],
        ];
    }

    public function attributes(): array
    {
        return [
            'article_id' => '投稿ID',
            'comment'    => 'コメント'
        ];
    }

    public function messages(): array
    {
        return [
            'comment.required' => 'コメントは必ず入力してください。',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id'    => auth()->user()->id,
            'ip_address' => $this->ip(),
        ]);
    }
}
