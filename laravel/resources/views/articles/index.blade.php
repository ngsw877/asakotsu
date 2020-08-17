@extends('app')

@section('title', '投稿一覧 | AsaKotsu')

@section('content')

  @include('nav')

  <div class="container">
    @foreach($articles as $article)

      @include('articles.card')

    @endforeach
  </div>

@endsection
