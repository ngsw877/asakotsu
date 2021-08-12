<?php

namespace App\Repositories\User;

use App\Models\User;
use Carbon\CarbonImmutable as Carbon;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritDoc}
     */
    public function ranking(int $count): Collection
    {
        $rankedUsers =  $this->user::withCount(['achievementDays' => function ($query) {
            $query
                ->where('date', '>=', Carbon::now()->startOfMonth()->toDateString())
                ->where('date', '<=', Carbon::now()->endOfMonth()->toDateString());
        }])
            ->orderBy('achievement_days_count', 'desc')
            ->limit($count)
            ->get();

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
