<?php

namespace App\Services\Article;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Tag;
use App\Repositories\Article\ArticleRepositoryInterface;

class ArticleService implements ArticleServiceInterface
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(
        ArticleRepositoryInterface $articleRepository
    )
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function create(ArticleRequest $request): Article
    {
        $user = $request->user();
        $articleRecord = $request->validated() + ['ip_address' => $request->ip()];

        $article = $this->articleRepository->create($articleRecord, $user);

        $tags = $request->tags;
        $this->articleRepository->attachTags($article, $tags);

        return $article;
    }

    /**
     * {@inheritDoc}
     */
    public function update(ArticleRequest $request, Article $article): void
    {
        $articleRecord = $request->validated();

        $article = $this->articleRepository->update($articleRecord, $article);

        $tags = $request->tags;
        $this->articleRepository->attachTags($article, $tags);
    }
}
