@extends('app')

@section('title', 'Zoomミーティング作成')

@section('content')

  @include('nav')

  <div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-7">
        <div class="card">
          <h2 class="h4 card-header text-center blue-gradient text-white">Zoomミーティングを作成しましょう！</h2>
          <div class="card-body pt-3">

            @include('error_card_list')

            <div class="my-4">
              <form method="POST" class="w-75 mx-auto" action="{{ route('meetings.store') }}">
                @csrf

                @include('meetings.form')

               <div class="mt-4">
                  <button type="submit" class="btn btn-block blue-gradient">
                    <span class="h6">ミーティング作成</span>
                  </button>
               </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

