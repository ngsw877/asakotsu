@extends('app')

@section('title', 'プロフィール編集')

@include('nav')

@section('content')
<div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-7">
        <div class="card">
          <h2 class="h4 card-header text-center sunny-morning-gradient text-white">プロフィール編集</h2>
          <div class="card-body">

            @include('error_card_list')

            <div class="user-form my-4">
              <form method="POST" action="{{ route('users.update', ['name' => $user->name]) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group text-center">
                  <label for="profile_image">
                    <p class="mb-1">プロフィール画像</p>
                    <img class="profile-icon image-upload rounded-circle" src="{{ $user->profile_image }}" alt="プロフィールアイコン">
                    <input type="file" name="profile_image" id="profile_image" class="d-none" accept="image/*">
                  </label>
                </div>
                @if (Auth::user()->email == 'guest@guest.com')
                  <p class="text-danger">※ゲストユーザーは、ユーザー名とメールアドレスを編集できません。</p>
                @endif
                <div class="form-group">
                  <label for="name">
                    ユーザー名
                    <small class="blue-grey-text">（15文字以内）</small>
                  </label>
                  @if (Auth::user()->email == 'guest@guest.com')
                    <input class="form-control" type="text" id="name" name="name" value="{{ $user->name }}" readonly>
                  @else
                    <input class="form-control" type="text" id="name" name="name" value="{{ $user->name ?? old('name') }}">
                  @endif
                </div>
                <div class="form-group">
                  <label for="email">メールアドレス</label>
                  @if (Auth::user()->email == 'guest@guest.com')
                    <input class="form-control" type="text" id="email" name="email" value="{{ $user->email }}" readonly>
                  @else
                    <input class="form-control" type="text" id="email" name="email" value="{{ $user->email ?? old('email') }}">
                  @endif
                </div>
                <div class="form-group">
                  <label for="email">
                    自己紹介文
                    <small class="blue-grey-text">（200文字以内）</small>
                  </label>
                  <textarea name="self_introduction" class="form-control" rows="8">{{ $user->self_introduction ?? old('self_introduction') }}</textarea>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <button class="btn peach-gradient mt-2 mb-2" type="submit">
                    <span class="h6">保存</span>
                  </button>
                  <a href="{{ route('users.edit_password', ['name' => $user->name]) }}">パスワード変更はこちら</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
