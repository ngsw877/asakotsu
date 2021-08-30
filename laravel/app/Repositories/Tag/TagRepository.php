<?php

namespace App\Repositories\Tag;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagRepository implements TagRepositoryInterface
{
    private Tag $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * {@inheritDoc}
     */
    public function findByName(string $tagName): Tag
    {
        $this->tag
            ->where('name', $tagName)
            ->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): Collection
    {
        $this->tag->all();
    }

    /**
     * {@inheritDoc}
     */
    public function getMainTags(): Collection
    {
        return $this->tag
            ->whereIn('name', config('tag.main'))
            ->get();
    }
}
