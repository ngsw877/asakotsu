<?php

namespace App\Services\Search;

use App\Models\Article;
use App\Models\Meeting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CheckModel
{
    /**
     *  キーワード検索対象のModelを選別し、ページネーションを返す
     * @param array $keyword
     * @param Model $model
     * @param Builder $query
     * @return Builder
     */
    public function checkModelForSearchKeyword(array $keywordSplit, Model $model, Builder $query): Builder
    {
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

        return $query;
    }

}
