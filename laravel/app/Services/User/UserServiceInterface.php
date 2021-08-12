<?php

namespace App\Services\User;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    /**
     * 今月の早起き達成日数が多い順に、UserモデルをCollectionで取得し、順位もタイ対応させる
     *
     * @param int $count
     * @return Collection
     */
    public function ranking(int $count): Collection;

    /**
     * 本日早起き達成できたかをチェックする
     *
     * @param Article $article
     * @return bool
     */
    public function checkIsAchievedEarlyRising(Article $article): bool;
}
