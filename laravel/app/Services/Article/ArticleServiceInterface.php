<?php

namespace App\Services\Article;

use App\Http\Requests\ArticleRequest;

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

}
