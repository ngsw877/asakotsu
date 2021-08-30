<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use App\Repositories\Article\ArticleRepositoryInterface;
use App\Repositories\Tag\TagRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\ArticleRequest;
use App\Services\Article\ArticleServiceInterface;
use App\Services\Tag\TagServiceInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private ArticleRepositoryInterface $articleRepository;
    private TagRepositoryInterface $tagRepository;
    private UserRepositoryInterface $userRepository;

    private ArticleServiceInterface $articleService;
    private TagServiceInterface $tagService;
    private UserServiceInterface $userService;

    public function __construct(
        ArticleRepositoryInterface $articleRepository,
        TagRepositoryInterface $tagRepository,
        UserRepositoryInterface $userRepository,
        ArticleServiceInterface $articleService,
        TagServiceInterface $tagService,
        UserServiceInterface $userService
    ) {
        // 'article'...モデルのIDがセットされる、ルーティングのパラメータ名 → {article}
        $this->authorizeResource(Article::class, 'article');

        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->tagRepository = $tagRepository;

        $this->articleService = $articleService;
        $this->tagService =$tagService;
        $this->userService = $userService;
    }

    /**
     * 投稿一覧の表示
     * @param Request $request
     * @return Application|Factory|JsonResponse|View
     */
    public function index(Request $request)
    {
        // ユーザー投稿を検索で検索
        $freeWord = $request->input('free_word');

        $articles = Article::searchByFreeWord($freeWord)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('articles.list', ['articles' => $articles])->render(),
                'next' => $articles->appends($request->only('free_word'))->nextPageUrl()
            ]);
        }

        // ユーザーの早起き達成日数ランキングを取得
        $rankedUsers = $this->userService->ranking(5);

        // メインタグを取得
        $mainTags = $this->tagRepository->getMainTags();

        return view(
            'articles.index',
            compact(
                'articles',
                'freeWord',
                'mainTags',
                'rankedUsers'
            )
        );
    }

    /**
     * 新規投稿フォームの表示
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $allTagNames = $this->tagService->getAllTagNames();

        $user = Auth::user();

        return view('articles.create', [
            'allTagNames' => $allTagNames,
            'user'        => $user
        ]);
    }

    /**
     * 投稿の登録
     *
     * @param ArticleRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(ArticleRequest $request): RedirectResponse
    {

        // 二重送信対策
        $request->session()->regenerateToken();

        return DB::transaction(function () use ($request) {
            $article = $this->articleService->create($request);

            $isAchievedEarlyRising = $this->userService->checkIsAchievedEarlyRising($article);

            // 早起き成功かどうか判定し、成功の場合にその日付をDBに履歴として保存する
            if ($isAchievedEarlyRising) {
                $result = $this->userRepository->createAchievementDays($article);

                // 本日の早起き達成記録が、レコードに記録されたかを判定。
                // 一日最大一回のみ、早起き達成メッセージを表示。
                if ($result->wasRecentlyCreated) {
                    session()->flash('msg_achievement', '早起き達成です！');
                }
            } else {
                toastr()->success('投稿が完了しました');
            }
            return redirect()->route('articles.index');
        });
    }

    /**
     * 投稿編集フォームの表示
     *
     * @param Article $article
     * @return Application|Factory|Response|View
     */
    public function edit(Article $article)
    {
        $tagNames = $article->tags->map(function ($tag) {
            return ['text' => $tag->name];
        });

        $allTagNames = $this->tagService->getAllTagNames();

        return view('articles.edit', [
            'article'     => $article,
            'tagNames'    => $tagNames,
            'allTagNames' => $allTagNames,
        ]);
    }

    /**
     * 投稿の更新
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(ArticleRequest $request, Article $article): RedirectResponse
    {
        return DB::transaction(function () use ($request, $article) {
            $this->articleService->update($request, $article);

            toastr()->success('投稿を更新しました');

            return redirect()->route('articles.index');
        });
    }

    /**
     * 投稿の削除
     *
     * @param Article $article
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Article $article): RedirectResponse
    {
        return DB::transaction(function () use ($article) {
            $this->articleRepository->delete($article);

            toastr()->success('投稿を削除しました');

            return redirect()->route('articles.index');
        });
    }

    /**
     * 投稿詳細画面の表示
     *
     * @param Article $article
     * @return Application|Factory|View
     */
    public function show(Article $article)
    {
        $comments = $article->comments()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('articles.show', [
            'article'  => $article,
            'comments' => $comments
        ]);
    }

    /**
     * 投稿へのいいね
     *
     * @param Request $request
     * @param Article $article
     * @return array
     */
    public function like(Request $request, Article $article): array
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id'         => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    /**
     * 投稿へのいいね解除
     *
     * @param Request $request
     * @param Article $article
     * @return array
     */
    public function unlike(Request $request, Article $article): array
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id'         => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }
}
