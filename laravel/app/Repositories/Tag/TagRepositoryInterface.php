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
     * 全てのタグをCollectionで取得
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * メインタグをCollectionで取得
     *
     * @return Collection
     */
    public function getMainTags(): Collection;
}
