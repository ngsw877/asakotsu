@extends('app')

@section('title', 'ユーザー登録')

@section('content')

  @include('nav')

  <div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-8 ">
        <div class="card">
          <h2 class="h4 card-header text-center">ユーザー登録</h2>
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
                  </label>
                  <input class="form-control" type="time" id="wake_up_time" name="wake_up_time" min="04:00" max="10:00"
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
                <button class="btn btn-primary mt-2 mb-2" type="submit">
                  ユーザー登録
                </button>
              </form>
              <div class="mt-0">
                <a href="{{ route('login') }}" class="card-text">ログインはこちら</a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
