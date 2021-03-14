<?php

namespace App\Services\Search;

use App\Models\Article;
use App\Models\Meeting;
use App\Services\Search\SearchArticle;
use App\Services\Search\SearchMeeting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CheckModel
{
    private SearchArticle $searchArticle;
    private SearchMeeting $searchMeeting;

    public function __construct(
        SearchArticle $searchArticle,
        SearchMeeting $searchMeeting
    )
    {
        $this->searchArticle = $searchArticle;
        $this->searchMeeting = $searchMeeting;
    }

    /**
     *  キーワード検索対象のModelを選別し、ページネーションを返す
     * @param array $keyword
     * @param Model $model
     * @param Builder $query
     * @return Builder
     */
    public function checkModelForSearchKeyword(array $keywordSplit, Model $model, Builder $query): Builder
    {
        if ($model instanceof Article) {
            // ユーザー投稿をキーワードで検索
            $query = $this->searchArticle
                ->searchKeywordFromArticle($keywordSplit, $query);
        }

        if ($model instanceof Meeting) {
            // ミーティングをキーワードで検索
            $query = $this->searchMeeting
                ->searchKeywordFromMeeting($keywordSplit, $query);
        }

        return $query;
    }

}
