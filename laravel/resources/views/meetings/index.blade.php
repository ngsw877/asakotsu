@extends('app')

@section('title', 'ミーティング一覧 | AsaKotsu')

@section('content')

  @include('nav')

  <div class="container mt-2 mb-5">
    @foreach($meetings as $meeting)

      @include('meetings.card')

    @endforeach
  </div>
  <div class="new-post">
    <a class="new-post-btn" href="{{ route('meetings.create') }}">
      <p>ミーティング作成</p>
      <i class="fas fa-plus"></i>
    </a>
  </div>

@endsection
