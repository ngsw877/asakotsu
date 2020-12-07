<!-- ハンバーガーメニューボタン -->
<section class="hamburger d-md-none">
  <a href="#" class="nav-button">
    <span></span>
    <span></span>
    <span></span>
  </a>
</section>

<!-- ハンバーガーメニューのモダル -->
<nav class="menu-area sunny-morning-gradient d-md-none">
  <ul class="nav-modal mb-0 text-center">
  @guest
    <li>
      <a class="waves-effect waves-light" href="{{ route('register') }}">
        <i class="fas fa-user-plus mr-1"></i>
        ユーザー登録
      </a>
    </li>

    <li>
      <a class="waves-effect waves-light" href="{{ route('login') }}">
        <i class="fas fa-sign-in-alt mr-1"></i>
        ログイン
      </a>
    </li>

    <li class="bg-default rounded">
      <a class="waves-effect waves-light" href="{{ route('login.guest') }}">
        <i class="fas fa-user-check mr-1"></i>
        かんたんログイン
      </a>
    </li>
  @endguest

  @auth
      <li>
        <a class="waves-effect waves-light" href="{{ route('meetings.index') }}">
          <i class="fas fa-video mr-2"></i>
          Zoom朝活
        </a>
      </li>

      <li>
        <a class="waves-effect waves-light" href="{{ route('articles.create') }}">
          <i class="fas fa-pen mr-2"></i>
          投稿する
        </a>
      </li>

      <li>
        <a class="waves-effect waves-light" onclick="location.href='{{ route("users.show", ["name" => Auth::user()->name]) }}'">
        <i class="fas fa-user mr-1"></i>
          マイページ
        </a>
      </li>
      <form id="logout-button" method="POST" action="{{ route('logout') }}" class="mb-0">
        @csrf
      <li>

        <button form="logout-button" class="button-reset waves-effect waves-light text-white" type="submit" style="padding: 15px 10px; width:100%;">
          <i class="fas fa-sign-out-alt mr-1"></i>
          ログアウト
        </button>
      </li>
      </form>
      @endauth

  </ul>
</nav>
