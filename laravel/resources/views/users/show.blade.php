@extends('app')

@section('title', $user->name)

@section('content')

  @include('nav')

  <div class="container mt-4">
    <div class="row  justify-content-center">

      <div class="col-md-9">
        @include('users.user')

        @include('users.tabs', ['hasArticles' => true, 'hasLikes' => false])

        @include('articles.list', compact('articles'))

        @include('articles.sppiner')
      </div>

    </div>

  </div>
@endsection
