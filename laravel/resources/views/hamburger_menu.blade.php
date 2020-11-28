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
      <a href="{{ route('register') }}">
        <i class="fas fa-user-plus mr-1"></i>
        ユーザー登録
      </a>
    </li>

    <li>
      <a href="{{ route('login') }}">
        <i class="fas fa-sign-in-alt mr-1"></i>
        ログイン
      </a>
    </li>

    <li class="bg-default rounded">
      <a class="nav-link waves-effect waves-light" href="{{ route('login.guest') }}">
        <i class="fas fa-user-check mr-1"></i>
        かんたんログイン
      </a>
    </li>
  @endguest

  </ul>
</nav>
