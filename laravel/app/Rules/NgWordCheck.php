<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NgWordCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($column)
    {
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function passes($attribute, $value)
    {
        // 禁止用語
        $NG_WORDS = [];
        include('NgWords.php');

        // 判定
        foreach($NG_WORDS as $word) {
            // 禁止用語が含まれていれば
            if(strpos($value, $word) !== false){
                return false;
            }
        }
        return true;
    }

    public function message()
    {
        return trans('validation.attributes.' . $this->column) . 'に禁止用語が含まれています。';
    }

}
