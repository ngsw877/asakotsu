<div class="card mb-4 sidebar-content">
    <div class="card-header d-flex align-items-center">
        <p class="m-0 text-center mx-auto">
            <i class="fas fa-crown mr-2 text-warning fa-lg"></i>
            <span class="mr-1">早起き達成日数ランキング</span>
            <span class="p-1 rounded font-weight-bold d-inline-block sunny-morning-gradient text-white">
                {{ date('m') }}月
            </span>
        </p>
    </div>
    <div class="card-body user-ranking-list py-3">
        @foreach ($ranked_users  as $key => $ranked_user)
            <div class="d-flex justify-content-between">
                <p class="ranking-icon{{ $key + 1 }}">
                    {{ $key + 1 }}
                </p>
                <a  class="block" href="{{ route('users.show', ['name' => $ranked_user->name]) }}">
                    <p>{{$ranked_user->name}}さん</p>
                </a>
                <p class="h5">{{ $ranked_user->achievement_days_count }} 日</p>
            </div>
        @endforeach
    </div>
</div>
