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

        @include('articles.sppiner')
      </div>
    </div>
  </div>

@endsection
