@extends('app')

@section('title', 'ログイン')

@section('content')

  @include('nav')

  <div class="container mt-5">
    <div class="row">
      <div class="mx-auto col-md-7">
        <div class="card mt-3">
          <h2 class="h4 card-header text-center sunny-morning-gradient text-white">ログイン</h2>
          <div class="card-body">

            @include('error_card_list')

            <div class="user-form my-4">
              <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                  <label for="email">メールアドレス</label>
                  <input class="form-control" type="text" id="email" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                  <label for="password">パスワード</label>
                  <input class="form-control" type="password" id="password" name="password" >
                </div>

                <!-- 次回から自動でログインする(remember meトークン) -->
                <input type="hidden" name="remember" id="remember" value="on">

                <button class="btn peach-gradient mt-2 mb-2" type="submit" text-while>ログイン</button>

              </form>

              <div class="mt-0">
                <a href="{{ route('register') }}" class="card-text">ユーザー登録はこちら</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
