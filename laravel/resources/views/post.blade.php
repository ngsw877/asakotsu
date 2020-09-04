<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <table class="table table-striped table-dark mt-5">
                        <tr>
                            <th>タイトル</th>
                            <th>いいね数</th>
                            <th>コメント数</th>
                            <th>作成日</th>
                        </tr>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{$post['title']}}</td>
                            <td>{{$post['likes_count']}}</td>
                            <td>{{$post['comments_count']}}</td>
                            <td>{{$post['created_at']}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
