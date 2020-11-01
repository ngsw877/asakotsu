<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\User;

class TagController extends Controller
{
    public function show(string $name, User $user)
    {
        $tag = Tag::where('name', $name)->first();

        // ユーザーの早起き達成日数ランキングを取得
        $ranked_users = $user->ranking();

        return view('tags.show', ['tag' => $tag, 'ranked_users' => $ranked_users]);
    }
}
