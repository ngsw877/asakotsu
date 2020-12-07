@extends('app')

@section('title', '投稿一覧 | AsaKotsu')

@section('content')

@include('nav')

@if(session('msg_achievement'))

<!-- 早起き達成時のメッセージを表示するモーダルウィンドウ -->
<div class="modal fade" id="achievement-modal" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center font-weight-bold">
        <p class="h5 text-primary  font-weight-bold mb-3">
          <i class="fas fa-award mr-2"></i>
          {{ session('msg_achievement') }}
        </p>
        <p>
          <span class="d-inline-block">{{ date('m') }}月の早起き　</span>
          <span class="d-inline-block rounded peach-gradient text-white p-1">
            {{
              \Auth::user()->achievement_days()
              ->where('date', '>=', \Carbon\Carbon::now()->startOfMonth()->toDateString())
              ->where('date', '<=', \Carbon\Carbon::now()->endOfMonth()->toDateString())
              ->count()
            }}日目
          </span>
        </p>
      </div>
    </div>
  </div>
</div>
@endif

<div class="container mt-4">
  <div class="row d-flex justify-content-center">
    <div class="row col-md-12">

      <aside class="col-3 d-none d-md-block position-fixed">
        @include('sidebar.list')
      </aside>

      <main class="col-md-7 offset-md-5">

        @include('articles.list', compact('articles'))

        @include('articles.sppiner')

        @include('articles.new_post_btn')
      </main>

    </div>
  </div>
</div>


@endsection
