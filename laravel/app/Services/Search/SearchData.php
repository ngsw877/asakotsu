<?php

namespace App\Services\Search;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
    public static function  searchKeyword(string $keyword = null, Model $model, Request $request)
    {
        $query = $model::query();

        // もしキーワードがあったら
        if ($keyword !== null) {
            // 全角スペースを半角に
            $keyword = mb_convert_kana($keyword,'s');

            //  空白で区切る
            $keywordSplit = preg_split('/[\s]+/', $keyword,-1,PREG_SPLIT_NO_EMPTY);

            // ユーザー投稿をキーワードで検索
            if ($model instanceof Article) {
                // 単語をループで回す
                foreach($keywordSplit as $value)
                {
                    $query->where('body','like','%'.$value.'%')
                        ->with(['user', 'likes', 'tags']);
                }
            }

            // ミーティングをキーワードで検索
            if ($model instanceof Meeting) {
                // 単語をループで回す
                foreach($keywordSplit as $value)
                {
                    $query->where('topic','like','%'.$value.'%')
                        ->orWhere('agenda','like','%'.$value.'%');
                }
            }
        }

        $paginate = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10);

            return $paginate;
    }

}
