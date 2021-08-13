<?php

namespace App\Services\Article;

use App\Http\Requests\ArticleRequest;
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
}
