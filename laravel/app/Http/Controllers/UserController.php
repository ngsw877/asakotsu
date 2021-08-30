<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class UserController extends Controller
{
    private User $user;
    private UserServiceInterface $userService;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        User $user,
        UserServiceInterface $userService,
        UserRepositoryInterface $userRepository
    ) {
        $this->user = $user;
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
     * アカウント詳細画面の表示
     *
     * @param string $name
     * @param Request $request
     * @return Application|Factory|JsonResponse|View
     * @throws Throwable
     */
    public function show(string $name, Request $request)
    {
        // ユーザーの早起き達成日数を取得
        $user = $this->userRepository->withCountAchievementDays($name);

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
            'user'     => $user,
            'articles' => $articles,
        ]);
    }

    /**
     * アカウント情報の編集画面の表示
     *
     * @param string $name
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(string $name)
    {
        $user = $this->userRepository->findByName($name);

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * アカウント情報の更新
     *
     * @param UserRequest $request
     * @param string $name
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UserRequest $request, string $name)
    {
        $validated = $request->validated();

        if (isset($validated['profile_image'])) {
            $image = $validated['profile_image'];

            // S3に画像ファイルをアップロード
            $disk = Storage::disk('s3');
            $path = $disk->putFile(config('s3.dir_name.profile'), $image, 'public');

            $validated['profile_image'] = $disk->url($path);
        }

        $user = $this->userRepository->findByName($name);

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        $user->fill($validated)->save();

        toastr()->success('プロフィールを更新しました');

        return redirect()->route('users.show', ['name' => $user->name]);
    }

    /**
     * アカウント削除（退会処理）
     *
     * @param string $name
     * @return mixed
     */
    public function destroy(string $name)
    {
        return DB::transaction(function () use ($name) {
            $user = $this->userService->delete($name);

            // UserPolicyのdeleteメソッドでアクセス制限
            $this->authorize('delete', $user);

            toastr()->success('退会処理が完了しました');

            return redirect()->route('articles.index');
        });
    }

    /**
     * パスワード編集画面の表示
     *
     * @param string $name
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function editPassword(string $name)
    {
        $user = $this->userRepository->findByName($name);

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        return view('users.edit_password', ['user' => $user]);
    }

    /**
     * パスワード更新
     *
     * @param UpdatePasswordRequest $request
     * @param string $name
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function updatePassword(UpdatePasswordRequest $request, string $name)
    {
        $user = $this->userRepository->findByName($name);

        // UserPolicyのupdateメソッドでアクセス制限
        $this->authorize('update', $user);

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        toastr()->success('パスワードを更新しました');

        return redirect()->route('users.show', ['name' => $user->name]);
    }

    public function likes(string $name, Request $request)
    {
        // ユーザーの早起き達成日数を表示
        $user = $this->userRepository->withCountAchievementDays($name);

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
            'user'     => $user,
            'articles' => $articles,
        ]);
    }

    public function followings(string $name)
    {
        $user = $this->userRepository->withCountAchievementDays($name)->load('followings.followers');
        $followings = $user->followings()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('users.followings', [
            'user'       => $user,
            'followings' => $followings,
        ]);
    }

    public function followers(string $name)
    {
        $user = $this->userRepository->withCountAchievementDays($name)->load('followers.followers');
        $followers = $user->followers()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('users.followers', [
            'user'      => $user,
            'followers' => $followers,
        ]);
    }

    public function follow(Request $request, string $name)
    {
        $user = $this->userRepository->findByName($name);

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['name' => $name];
    }

    public function unfollow(Request $request, string $name)
    {
        $user = $this->userRepository->findByName($name);

        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }

    /**
     * プライバシーポリシーを表示
     *
     * @return Application|Factory|View
     */
    public function showPrivacyPolicy()
    {
        return view('users.privacy_policy');
    }
}
