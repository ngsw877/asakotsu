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
