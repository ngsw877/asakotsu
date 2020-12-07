<nav class="navbar navbar-expand navbar-dark sunny-morning-gradient sticky-top">

  <div class="container d-flex justify-content-center px-4">
    <a class="navbar-brand mr-auto" href="/" style="font-size:1.5rem;"><i class="fas fa-sun mr-1"></i>Asakotsu</a>

    @include('hamburger_menu')

    <form method="GET" action="{{ route('articles.index') }}" class="form-inline w-25">
      <input class="form-control w-100" name="search" type="search" placeholder="🔍  投稿を検索" aria-label="Search">
    </form>

    <ul class="navbar-nav ml-auto d-none d-md-flex align-items-center">

      @guest
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus mr-1"></i>ユーザー登録</a>
      </li>

      <li class="nav-item">
        <a class="nav-link mr-2" href="{{ route('login') }}"><i class="fas fa-sign-in-alt mr-1"></i>ログイン</a>
      </li>

      <li class="nav-item bg-default rounded">
        <a class="nav-link waves-effect waves-light" href="{{ route('login.guest') }}"><i class="fas fa-user-check mr-1"></i>かんたんログイン</a>
      </li>
      @endguest

      @auth
      <li class="nav-item">
        <a class="nav-link" href="{{ route('meetings.index') }}"><i class="fas fa-video mr-1"></i>Zoom朝活</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('articles.create') }}"><i class="fas fa-pen mr-1"></i>投稿する</a>
      </li>

      <!-- Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <img class="user-mini-icon  rounded-circle" src="{{ Auth::user()->profile_image }}">
          {{ Auth::user()->name }}さん
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
          <button class="dropdown-item" type="button"
                  onclick="location.href='{{ route("users.show", ["name" => Auth::user()->name]) }}'">
            マイページ
          </button>
          <div class="dropdown-divider"></div>
          <button form="logout-button" class="dropdown-item" type="submit">
            ログアウト
          </button>
        </div>
      </li>
      <form id="logout-button" method="POST" action="{{ route('logout') }}">
        @csrf
      </form>
      <!-- Dropdown -->
      @endauth

    </ul>
  </div>

</nav>
