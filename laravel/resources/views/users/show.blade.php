@extends('app')

@section('title', $user->name)

@section('content')
  @include('nav')
  <div class="container">
    @include('users.user')
    @include('users.tabs', ['hasArticles' => true, 'hasLikes' => false])

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
@endsection
