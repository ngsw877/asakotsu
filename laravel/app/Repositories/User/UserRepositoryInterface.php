<?php

namespace App\Repositories\User;

use App\Models\Article;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * primary keyのidからUserモデルを取得
     *
     * @param int $userId
     * @return User
     */
    public function find(int $userId): User;

    /**
     * アカウント名からUserモデルを取得
     *
     * @param string $name
     * @return User
     */
    public function findByName(string $name): User;

    /**
     * 指定したアカウントを削除
     *
     * @param User $user
     * @return bool|null
     * @throws Exception
     */
    public function delete(User $user): ?bool;

    /**
     * 今月の早起き達成日数が多い順に、UserモデルをCollectionで取得
     *
     * @param int $count
     * @return Collection
     */
    public function getRankedUsersThisMonth(int $count): Collection;

    /**
     * 早起き達成日を登録する
     *
     * @param Article $article
     * @return mixed
     */
    public function createAchievementDays(Article $article);

    /**
     * 今月の早起き達成日数も取得
     *
     * @param string $name
     * @return User
     */
    public function withCountAchievementDays(string $name): User;
}
