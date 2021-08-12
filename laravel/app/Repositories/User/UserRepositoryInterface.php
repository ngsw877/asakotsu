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
     * 早起き達成日数の多いユーザーランキングを取得
     *
     * @param int $count
     * @return Collection
     */
    public function ranking(int $count): Collection;
}
