<?php

namespace App\Services\Tag;

use Illuminate\Support\Collection;

interface TagServiceInterface
{

    /**
     * 全てのタグ名をCollectionで取得
     *
     * @return Collection
     */
    public function getAllTagNames(): Collection;
}
