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
                  <label for="name">ユーザー名</label>
                  <input class="form-control" type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="2〜16文字(登録後の変更はできません)">
                </div>
                <div class="form-group">
                  <label for="email">メールアドレス</label>
                  <input class="form-control" type="text" id="email" name="email" required value="{{ old('email') }}">
                </div>
                <div class="form-group">
                  <label for="password">パスワード</label>
                  <input class="form-control" type="password" id="password" name="password" required placeholder="8文字以上で入力してください">
                </div>
                <div class="form-group">
                  <label for="password_confirmation">パスワード(確認)</label>
                  <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="form-group">
                  <label for="profile_image">プロフィール画像</label>
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
