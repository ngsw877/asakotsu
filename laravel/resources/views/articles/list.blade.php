@if($articles->isEmpty())
  @include('not_exist', ['message' => '投稿がありません。'])
@endif

@foreach($articles as $article)
  @include('articles.card')
@endforeach
