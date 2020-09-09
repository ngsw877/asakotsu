@extends('app')

@section('title', 'ミーティング一覧 | AsaKotsu')

@section('content')

  @include('nav')

  <div class="container">
    @foreach($meetings as $meeting)

      @include('meetings.card')

    @endforeach
  </div>

@endsection
