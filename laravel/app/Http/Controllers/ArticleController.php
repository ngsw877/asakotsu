<?php

namespace App\Http\Controllers;

use App\Models\Article
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use App\Services\Search\SearchData;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
        // 'article'...モデルのIDがセットされる、ルーティングのパラメータ名 → {article}
    }

    /**
     * 投稿一覧の表示
     * @param Request $request
     * @param User $user
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $user, Article $article, SearchData $searchData)
    {
        // ユーザー投稿を検索で検索
        $search = $request->input('search');

        $query = $searchData->searchKeyword($search, $article);

        ### 投稿一覧を無限スクロールで表示 ###
        $articles = $query->with(['user', 'likes', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('articles.list', ['articles' => $articles])->render(),
                'next' =>  $articles->appends($request->only('search'))->nextPageUrl()
            ]);
        }

        ### ユーザーの早起き達成日数ランキングを取得 ###
        $ranked_users = $user->ranking();

        return view('articles.index', [
            'articles' => $articles,
            'ranked_users' => $ranked_users,
            'search' => $search
            ]);
    }

    /**
     * 新規投稿フォームの表示
     *  @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        $user = Auth::user();

        return view('articles.create', [
            'allTagNames' => $allTagNames,
            'user' => $user
        ]);
    }

    /**
     * 投稿の登録
     * @param ArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request, Article $article)
    {
        // 二重送信対策
        $request->session()->regenerateToken();

        DB::transaction(function() use ($request, $article) {
            // 投稿をDBに保存

            $user = $request->user();
            $article = $user
                        ->articles()
                        ->create($request->validated() + ['ip_address' => $request->ip()]);
            $request->tags->each(function ($tagName) use ($article) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $article->tags()->attach($tag);
            });

            // 早起き成功かどうか判定し、成功の場合にその日付をDBに履歴として保存する
            if (
                $user->wake_up_time->copy()->subHour($user->range_of_success) <= $article->created_at
                && $article->created_at <= $user->wakeup_time
            ) {
                $result = $user->achievement_days()->firstOrCreate([
                    'date' => $article->created_at->copy()->startOfDay(),
                ]);

                // 本日の早起き達成記録が、レコードに記録されたかを判定。一日最大一回のみ、早起き達成メッセージを表示。
                if ($result->wasRecentlyCreated) {
                    session()->flash('msg_achievement', '早起き達成です！');
                }
            } else {
                session()->flash('msg_success', '投稿が完了しました');
            }
        });

        return redirect()->route('articles.index');
    }

    /**
     * 投稿編集フォームの表示
     * @param Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $tagNames = $article->tags->map(function ($tag) {

            return ['text' => $tag->name];
        });

        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.edit', [
            'article' => $article,
            'tagNames' => $tagNames,
            'allTagNames' => $allTagNames,
        ]);
    }

    /**
     * 投稿の更新
     * @param ArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleRequest $request, Article $article)
    {
        DB::transaction(function() use ($request, $article) {
            $article->fill($request->validated())->save();
            $article->tags()->detach();
            $request->tags->each(function ($tagName) use ($article) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $article->tags()->attach($tag);
            });

            session()->flash('msg_success', '投稿を編集しました');
        });

        return redirect()->route('articles.index');
    }

    /**
     * 投稿の削除
     * @param Article $article
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function destroy(Article $article)
    {

        $article->delete();

        session()->flash('msg_success', '投稿を削除しました');

        return redirect()->route('articles.index');
    }

    /**
     * 投稿詳細画面の表示
     * @param Article $article
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article, Comment $comment)
    {
        $comments = $article->comments()
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        return view('articles.show', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    /**
     * 投稿へのいいね
     * @param Request $request
     * @param Article $article
     * @return array
     */
    public function like(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    /**
     * 投稿へのいいね解除
     * @param Request $request
     * @param Article $article
     * @return array
     */
    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }
}

