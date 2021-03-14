<?php

namespace App\Services\Search;

use App\Models\Article;
use App\Models\Meeting;
use App\Services\Search\CheckModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchData
{
    private CheckModel $checkModel;

    public function __construct(CheckModel $checkModel)
    {
        $this->checkModel = $checkModel;
    }

    /** キーワード検索
     *  検索ボックスに入力されたキーワードとマッチするデータをDBから取得する
     * @param string|null $keyword
     * @param Model $model
     * @return LengthAwarePaginator
     */
    public function searchKeyword(string $keyword = null, Model $model): LengthAwarePaginator
    {
        $query = $model::query();

        // もしキーワードがあったら
        if ($keyword !== null) {
            // 全角スペースを半角に
            $keyword = mb_convert_kana($keyword,'s');

            //  空白で区切る
            $keywordSplit = preg_split('/[\s]+/', $keyword,-1,PREG_SPLIT_NO_EMPTY);

            // Model別にキーワード検索
            $qurey = $this->checkModel->checkModelForSearchKeyword($keywordSplit, $model, $query);
        }

        return $query
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

}
