<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\CarbonImmutable as Carbon;

class User extends Authenticatable
{
    use Notifiable;

    // protected $dates = [
    //     'wake_up_time'
    // ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'self_introduction',
        'wake_up_time',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function achievement_days(): HasMany
    {
        return $this->hasMany(AchievementDay::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id')->withTimestamps();
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'likes')->withTimestamps();
    }

    public function isFollowedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->followers->where('id', $user->id)->count()
            : false;
    }

    public function getCountFollowersAttribute(): int
    {
        return $this->followers->count();
    }

    public function getCountFollowingsAttribute(): int
    {
        return $this->followings->count();
    }

    /**
     * @override Model@getWakeUpTimeAttribute
     */
    public function getWakeUpTimeAttribute(): Carbon
    {
        return new Carbon($this->attributes['wake_up_time']);
    }

    /**
     * @override Model@setWakeUpTimeAttribute
     */
    public function setWakeUpTimeAttibute($value)
    {
        $this->attributes['wake_up_time'] = $value->format('H:i:s');
    }

    public function withCountAchievementDays(string $name)
    {
        $user = User::where('name', $name)
        ->withCount(['achievement_days' => function ($query) {
            $query
                ->where('date', '>=', Carbon::now()->startOfMonth()->toDateString())
                ->where('date', '<=', Carbon::now()->endOfMonth()->toDateString());
        }])
        ->first();

        return $user;
    }

    public function ranking()
    {
        // 早起き達成日数のランキングを取得
        $ranked_users =  User::withCount(['achievement_days' => function ($query) {
            $query
                ->where('date', '>=', Carbon::now()->startOfMonth()->toDateString())
                ->where('date', '<=', Carbon::now()->endOfMonth()->toDateString());
        }])
            ->orderBy('achievement_days_count', 'desc')
            ->limit(5)
            ->get();

        // 早起き達成日数ランキングの順位の数値を取得（タイ対応）
        if (!$ranked_users->isEmpty()) {
        $rank = 1;
            // 最も早起き達成日数の多いユーザーの日数を取得
        $before = $ranked_users->first()->achievement_days_count;
        $ranked_users = $ranked_users->transform(function ($user) use (&$rank, &$before) {
            if ($before > $user->achievement_days_count) {
                $rank++;
                $before = $user->achievement_days_count;
            }
            $user->rank = $rank;
            return $user;
        });
        }
        return $ranked_users;
    }

}

