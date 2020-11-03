@extends('app')

@section('title', '投稿画面')

@include('nav')

@section('content')
  <div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-7">
        <div class="card">
          <h2 class="h4 card-header text-center sunny-morning-gradient text-white">メッセージを投稿しましょう！</h2>
          <div class="card-body pt-3">
            <div class="text-center mt-3">
            <p class="text-primary m-0">
              <i class="fas fa-sun mr-1"></i>目標起床時間より前に投稿できると、早起き達成です！
            </p>
            <p class="text-muted m-0">
            （ {{ $user->wake_up_time->copy()->subHour($user->range_of_success)->format('H:i') }} 〜 {{ $user->wake_up_time->format('H:i') }} ）
            </p>
            </div>

            @include('error_card_list')

            <div class="card-text">
              <form method="POST" class="w-75 mx-auto" action="{{ route('articles.store') }}">

                @include('articles.form')

                <button type="submit" class="btn peach-gradient btn-block">
                  <span class="h6">送信</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
