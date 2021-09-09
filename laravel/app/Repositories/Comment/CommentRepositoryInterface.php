<?php

namespace App\Repositories\Comment;

interface CommentRepositoryInterface
{
    /**
     * 投稿へのコメントを登録
     *
     * @param array $commentRecord
     */
    public function create(array $commentRecord): void;
}
