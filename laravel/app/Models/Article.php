<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    use SoftCascadeTrait;

    protected $softCascade = [
        'comments',
    ];

    protected $fillable = [
        'body',
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
                $query->where('body', 'like', '%'.$value.'%')
                    ->with(['user', 'likes', 'tags']);
            }
        }

        return $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function isLikedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }

    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
