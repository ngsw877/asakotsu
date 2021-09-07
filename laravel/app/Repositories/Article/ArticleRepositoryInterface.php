<?php

namespace App\Repositories\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Collection;

interface ArticleRepositoryInterface
{
    /**
     * ユーザーの新規投稿と、投稿のタグをDBに保存
     *
     * @param array $articleRecord
     * @return Article
     */
    public function create(array $articleRecord): Article;

    /**
     * ユーザーの投稿と、投稿のタグを更新
     *
     * @param Article $article
     * @param array $articleRecord
     * @return Article
     */
    public function update(Article $article, array $articleRecord): Article;

    /**
     * ユーザーの投稿にタグを登録する
     * DBに未登録のタグが新規に入力されていれば、DBに保存する
     *
     * @param Article $article
     * @param Collection $tags
     */
    public function attachTags(Article $article, Collection $tags): void;

    /**
     * ユーザーの投稿を削除
     *
     * @param Article $article
     */
    public function delete(Article $article): void;
}
