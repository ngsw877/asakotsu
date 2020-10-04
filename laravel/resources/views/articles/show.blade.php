@extends('app')

@section('title', '投稿詳細')

@section('content')

  @include('nav')

  <div class="container">
    @include('articles.card')

    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <ul class="list-group">
                @forelse ($comments as $comment)
                    <li class="list-group-item">
                        <div class="py-3 w-100 d-flex">
                            <img class="profile-icon rounded-circle" src="{{ asset('/images/profile/' .$comment->user->profile_image) }}" alt="プロフィールアイコン">
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0">{{ $comment->user->name }}</p>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="py-3">
                            {!! nl2br(e($comment->comment)) !!}
                        </div>
                    </li>
                @empty
                    <li class="list-group-item mt-3">
                        <p class="mb-0 text-secondary">コメントはまだありません。</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
  </div>

@endsection
