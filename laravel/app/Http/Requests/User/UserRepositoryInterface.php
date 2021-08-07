<?php

namespace App\Repositories\User;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * 早起き達成日数の多いユーザーランキングを取得
     *
     * @return Collection
     */
    public function ranking(): Collection;

}
