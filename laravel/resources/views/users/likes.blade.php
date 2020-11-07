@extends('app')

@section('title', $user->name . 'さんのいいねした投稿')

@section('content')

  @include('nav')

  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-9">
        @include('users.user')
        @include('users.tabs', ['hasArticles' => false, 'hasLikes' => true])

        @include('articles.list', compact('articles'))
        <!-- 無限スクロールのsppiner -->
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
    </div>
  </div>

@endsection
