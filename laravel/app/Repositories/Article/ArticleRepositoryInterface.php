<?php

namespace App\Repositories\Article;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;

interface ArticleRepositoryInterface
{
    /**
     * ユーザーの新規投稿と、投稿のタグをDBに保存
     *
     * @param ArticleRequest $request
     * @return Article
     */
    public function create(ArticleRequest $request): Article;

    /**
     * ユーザーの投稿と、投稿のタグを更新
     *
     * @param ArticleRequest $request
     * @param Article $article
     */
    public function update(ArticleRequest $request, Article $article): void;

    /**
     * ユーザーの投稿を削除
     *
     * @param Article $article
     */
    public function delete(Article $article): void;

}
