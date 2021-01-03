<!DOCTYPE html>
<html lang="ja">
<head>
  @if(env('APP_ENV') == 'production')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-183933310-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-183933310-2');
    </script>
  @endif
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <!-- JavaScript -->
  <script src="{{ mix('js/app.js') }}"></script>

  <!-- フラッシュメッセージ -->
  <script>
    // 成功時
    @if (session('msg_success'))
        $(function () {
            toastr.success('{{ session('msg_success') }}');
        });

    // 失敗時
    @elseif (session('msg_error'))
      $(function () {
            toastr.error('{{ session('msg_error') }}');
        });
        
    @endif
  </script>

</body>
</html>
