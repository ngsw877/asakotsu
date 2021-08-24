<?php

namespace App\Services\Comment;

use App\Models\User;
use App\Repositories\Comment\CommentRepositoryInterface;

class CommentService implements CommentServiceInterface
{
    private CommentRepositoryInterface $commentRepository;

    public function __construct(
        CommentRepositoryInterface $commentRepository
    ) {
        $this->commentRepository = $commentRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $commentRecord, User $user): void
    {
        $commentRecord['user_id'] = $user->id;

        $this->commentRepository->create($commentRecord);
    }
}
