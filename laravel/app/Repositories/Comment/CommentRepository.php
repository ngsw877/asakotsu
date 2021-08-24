<?php

namespace App\Repositories\Comment;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    private Comment $comment;

    public function __construct(
        Comment $comment
    ) {
        $this->comment = $comment;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $commentRecord): void
    {
        $this->comment->create($commentRecord);
    }

}
