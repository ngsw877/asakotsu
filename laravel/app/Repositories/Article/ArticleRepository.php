<?php

namespace App\Repositories\Article;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Tag;

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
    public function create(ArticleRequest $request): Article
    {
        $user = $request->user();

        $articleRecord = $request->validated();

        $article = $user
            ->articles()
            ->create($articleRecord);

        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

        return $article;
    }

    /**
     * {@inheritDoc}
     */
    public function update(ArticleRequest $request, Article $article): void
    {
        $articleRecord = $request->validated();

        $article->fill($articleRecord)->save();

        $article->tags()->detach();

        $request->tags->each(function ($tagName) use ($article) {
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
