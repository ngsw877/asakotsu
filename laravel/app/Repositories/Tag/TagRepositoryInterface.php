<?php

namespace App\Repositories\Tag;

use Illuminate\Support\Collection;

interface TagRepositoryInterface
{

    /**
     * メインタグをCollectionで取得
     *
     * @return Collection
     */
    public function getMainTags(): Collection;
}
