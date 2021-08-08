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

}
