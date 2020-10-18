@csrf
<div class="form-group h5">
  <label for="topic">ミーティング名</label>
  <input class="form-control" type="text" id="topic" name="topic" value="{{ $meeting->topic ?? old('topic') }}">
</div>
<div class="form-group h5">
  <label for="agenda">テーマ</label>
  <input class="form-control" type="text" id="agenda" name="agenda" value="{{ $meeting->agenda ?? old('agenda') }}">
</div>
<div class="row">
  <div class="form-group h5 col-xs-2 mx-auto">
    <label for="start_time">開始日時</label>
    <input class="form-control" type="datetime-local" id="start_time" name="start_time" value="{{ $meeting->start_time ?? old('start_time') }}">
  </div>
</div>
