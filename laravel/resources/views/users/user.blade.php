<div class="card mt-3">
      <div class="card-body">
        <div class="d-flex flex-row row">
          <div class="col-md-3">
            <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
              <img class="profile-icon rounded-circle" src="/images/profile/{{ $user->profile_image }}" alt="プロフィールアイコン">
            </a>
          </div>
          <div class="col-md-5">
            <h2 class="h5 card-title font-weight-bold mb-3">
              <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                {{ $user->name }}
              </a>
            </h2>
            <p>
            テストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストですテストです
            </p>
          </div>
          @if(Auth::id() !== $user->id)
            <follow-button
             class="ml-auto"
             :initial-is-followed-by='@json($user->isFollowedBy(Auth::user()))'
             :authorized='@json(Auth::check())'
             endpoint="{{ route('users.follow', ['name' => $user->name]) }}"
            >
            </follow-button>
          @else
          <div class="ml-auto">
            <a  href="{{ route('users.edit', ['name' => Auth::user()->name]) }}" class="btn btn-success mt-2 mb-2">
              プロフィール編集
            </a>
          </div>
          @endif
        </div>
      </div>
      <div class="card-body">
        <div class="card-text">
          <a href="{{ route('users.followings', ['name' => $user->name]) }}" class="text-muted">
            {{ $user->count_followings }} フォロー
          </a>
          <a href="{{ route('users.followers', ['name' => $user->name]) }}" class="text-muted">
            {{ $user->count_followers }} フォロワー
          </a>
        </div>
      </div>
    </div>
