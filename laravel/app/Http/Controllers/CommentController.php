<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    public function store(CommentRequest $request, Comment $comment)
    {
        $user = auth()->user();
        $comment->fill($request->all());
        $comment->user_id = $user->id;
        $comment->save();

        session()->flash('flash_message', 'コメントを投稿しました');
        return back();
    }

}
