@extends('app')

@section('title', 'Zoomミーティングを開始')

@section('content')

  @include('nav')

  <div class="container mt-5">
    <div class="row">
      <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
        <div class="card mt-3">
          <div class="card-body text-center">
            <h2 class="h3 card-title text-center mt-2">Zoomミーティングを作成しましょう！</h2>

            @include('error_card_list')

            <div class="card-text mt-5">
              <form method="POST" action="{{ route('meetings.store') }}">
                @csrf

                <div class="form-group h5">
                  <label for="topic">ミーティング名</label>
                  <input class="form-control" type="text" id="topic" name="topic" required value="{{ old('topic') }}">
                </div>
                <div class="form-group h5">
                  <label for="agenda">テーマ</label>
                  <input class="form-control" type="text" id="agenda" name="agenda" value="{{ old('agenda') }}">
                </div>
                <div class="row">
                  <div class="form-group h5 col-xs-2 mx-auto">
                    <label for="start_time">開始日時</label>
                    <input class="form-control" type="datetime-local" id="start_time" name="start_time" value="{{ date('Y-m-d\Th:i') }}" required>
                  </div>
                </div>
                <button class="btn btn-block peach-gradient mt-2 mb-2" type="submit" text-while>
                  <span class="h5">ミーティングを作成する</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

