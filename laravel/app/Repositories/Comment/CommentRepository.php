<?php

namespace App\Repositories\Comment;

use App\Models\User;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(array $commentRecord, User $user): void
    {
        $user->comments()->create($commentRecord);
    }

}
