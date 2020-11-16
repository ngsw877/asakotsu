<nav class="navbar navbar-expand navbar-dark sunny-morning-gradient sticky-top">

  <div class="container d-flex justify-content-center px-4">
    <a class="navbar-brand" href="/" style="font-size:1.5rem;"><i class="fas fa-sun mr-1"></i>Asakotsu</a>

    <ul class="navbar-nav ml-auto">

      @guest
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus mr-1"></i>ユーザー登録</a>
      </li>
      @endguest

      @guest
      <li class="nav-item">
        <a class="nav-link mr-2" href="{{ route('login') }}"><i class="fas fa-sign-in-alt mr-1"></i>ログイン</a>
      </li>
      @endguest

      @guest
      <li class="nav-item bg-default rounded">
        <a class="nav-link waves-effect waves-light" href="{{ route('login.guest') }}"><i class="fas fa-user-check mr-1"></i>かんたんログイン</a>
      </li>
      @endguest

      @auth

      <li class="nav-item">
        <a class="nav-link" href="{{ route('meetings.index') }}"><i class="fas fa-video mr-1"></i>Zoom朝活</a>
      </li>
      @endauth

      @auth
      <li class="nav-item">
        <a class="nav-link" href="{{ route('articles.create') }}"><i class="fas fa-pen mr-1"></i>投稿する</a>
      </li>
      @endauth

      @auth
      <!-- Dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
           aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle"></i>
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
