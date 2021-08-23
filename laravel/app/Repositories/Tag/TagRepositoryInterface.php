<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use Illuminate\Support\Collection;

interface TagRepositoryInterface
{
    /**
     * タグ名から、Tagモデルを取得
     *
     * @param string $tagName
     * @return Tag
     */
    public function findByName(string $tagName): Tag;

    /**
     * メインタグをCollectionで取得
     *
     * @return Collection
     */
    public function getMainTags(): Collection;
}
