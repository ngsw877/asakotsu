@if($meetings->isEmpty())
  @include('not_exist', ['message' => 'ミーティングがありません。'])
@endif

@foreach($meetings as $meeting)
  @include('meetings.card')
@endforeach
