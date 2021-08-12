<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * フリーワード検索でマッチしたレコードを取得するクエリスコープ
     *
     * @param Builder $query
     * @param string|null $freeWord
     * @return Builder
     */
    public function scopeSearchByFreeWord(Builder $query, string $freeWord = null): Builder
    {
        if (isset($freeWord)) {
            // 全角スペースを半角に変換
            $freeWord = mb_convert_kana($freeWord, 's');

            // フリーワードをスペースで区切る
            $keywordSplit = preg_split('/[\s]+/', $freeWord, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($keywordSplit as $value) {
                $query->where('topic', 'like', '%'.$value.'%')
                    ->orWhere('agenda', 'like', '%'.$value.'%');
            }
        }

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function findByMeetingId(int $meetingId): ?Meeting
    {
        return Meeting::where('meeting_id', $meetingId)->first() ?? null;
    }
}
