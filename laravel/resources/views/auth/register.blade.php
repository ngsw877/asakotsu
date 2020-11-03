@extends('app')

@section('title', 'ユーザー登録')

@section('content')

  @include('nav')

  <div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-7">
        <div class="card">
          <h2 class="h4 card-header text-center sunny-morning-gradient text-white">ユーザー登録</h2>
          <div class="card-body">

            @include('error_card_list')

            <div class="user-form my-4">
              <form method="POST" action="{{ route('register') }} " enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <label for="name">
                    ユーザー名
                    <small class="text-danger">（必須）</small>
                  </label>
                  <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="※15文字以内">
                </div>
                <div class="form-group">
                  <label for="email">
                    メールアドレス
                    <small class="text-danger">（必須）</small>
                  </label>
                  <input class="form-control" type="text" id="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                  <label for="password">
                    パスワード
                    <small class="text-danger">（必須）</small>
                  </label>
                  <input class="form-control" type="password" id="password" name="password" placeholder="※8文字以上">
                </div>
                <div class="form-group">
                  <label for="password_confirmation">
                    パスワード
                    <small class="text-danger">（必須）</small>
                  </label>
                  <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
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
                    '07:00'
                  }}">
                </div>
                <div class="form-group">
                  <label for="profile_image">
                    プロフィール画像
                    <small class="blue-grey-text">（任意）</small>
                  </label>
                  <input  type="file" id="profile_image" name="profile_image" accept="image/*">
                </div>
                <button class="btn btn-block peach-gradient mt-2 mb-2" type="submit">
                  <span class="h6">ユーザー登録</span>
                </button>
              </form>
              <div class="mt-3">
                <a href="{{ route('login') }}" class="text-primary">ログインはこちら</a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
