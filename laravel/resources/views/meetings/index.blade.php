@extends('app')

@section('title', 'ミーティング一覧 | AsaKotsu')

@section('content')

  @include('nav')

  <div class="container mt-4">

    <div class="row">
      <div class="mx-auto col-md-8">
          @include('meetings.list', compact('meetings'))

          @include('meetings.sppiner')
      </div>
    </div>

    @include('meetings.new_post_btn')

  </div>


@endsection
