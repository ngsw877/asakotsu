<?php

namespace App\Services\Article;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Repositories\Article\ArticleRepositoryInterface;
use Illuminate\Support\Collection;

class ArticleService implements ArticleServiceInterface
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(
        ArticleRepositoryInterface $articleRepository
    ) {
        $this->articleRepository = $articleRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $articleRecord, Collection $tags): Article
    {
        $article = $this->articleRepository->create($articleRecord);

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
