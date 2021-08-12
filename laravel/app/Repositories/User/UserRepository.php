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
    public function find(int $userId): User
    {
        return $this->user::find($userId);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(User $user): ?bool
    {
        return $result = $user->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function getRankedUsersThisMonth(int $count): Collection
    {
        return $this->user::withCount(['achievementDays' => function ($query) {
            $query
                ->where('date', '>=', Carbon::now()->startOfMonth()->toDateString())
                ->where('date', '<=', Carbon::now()->endOfMonth()->toDateString());
        }])
            ->orderBy('achievement_days_count', 'desc')
            ->limit($count)
            ->get();
    }
}
