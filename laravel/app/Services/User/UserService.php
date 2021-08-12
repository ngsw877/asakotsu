<?php

namespace App\Services\User;

use App\Repositories\User\UserRepositoryInterface;
use Carbon\CarbonImmutable as Carbon;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function ranking(int $count): Collection
    {
        $rankedUsers =  $this->userRepository->getRankedUsersThisMonth($count);

        // 早起き達成日数ランキングの順位の数値を取得（タイ対応）
        if (!$rankedUsers->isEmpty()) {
            $rank = 1;
            // 最も早起き達成日数の多いユーザーの日数を取得
            $before = $rankedUsers->first()->achievement_days_count;
            $rankedUsers = $rankedUsers->transform(function ($user) use (&$rank, &$before) {
                if ($before > $user->achievement_days_count) {
                    $rank++;
                    $before = $user->achievement_days_count;
                }
                $user->rank = $rank;
                return $user;
            });
        }
        return $rankedUsers;
    }

}
