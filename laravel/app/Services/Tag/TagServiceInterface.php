<?php

namespace App\Services\Tag;

use App\Models\Article;
use Illuminate\Support\Collection;

interface TagServiceInterface
{
    /**
     * 全てのタグ名をCollectionで取得
     *
     * @return Collection
     */
    public function getAllTagNames(): Collection;

    /**
     * 投稿に紐づくタグ名をCollectionで取得
     *
     * @param Article $article
     * @return Collection
     */
    public function getTagNamesOfArticle(Article $article): Collection;
}
