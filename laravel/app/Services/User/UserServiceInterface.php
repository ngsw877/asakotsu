<?php

namespace App\Services\User;

use App\Models\Article;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    /**
     * アカウントを削除する（退会処理）
     *
     * @param string $userName
     * @return User|null
     * @throws Exception
     */
    public function delete(string $userName): ?User;

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
