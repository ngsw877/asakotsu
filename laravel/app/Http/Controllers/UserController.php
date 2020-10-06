<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function show(string $name)
    {
        $user = User::where('name', $name)->first()->load(['articles.user', 'articles.likes', 'articles.tags']);
        $articles = $user->articles->sortByDesc('created_at');

        return view('users.show', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    public function edit(string $name)
    {
        $user = User::where('name', $name)->first();
        return view('users.edit', ['user' => $user]);
    }

    // public function update(string $name)
    // {

    // }

    // public function destroy(string $name)
    // {

    // }

    public function likes(string $name)
    {
        $user = User::where('name', $name)->first()->load(['likes.user', 'likes.likes', 'likes.tags']);
        $articles = $user->likes->sortByDesc('created_at');

        return view('users.likes', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    public function followings(string $name)
    {
        $user = User::where('name', $name)->first()->load('followings.followers');
        $followings = $user->followings->sortByDesc('created_at');

        return view('users.followings', [
            'user' => $user,
            'followings' => $followings,
        ]);
    }

    public function followers(string $name)
    {
        $user = User::where('name', $name)->first()->load('followers.followers');;
        $followers = $user->followers->sortByDesc('created_at');

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

        public function index(Request $request){
            $authUser = Auth::user();
            $users = User::all();
            $param = [
                'authUser'=>$authUser,
                'users'=>$users
            ];
            return view('users.index',$param);
        }

        public function userEdit(Request $request){
            $authUser = Auth::user();
            $param = [
                'authUser'=>$authUser,
            ];
            return view('users.userEdit',$param);
        }

        public function userUpdate(Request $request){
            // Validator check
            $rules = [
                'user_id' => 'integer|required',
                'name' => 'required',
            ];
            $messages = [
                'user_id.integer' => 'SystemError:システム管理者にお問い合わせください',
                'user_id.required' => 'SystemError:システム管理者にお問い合わせください',
                'name.required' => 'ユーザー名が未入力です',
            ];
            $validator = Validator::make($request->all(),$rules,$messages);

            if($validator->fails()){
                return redirect('/users/userEdit')
                    ->withErrors($validator)
                    ->withInput();
            }

            $uploadfile = $request->file('thumbnail');

              if(!empty($uploadfile)){
                $thumbnailname = $request->file('thumbnail')->hashName();
                $request->file('thumbnail')->storeAs('public/user', $thumbnailname);

                $param = [
                    'name'=>$request->name,
                    'thumbnail'=>$thumbnailname,
                ];
              }else{
                   $param = [
                        'name'=>$request->name,
                   ];
              }

            User::where('id',$request->user_id)->update($param);
            return redirect(route('users.userEdit'))->with('success', '保存しました。');
    }




}
