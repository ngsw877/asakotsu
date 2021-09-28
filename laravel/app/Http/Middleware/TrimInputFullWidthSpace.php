<?php

namespace App\Http\Middleware;

use Closure;

class TrimInputFullWidthSpace
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        $request->merge(self::trim($input));

        return $next($request);
    }

    /**
     * 入力フォームからPOSTされた配列または文字列データの前後の全角スペースを除去する
     *
     * @param $value
     * @return array|mixed|string|string[]|null
     */
    public static function trim($value)
    {
        if (is_array($value)) {
            $value = array_map(['self', 'trim'], $value);
        } elseif (is_string($value)) {
            // 入力フォームでPOSTされた文字列データの前後の全角スペースを除去する
            // \xE3\x80\x80・・・全角スペース
            $value = preg_replace("/\A[\xE3\x80\x80]++|[\xE3\x80\x80]++\z/u", '', $value);
        }

        return $value;
    }
}
