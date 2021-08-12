<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AchievementDay extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    protected $fillable = [
        'user_id',
        'date',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
