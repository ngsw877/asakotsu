<?php

namespace App\Services\Tag;

use App\Repositories\Tag\TagRepositoryInterface;
use Illuminate\Support\Collection;

class TagService implements TagServiceInterface
{
    private TagRepositoryInterface $tagRepository;

    public function __construct(
        TagRepositoryInterface $tagRepository
    )
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function getAllTagNames(): Collection
    {
        $allTags = $this->tagRepository->getAll();

        return $allTags->map(function ($tag) {
            return ['text' => $tag->name];
        });
    }

}
