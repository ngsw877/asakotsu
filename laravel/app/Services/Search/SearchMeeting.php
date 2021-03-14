<?php

namespace App\Services\Search;

use App\Models\Meeting;
use Illuminate\Database\Eloquent\Builder;

class SearchMeeting
{
    /**
     * Meetingモデルから、キーワード検索にマッチしたデータを取得
     * @param array $keywordSplit
     * @param Builder $query
     * @return Builder
     */
    public function searchKeywordFromMeeting(array $keywordSplit, Builder $query): Builder
    {
        // Zoomミーティングをキーワードで検索
        // 単語をループで回す
        foreach($keywordSplit as $value)
        {
            $query->where('topic','like','%'.$value.'%')
                ->orWhere('agenda','like','%'.$value.'%');
        }

        return $query;
    }

}
