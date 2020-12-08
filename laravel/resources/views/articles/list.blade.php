@if($articles->isEmpty())
<div class="row">
  <div class="col-md mb-4">
    <div class="card">
      <div class="card-body">
        <p class="text-center text-muted mb-0">投稿がありません。</p>
      </div>
    </div>
  </div>
</div>
@endif
@foreach($articles as $article)
@include('articles.card')
@endforeach
