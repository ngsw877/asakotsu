@csrf
<div class="form-group">
  <label for="topic">
    ミーティング名
    <small class="text-danger">（必須）</small>
  </label>
  <input class="form-control" type="text" id="topic" name="topic" value="{{ $meeting->topic ?? old('topic') }}">
</div>
<div class="form-group">
  <label for="agenda">
    テーマ
    <small class="blue-grey-text">（任意）</small>
  </label>
  <input class="form-control" type="text" id="agenda" name="agenda" value="{{ $meeting->agenda ?? old('agenda') }}">
</div>
<div class="form-group w-50">
  <label for="start_time">
    開始日時
    <small class="text-danger">（必須）</small>
  </label>
  <input class="form-control" type="datetime-local" id="start_time" name="start_time" value="{{ $meeting->start_time ?? old('start_time') }}">
</div>
