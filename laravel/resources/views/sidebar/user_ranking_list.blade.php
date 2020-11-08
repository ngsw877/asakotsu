<div class="card mb-4 sidebar-content">
    <div class="card-header d-flex align-items-center row m-0 text-center">
        <div class="col-10 pl-0">
            <i class="fas fa-crown mr-2 text-warning fa-lg"></i>
            <span class="mr-1">早起き達成ランキング</span>
        </div>
        <div class="col-2 p-1 rounded sunny-morning-gradient d-flex align-items-center justify-content-center font-weight-bold text-white">
            <span class="font-weight-bold text-white">{{ date('m') }}月</span>
        </div>
    </div>
    <div class="card-body user-ranking-list py-3">
        @foreach ($ranked_users as $ranked_user)
        <div class="d-flex justify-content-between">
            <p class="ranking-icon{{ $ranked_user->rank }}">
                {{ $ranked_user->rank}}
            </p>
            <a class="block" href="{{ route('users.show', ['name' => $ranked_user->name]) }}">
                <p>{{$ranked_user->name}}さん</p>
            </a>
            <p class="h5">{{ $ranked_user->achievement_days_count }} 日</p>
        </div>
        @endforeach
    </div>
</div>
