@extends('app')

@section('title', $user->name . 'さんのフォロワー')

@section('content')

  @include('nav')

  <div class="container mt-4">
    <div class="row  justify-content-center">

      <div class="col-md-9">
        @include('users.user')

        @include('users.tabs', ['hasArticles' => false, 'hasLikes' => false])

        @foreach($followers as $person)
          @include('users.person')
        @endforeach

        {{ $followers->links('pagination::default') }}
      </div>

    </div>
  </div>
@endsection
