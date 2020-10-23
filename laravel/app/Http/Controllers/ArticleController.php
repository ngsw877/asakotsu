<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
        // ①Article::class　　→　　'App\Models\Article'という文字列を返す
        // ②'article'　　モデルのIDがセットされる、ルーティングのパラメータ名　→　{article}
    }

    public function index()
    {
        $articles = Article::all()->sortByDesc('created_at')->load(['user', 'likes', 'tags']);

        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.create', [
            'allTagNames' => $allTagNames,
        ]);
    }

    public function store(ArticleRequest $request, Article $article)
    {
        // 投稿をDBに保存
        $user = $request->user();
        $article = $user->articles()->create($request->all());
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });


        // 早起き成功かどうか判定し、成功の場合にその日付をDBに履歴として保存する

        if (
            $user->wake_up_time->copy()->subHour($user->range_of_success) <= $article->created_at
            && $article->created_at <= $user->wakeup_time
        ) {
            $user->achivement_days()->firstOrCreate([
                'date' => $article->created_at->copy()->startOfDay(),
            ]);

            session()->flash('msg_achievement','早起き達成です！');
        }

        // 早起き達成日数のランキング
        // User::withCount(['achivement_days' => function ($query) {
        //     $query->where('date', '>=', Carbon::today()->subDay(30));
        // }])
        //     ->orderBy('achivement_days_count', 'desc')
        //     ->get();

        return redirect()->route('articles.index');

    }

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

    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all())->save();

        $article->tags()->detach();
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $article->tags()->attach($tag);
        });

        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }

    public function show(Article $article, Comment $comment)
    {
        $article = $article->getArticle($article->id);
        $comments = $comment->getComments($article->id);
        return view('articles.show', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    public function like(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }
}
