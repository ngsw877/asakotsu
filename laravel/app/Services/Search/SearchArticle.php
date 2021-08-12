<?php

namespace App\Services\Search;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;

class SearchArticle
{
    /**
     * Articleモデルから、キーワード検索にマッチしたデータを取得
     * @param array $keywordSplit
     * @param Builder $query
     * @return Builder
     */
    public function searchKeywordFromArticle(array $keywordSplit, Builder $query): Builder
    {
        // ユーザー投稿をキーワードで検索
        // 単語をループで回す
        foreach ($keywordSplit as $value) {
            $query->where('body', 'like', '%'.$value.'%')
                ->with(['user', 'likes', 'tags']);
        }

        return $query;
    }
}
