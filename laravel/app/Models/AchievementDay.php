<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AchievementDay extends Model
{
    protected $fillable = [
        'user_id',
        'date',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
