<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Models\Meeting;

class SearchData
{
    /** キーワード検索
     *  検索ボックスに入力されたキーワードとマッチするデータをDBから取得する
     * @param string|null $keyword
     * @param Model $model
     * @return mixed
     */
    public static function  searchKeyword(string $keyword = null, Model $model)
    {
        $query = $model::query();

        // もしキーワードがあったら
        if ($keyword !== null) {
            // 全角スペースを半角に
            $keyword_split = mb_convert_kana($keyword,'s');

            //  空白で区切る
            $keyword_split2 = preg_split('/[\s]+/', $keyword_split,-1,PREG_SPLIT_NO_EMPTY);

            // ユーザー投稿をキーワードで検索
            if ($model instanceof Article) {
                // 単語をループで回す
                foreach($keyword_split2 as $value)
                {
                    $query->where('body','like','%'.$value.'%');
                }
            }

            // ミーティングをキーワードで検索
            if ($model instanceof Meeting) {
                // 単語をループで回す
                foreach($keyword_split2 as $value)
                {
                    $query->where('topic','like','%'.$value.'%')
                        ->orWhere('agenda','like','%'.$value.'%');
                }
            }
        };
            return $query;
    }

}
