<?php

namespace App\Providers;

use App\Services\Article\ArticleService;
use App\Services\Article\ArticleServiceInterface;
use App\Services\Comment\CommentService;
use App\Services\Comment\CommentServiceInterface;
use App\Services\Tag\TagService;
use App\Services\Tag\TagServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticleServiceInterface::class, ArticleService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
        $this->app->bind(TagServiceInterface::class, TagService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
