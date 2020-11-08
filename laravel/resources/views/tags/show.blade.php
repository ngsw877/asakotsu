@extends('app')

@section('title', $tag->hashtag)

@section('content')
  @include('nav')

  <div class="container mt-4">
    <div class="row d-flex justify-content-center">
      <div class="row col-md-12">

        <aside class="col-3 d-none d-md-block position-fixed">
          @include('sidebar.list')
        </aside>

        <main class="col-md-7 offset-md-5">
          <div class="card peach-gradient text-white mb-4">
            <div class="card-body text-center p-3">
              <h2 class="h4 card-title m-0">{{ $tag->hashtag }}</h2>
              <div class="text-right">
                {{ $tag->articles->count() }}件
              </div>
            </div>
          </div>
          @foreach($tag->articles as $article)
            @include('articles.card')
          @endforeach
        </main>

        @auth
        <div class="new-post">
          <a class="new-article-btn" href="{{ route('articles.create') }}">
            <p>新規投稿</p>
            <i class="fas fa-plus"></i>
          </a>
        </div>
        @endauth
      </div>
    </div>
  </div>
@endsection
