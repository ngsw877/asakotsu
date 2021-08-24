<?php

namespace App\Services\Comment;

use App\Models\User;

interface CommentServiceInterface
{
    /**
     * 投稿へのコメントを登録
     *
     * @param array $commentRecord
     * @param User $user
     */
    public function create(array $commentRecord, User $user): void;
}
