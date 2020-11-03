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
                    <img class="profile-icon image-upload rounded-circle" src="{{ $user->profile_image }}" alt="プロフィールアイコン">
                    <input type="file" name="profile_image" id="profile_image" class="d-none">
                  </label>
                </div>
                @if (Auth::user()->name == 'ゲストユーザー')
                  <p class="text-danger">※ゲストユーザーは、ユーザー名とメールアドレスを編集できません。</p>
                @endif
                <div class="form-group">
                  <label for="name">
                    ユーザー名
                    <small class="blue-grey-text">（15文字以内）</small>
                  </label>
                  @if (Auth::user()->name == 'ゲストユーザー')
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
                  <label for="wake_up_time">
                    目標起床時間
                    <small class="blue-grey-text">（04:00 〜 10:00）</small>
                    <p class="mb-1 small text-default">※動作確認用に、現在自由に目標起床時間を設定できます。</p>
                  </label>
                  <!-- 動作確認用に、目標起床時間の設定可能時間帯の制限を解除中。　min="04:00" max="10:00" -->
                  <input class="form-control" type="time" id="wake_up_time" name="wake_up_time"
                  value="{{
                    null !== old('wake_up_time') ?
                    Carbon\Carbon::parse(old('wake_up_time'))->format('H:i') :
                    $user->wake_up_time->format('H:i')
                  }}">
                </div>
                <div class="form-group">
                  <label for="email">
                    自己紹介文
                    <small class="blue-grey-text">（200文字以内）</small>
                  </label>
                  <textarea name="self_introduction" class="form-control" rows="8">{{ $user->self_introduction ?? old('self_introduction') }}</textarea>
                </div>
                <button class="btn peach-gradient mt-2 mb-2" type="submit">
                  <span class="h6">保存</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
