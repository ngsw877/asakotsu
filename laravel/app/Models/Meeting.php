<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    protected $fillable = [
        'meeting_id',
        'topic',
        'agenda',
        'start_time',
        'start_url',
        'join_url',
        'user_id',
        'ip_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function findByMeetingId(int $meetingId): ?Meeting
    {
        return Meeting::where('meeting_id', $meetingId)->first() ?? null;
    }
}
