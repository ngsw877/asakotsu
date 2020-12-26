@extends('app')

@section('title', 'プロフィール編集')

@include('nav')

@section('content')
<div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-7">
        <div class="card">
          <h2 class="h4 card-header text-center sunny-morning-gradient text-white">パスワード編集</h2>
          <div class="card-body">

            @include('error_card_list')

            <div class="user-form my-4">
              <form method="POST" action="{{ route('users.update', ['name' => $user->name]) }}" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-group">
                  <label for="current_password">
                    現在のパスワード
                  </label>
                  <input class="form-control" type="password" id="current_password" name="current_password">
                </div>
                <div class="form-group">
                  <label for="new_password">
                    新しいパスワード
                  </label>
                  <input class="form-control" type="password" id="new_password" name="new_password" placeholder="※8文字以上">
                </div>
                <div class="form-group">
                  <label for="current_password_confirmation">
                    パスワードを確認
                  </label>
                  <input class="form-control" type="password" id="current_password_confirmation" name="current_password_confirmation" placeholder="再入力してください">
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <button class="btn peach-gradient mt-2 mb-2" type="submit">
                    <span class="h6">保存</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
