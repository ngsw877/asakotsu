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
                    @forelse ($comments as $comment)
                        <li class="list-group-item">
                            <div class="py-3 w-100 d-flex">
                                <a href="{{ route('users.show', ['name' => $comment->user->name]) }}" class="in-link text-dark">
                                    <img class="user-icon rounded-circle" src="{{ $comment->user->profile_image }}" alt="プロフィールアイコン">
                                </a>
                                <div class="ml-2 d-flex flex-column">
                                    <a href="{{ route('users.show', ['name' => $comment->user->name]) }}" class="in-link text-dark">
                                        <p class="font-weight-bold mb-0">
                                            {{ $comment->user->name }}
                                        </p>
                                    </a>
                                </div>
                                <div class="d-flex justify-content-end flex-grow-1">
                                    <p class="mb-0 font-weight-lighter">
                                        {{ $comment->created_at->format('Y-m-d H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="py-3">
                                {!! nl2br(e($comment->comment)) !!}
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item ">
                            <p class="mb-0 text-secondary">コメントはまだありません。</p>
                        </li>
                    @endforelse
                    @guest
                        <li class="list-group-item ">
                            <p class="mb-0 text-secondary">ログインするとコメントできるようになります。</p>
                        </li>
                    @endguest
                    @auth
                        <!-- コメント投稿フォーム -->
                        <li class="list-group-item">
                            <div class="py-3">
                                <form method="POST" action="{{ route('comments.store') }}">
                                    @csrf

                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 p-3 w-100 d-flex">
                                            <a href="{{ route('users.show', ['name' => Auth::user()->name]) }}" class="in-link text-dark">
                                                <img class="user-icon rounded-circle" src="{{ Auth::user()->profile_image }}" alt="プロフィールアイコン">
                                            </a>
                                            <div class="ml-2 d-flex flex-column font-weight-bold">
                                                <a href="{{ route('users.show', ['name' => Auth::user()->name]) }}" class="in-link text-dark">
                                                    <p class="mb-0">{{ Auth::user()->name }}</p>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                                            <textarea class="form-control @error('comment') is-invalid @enderror" name="comment"  rows="4">
                                            @error('comment')
                                                {{ old('comment') }}
                                            @enderror
                                            </textarea>
                                            @error('comment')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-12 text-right">
                                            <p class="mb-4 text-danger">250文字以内</p>
                                            <button type="submit" class="btn peach-gradient">
                                                コメントする
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
