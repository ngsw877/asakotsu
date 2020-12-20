@extends('app');

@section('title', 'ミーティングエラー')

@section('content')

<div class="container d-flex justify-content-center">
  <div>
    <p class="h5">ミーティング{{ $method }}処理でエラーが発生しました。</p>
    <a href="{{ route('articles.index') }}">トップページに戻る</a>
  </div>
</div>

@endsection
