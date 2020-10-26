<div class="card mb-4 sidebar-content">
    <div class="card-header text-center">
        <i class="fas fa-crown mr-2 text-warning"></i>早起き達成日数ランキング
    </div>
    <div class="card-body user-ranking-list">
        @foreach ($ranked_users  as $key => $ranked_user)
            <div class="d-flex justify-content-between">
                <p class="ranking-icon{{ $key + 1 }}">
                    {{ $key + 1 }}
                </p>
                <a  class="block" href="{{ route('users.show', ['name' => $ranked_user->name]) }}">
                    <p>{{$ranked_user->name}}さん</p>
                </a>
                <p class="h5">{{ $ranked_user->achivement_days_count }}日</p>
            </div>
        @endforeach
    </div>
</div>
