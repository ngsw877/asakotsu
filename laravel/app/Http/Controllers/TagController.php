<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Article;
use App\Models\User;

class TagController extends Controller
{
    public function show(string $name, User $user)
    {
        $tag = Tag::where('name', $name)->first();

        // 投稿日が新しい順にソート
        $tag->articles = $tag->articles->sortByDesc('created_at');

        // ユーザーの早起き達成日数ランキングを取得
        $ranked_users = $user->ranking();

        return view('tags.show', ['tag' => $tag, 'ranked_users' => $ranked_users]);
    }
}
