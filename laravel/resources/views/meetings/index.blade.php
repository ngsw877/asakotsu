@extends('app')

@section('title', 'ミーティング一覧 | AsaKotsu')

@section('content')

  @include('nav')

  <div class="container mt-4">

    <div class="row">
     <div class="mx-auto col-md-8">
        @include('meetings.list', compact('meetings'))

        <!-- 無限スクロールのsppiner -->
        @if ($meetings->nextPageUrl())
          <a href="{{ $meetings->nextPageUrl() }}" infinity-scroll>
            <div class="d-flex justify-content-center my-4">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
          </a>
        @endif
     </div>
    </div>

    @include('meetings.new_post_btn')

  </div>


@endsection
