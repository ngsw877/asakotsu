<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class UserController extends Controller
{
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function show(string $name, Request $request)
    {
        // ユーザーの早起き達成日数を表示
        $user = $this->user->withCountAchievementDays($name);

        // ユーザー詳細ページのユーザーによる投稿一覧を10件ずつ取得
        $articles = $user->articles()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // 無限スクロールのajax処理
        if ($request->ajax()) {
            return response()->json([
                'html' => view('articles.list', ['articles' => $articles])->render(),
                'next' => $articles->nextPageUrl()
            ]);
        }

        return view('users.show', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        return view('users.edit', ['user' => $user]);
    }

    public function update(UserRequest $request, string $name)
    {
        $user = User::where('name', $name)->first();

        $user->fill($request->validated())->save();

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        return redirect()->route('users.show',['name' => $user->name]);
    }

    public function likes(string $name, Request $request)
    {
        // ユーザーの早起き達成日数を表示
        $user = $this->user->withCountAchievementDays($name);

        // いいねした投稿一覧を10件ずつ取得
        $articles = $user->likes()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // 無限スクロールのajax処理
        if ($request->ajax()) {
            return response()->json([
                'html' => view('articles.list', ['articles' => $articles])->render(),
                'next' => $articles->nextPageUrl()
            ]);
        }

        return view('users.likes', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    public function followings(string $name)
    {
        $user = $this->user->withCountAchievementDays($name)->load('followings.followers');
        $followings = $user->followings()
        ->orderBy('created_at', 'desc')
        ->paginate(5);

        return view('users.followings', [
            'user' => $user,
            'followings' => $followings,
        ]);
    }

    public function followers(string $name)
    {
        $user = $this->user->withCountAchievementDays($name)->load('followers.followers');;
        $followers = $user->followers()
        ->orderBy('created_at', 'desc')
        ->paginate(5);

        return view('users.followers', [
            'user' => $user,
            'followers' => $followers,
        ]);
    }

    public function follow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['name' => $name];
    }

    public function unfollow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
        }

}
