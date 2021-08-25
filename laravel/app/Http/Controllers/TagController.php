<?php

namespace App\Http\Controllers;

use App\Repositories\Tag\TagRepositoryInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class TagController extends Controller
{
    private TagRepositoryInterface $tagRepository;

    private UserServiceInterface $userService;

    public function __construct(
        TagRepositoryInterface $tagRepository,
        UserServiceInterface $userService
    ) {
        $this->tagRepository = $tagRepository;
        $this->userService = $userService;
    }

    /**
     * 指定したタグにマッチする投稿一覧を表示
     *
     * @param string $name
     * @return Application|Factory|View
     */
    public function show(string $name)
    {
        $tag = $this->tagRepository->findByName($name);

        // 投稿日が新しい順にソート
        $tag->articles = $tag->articles->sortByDesc('created_at');

        // ユーザーの早起き達成日数ランキングを取得
        $rankedUsers = $this->userService->ranking(5);

        // メインタグを取得
        $mainTags = $this->tagRepository->getMainTags();

        return view(
            'tags.show',
            compact(
                'tag',
                'mainTags',
                'rankedUsers'
            )
        );
    }
}
