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
        return $this->hasMany('App\Models\Article');
    }

    public function achievement_days(): HasMany
    {
        return $this->hasMany(AchievementDay::class);
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'followee_id', 'follower_id')->withTimestamps();
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Article', 'likes')->withTimestamps();
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

}
