<?php

namespace App\Http\Controllers;

use App\Services\User\UserServiceInterface;
use App\Models\Tag;

class TagController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    public function show(string $name)
    {
        $tag = Tag::where('name', $name)->first();

        // 投稿日が新しい順にソート
        $tag->articles = $tag->articles->sortByDesc('created_at');

        // ユーザーの早起き達成日数ランキングを取得
        $rankedUsers = $this->userService->ranking(5);

        return view('tags.show', ['tag' => $tag, 'rankedUsers' => $rankedUsers]);
    }
}
