<div class="card mb-4">
  <div class="card-body">
    <div class="d-flex justify-content-between row">
      <div class="col-2">
        <a href="{{ route('users.show', ['name' => $person->name]) }}" class="text-dark">
          <img src="{{ $person->profile_image }}" class="user-icon rounded-circle mr-3" alt="プロフィールアイコン">
        </a>
      </div>
      <div class="col-2">
        @if( Auth::id() !== $person->id )
          <follow-button
            class="ml-auto"
            :initial-is-followed-by='@json($person->isFollowedBy(Auth::user()))'
            :authorized='@json(Auth::check())'
            endpoint="{{ route('users.follow', ['name' => $person->name]) }}"
          >
          </follow-button>
        @endif
      </div>
    </div>
    <h2 class="h5 card-title mt-2">
      <a href="{{ route('users.show', ['name' => $person->name]) }}" class="text-dark">{{ $person->name }}</a>
    </h2>
  </div>
</div>
