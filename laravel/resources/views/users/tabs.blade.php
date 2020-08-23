<ul class="nav nav-tabs nav-justified mt-3">
  <li class="nav-item">
    <a class="nav-link text-muted {{ $hasArticles ? 'active' : '' }}"
       href="{{ route('users.show', ['name' => $user->name]) }}">
      投稿
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-muted {{ $hasLikes ? 'active' : '' }}"
       href="{{ route('users.likes', ['name' => $user->name]) }}">
      いいね
    </a>
  </li>
</ul>
