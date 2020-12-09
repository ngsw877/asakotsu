@if($meetings->isEmpty())
<div class="row">
  <div class="col-md mb-4">
    <div class="card">
      <div class="card-body">
        <p class="text-center text-muted mb-0">ミーティングがありません。</p>
      </div>
    </div>
  </div>
</div>
@endif

@foreach($meetings as $meeting)

@include('meetings.card')

@endforeach
