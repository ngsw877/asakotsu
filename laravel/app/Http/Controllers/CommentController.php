<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CommentController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
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

        $this->userRepository->createComment($commentRecord, $user);
        toastr()->success('コメントを投稿しました');

        return back();
    }
}
