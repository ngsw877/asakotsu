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
              <form method="POST" action="{{ route('meetings.create') }}">
                @csrf

                <input type="hidden" name="type" value="2">
                <div class="form-group h5">
                  <label for="topic">ミーティング名</label>
                  <input class="form-control" type="text" id="topic" name="topic" required value="{{ old('topic') }}">
                </div>
                <div class="form-group h5">
                  <label for="agenda">テーマ</label>
                  <input class="form-control" type="text" id="agenda" name="agenda" value="{{ old('agenda') }}">
                </div>
                <div class="form-group h5">
                  <label for="start_time">開始日時</label>
                  <input class="form-control" type="start_time" id="start_time" name="start_time" required>
                </div>

                <!-- 次回から自動でログインする(remember meトークン) -->
                <input type="hidden" name="remember" id="remember" value="on">

                <button class="btn btn-block peach-gradient mt-2 mb-2" type="submit" text-while>ミーティングを作成！</button>

              </form>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

