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
    public function getMainTags(): Collection
    {
        return $this->tag
            ->whereIn('name', config('tag.main'))
            ->get();
    }
}
