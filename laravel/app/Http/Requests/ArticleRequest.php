<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'body'       => ['required', 'max:500', 'not_regex:/<\/*script>/u'],
            'tags'       => ['json', 'regex:/^(?!.*\s).+$/u', 'regex:/^(?!.*\/).*$/u'],
            'user_id'    => ['required', 'integer'],
            'ip_address' => ['nullable', 'ip'],
        ];
    }

    public function attributes(): array
    {
        return [
            'body' => '本文',
            'tags' => 'タグ',
        ];
    }

    public function messages(): array
    {
        return [
            'tags.regex' => ':attributeに「/」と半角スペースは使用できません。'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id'    => auth()->user()->id,
            'ip_address' => $this->ip(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function passedValidation()
    {
        $this->tags = collect(json_decode($this->tags))
            ->slice(0, 5)
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
