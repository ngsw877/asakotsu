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
        @foreach ($rankedUsers as $rankedUser)
        <div class="d-flex">
            <p class="ranking-icon{{ $rankedUser->rank }} mr-3">
                {{ $rankedUser->rank}}
            </p>
            <a class="mr-1" href="{{ route('users.show', ['name' => $rankedUser->name]) }}">
                <img class="user-mini-icon rounded-circle mr-2" src="{{ $rankedUser->profile_image }}">
                {{$rankedUser->name}}さん
            </a>
            <p class="h5 ml-auto">{{ $rankedUser->achievement_days_count }} 日</p>
        </div>
        @endforeach
    </div>
</div>
