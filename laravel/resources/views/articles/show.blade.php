@extends('app')

@section('title', '投稿詳細')

@section('content')

@include('nav')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="mb-3">
                @include('articles.card')
            </div>

            <div class="mb-3">
                <ul class="list-group card mt-3">
                    <!-- コメント一覧 -->
                    @include('comments.card')

                    @guest
                        <li class="list-group-item ">
                            <p class="mb-0 text-secondary">ログインするとコメントできるようになります。</p>
                        </li>
                    @endguest
                    @auth
                        <!-- コメント投稿フォーム -->
                        @include('comments.form')
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
