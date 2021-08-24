<?php

namespace App\Repositories\Comment;

use App\Models\User;

interface CommentRepositoryInterface
{
    /**
     * 投稿へのコメントを登録
     *
     * @param array $commentRecord
     * @param User $user
     */
    public function create(array $commentRecord, User $user): void;

}
