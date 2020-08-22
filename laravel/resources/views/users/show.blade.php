@extends('app')

@section('title', $user->name)

@section('content')
  @include('nav')
  <div class="container">
    <div class="card mt-3">
      <div class="card-body">
        <div class="d-flex flex-row">
          <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
            <i class="fas fa-user-circle fa-3x"></i>
          </a>
          @if (Auth::id() !== $user->id)
            <follow-button
             class="ml-auto"
             :initial-is-followed-by='@json($user->isFollowedBy(Auth::user()))'
             :authorized='@json(Auth::check())'
             endpoint="{{ route('users.follow', ['name' => $user->name]) }}"
            >
            </follow-button>
          @endif
        </div>
        <h2 class="h5 card-title m-0">
          <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
            {{ $user->name }}
          </a>
        </h2>
      </div>
      <div class="card-body">
        <div class="card-text">
          <a href="" class="text-muted">
            {{ $user->count_followings }} フォロー
          </a>
          <a href="" class="text-muted">
            {{ $user->count_followers }} フォロワー
          </a>
        </div>
      </div>
    </div>
    <ul class="nav nav-tabs nav-justified mt-3">
      <li class="nav-item">
        <a class="nav-link text-muted active"
           href="{{ route('users.show', ['name' => $user->name]) }}">
          投稿
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-muted"
           href="">
          いいね
        </a>
      </li>
    </ul>
    @foreach($articles as $article)
      @include('articles.card')
    @endforeach
  </div>
@endsection
