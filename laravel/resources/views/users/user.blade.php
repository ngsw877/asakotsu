<div class="card mt-3">
      <div class="card-body">
        <div class="d-flex flex-row row">
          <div class="col-md-3">
            <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
              <img class="profile-icon rounded-circle" src="/images/profile/{{ $user->profile_image }}" alt="プロフィールアイコン">
            </a>
          </div>
          <div class="col-md-5">
            <div class="d-flex flex-row mb-4">
              <div class="mr-5">
                <h2 class="h5 card-title font-weight-bold mb-3">
                  <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
                    {{ $user->name }}
                  </a>
                </h2>
                <p class="text-primary m-0">
                <i class="fas fa-clock mr-2"></i>目標起床時間：{{ $user->wake_up_time->format('H:i') }}
                </p>
              </div>
                <div class=" text-white text-center">
                  <p class="bg-warning mb-0 p-2">
                    10月の<br>
                    早起き達成日数
                  </p>
                  <p class="bg-danger h4 p-2">{{ $user->achivement_days_count }}日</p>
                </div>
            </div>
            @if (isset($user->self_introduction))
              <p>{{ $user->self_introduction }}</p>
            @endif
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
        <div>
          <a href="{{ route('users.followings', ['name' => $user->name]) }}" class="text-muted mr-3">
            {{ $user->count_followings }} フォロー
          </a>
          <a href="{{ route('users.followers', ['name' => $user->name]) }}" class="text-muted">
            {{ $user->count_followers }} フォロワー
          </a>
        </div>
      </div>
    </div>
