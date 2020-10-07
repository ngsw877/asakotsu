@extends('app')

@section('title', '投稿一覧 | AsaKotsu')

@section('content')

  @include('nav')

  <div class="container">
    @foreach($articles as $article)

      @include('articles.card')

    @endforeach
  </div>
  <div class="new-post">
    <a class="new-article-btn" href="{{ route('articles.create') }}">
      <p>新規投稿</p>
      <i class="fas fa-plus"></i>
    </a>
  </div>

@endsection
