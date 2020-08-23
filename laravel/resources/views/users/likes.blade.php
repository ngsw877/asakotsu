@extends('app')

@section('title', $user->name . 'さんのいいねした投稿')

@section('content')
  @include('nav')
  <div class="container">
    @include('users.user')
    <ul class="nav nav-tabs nav-justified mt-3">
      <li class="nav-item">
        <a class="nav-link text-muted"
           href="{{ route('users.show', ['name' => $user->name]) }}">
          投稿
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-muted active"
           href="{{ route('users.likes', ['name' => $user->name]) }}">
          いいね
        </a>
      </li>
    </ul>
    @foreach($articles as $article)
      @include('articles.card')
    @endforeach
  </div>
@endsection
