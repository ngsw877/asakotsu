<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- twitterサマリーカード  -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:site" content="@nasuB7373" />
  <meta property="og:url" content="https://pf.asakotsu.com/" />
  <meta property="og:title" content="Asakotsu" />
  <meta property="og:description" content="朝活に特化したSNSアプリです。仲間を作り、朝活の継続にチャレンジしてみませんか？" />
  <meta property="og:image" content="https://asakotsu.s3-ap-northeast-1.amazonaws.com/images/summary_card_morning.png" />

  <title>
    @yield('title')
  </title>
  <!-- favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="https://asakotsu.s3-ap-northeast-1.amazonaws.com/images/favicon.ico">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/css/mdb.min.css" rel="stylesheet">
  <!-- CSS -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- toastr -->
    @toastr_css
</head>
<body>

  <div id="app">
    @yield('content')
  </div>

  <!-- JQuery -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <!-- inview.js -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-inview@1.1.2/jquery.inview.min.js"></script>

  <!-- Popper.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>

  <!-- toastr -->
  @toastr_js
  @toastr_render

  <!-- JavaScript -->
  <script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
