<?php

namespace App\Repositories\User;

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
}
