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
      <div class="modal-body text-center">
        {{ session('msg_achievement') }}
      </div>
      <div class="modal-footer text-center">
      </div>
    </div>
  </div>
</div>
@endif

<div class="container">
  @include('articles.list', compact('articles'))

  @if ($articles->nextPageUrl())
    <a href="{{ $articles->nextPageUrl() }}" infinity-scroll>
      <div class="d-flex justify-content-center my-4">
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
    </a>
  @endif
</div>

@auth
<div class="new-post">
  <a class="new-article-btn" href="{{ route('articles.create') }}">
    <p>新規投稿</p>
    <i class="fas fa-plus"></i>
  </a>
</div>
@endauth

@endsection
