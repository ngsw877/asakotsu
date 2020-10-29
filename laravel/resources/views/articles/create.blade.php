@extends('app')

@section('title', '投稿画面')

@include('nav')

@section('content')
  <div class="container my-5">
    <div class="row">
      <div class="mx-auto col-md-8">
        <div class="card">
          <h2 class="h4 card-header text-center sunny-morning-gradient text-white">投稿する</h2>
          <div class="card-body pt-3">

            @include('error_card_list')

            <div class="card-text">
              <form method="POST" class="w-75 mx-auto" action="{{ route('articles.store') }}">

                @include('articles.form')

                <button type="submit" class="btn peach-gradient btn-block">投稿する</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
