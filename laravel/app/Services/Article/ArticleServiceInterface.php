<?php

namespace App\Services\Article;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;

interface ArticleServiceInterface
{
    /**
     * ユーザーの新規投稿をDBに保存する
     * 投稿にタグも登録する
     *
     * @param ArticleRequest $request
     * @return Article
     */
    public function create(ArticleRequest $request): Article;

    /**
     * ユーザーの投稿を更新する
     * 投稿に登録されたタグも更新
     *
     * @param ArticleRequest $request
     * @param Article $article
     */
    public function update(ArticleRequest $request, Article $article): void;

}
