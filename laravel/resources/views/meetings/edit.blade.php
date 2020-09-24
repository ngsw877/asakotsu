@extends('app')

@section('title', 'ミーティング更新')

@include('nav')

@section('content')

  <div class="container mt-5">
    <div class="row">
      <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
        <div class="card mt-3">
          <div class="card-body text-center">
            <h2 class="h3 card-title text-center mt-2">Zoomミーティングを編集</h2>

            @include('error_card_list')

            <div class="card-text mt-5">
              <form method="POST" action="{{ route('meetings.update', ['meeting' => $meeting]) }}">
                @method('PATCH')
                @include('meetings.form')

                <button class="btn btn-block peach-gradient mt-2 mb-2" type="submit" text-while>
                  <span class="h5">ミーティングを更新する</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
