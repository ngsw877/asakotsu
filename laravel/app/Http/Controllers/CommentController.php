<?php

namespace App\Http\Controllers;

use App\Services\Comment\CommentServiceInterface;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    private CommentServiceInterface $commentService;

    public function __construct(
        CommentServiceInterface $commentService
    ) {
        $this->commentService = $commentService;
    }

    /**
     * ユーザーの投稿に、コメントを投稿
     *
     * @param CommentRequest $request
     * @return RedirectResponse
     */
    public function store(CommentRequest $request): RedirectResponse
    {
        // 二重送信対策
        $request->session()->regenerateToken();

        $user = auth()->user();
        $commentRecord = $request->validated() + ['ip_address' => $request->ip()];

        $this->commentService->create($commentRecord, $user);
        toastr()->success('コメントを投稿しました');

        return back();
    }
}
