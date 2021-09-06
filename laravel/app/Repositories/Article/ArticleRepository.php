<?php

namespace App\Repositories\Article;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;

class ArticleRepository implements ArticleRepositoryInterface
{
    private Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $articleRecord): Article
    {
        $article = $this->article
            ->create($articleRecord);

        return $article;
    }

    /**
     * {@inheritDoc}
     */
    public function update(array $articleRecord, Article $article): Article
    {
        $article->fill($articleRecord)->save();

        $article->tags()->detach();

        return $article;
    }

    /**
     * {@inheritDoc}
     */
    public function attachTags(Article $article, Collection $tags): void
    {
        $tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);

            $article->tags()->attach($tag);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function delete(Article $article): void
    {
        $article->delete();
    }
}
