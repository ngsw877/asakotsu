<div class="card mt-4">
  <div class="card-header d-flex flex-row align-items-center">
    <a href="{{ route('users.show', ['name' => $meeting->user->name]) }}" class="text-dark m">
      <i class="fas fa-user-circle fa-3x mr-3"></i>
    </a>
    <a href="{{ route('users.show', ['name' => $meeting->user->name]) }}" class="text-dark">
      <strong>{{ $meeting->user->name }}</strong> &nbsp;さんのミーティング
    </a>

     @if( Auth::id() === $meeting->user_id )
      <!-- dropdown -->
      <div class="ml-auto card-text">
        <div class="dropdown">
          <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="">
              <i class="fas fa-pen mr-1"></i>ミーティングを更新する
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $meeting->id }}">
              <i class="fas fa-trash-alt mr-1"></i>ミーティングを削除する
            </a>
          </div>
        </div>
      </div>
      <!-- dropdown -->

      <!-- modal -->
      <div id="modal-delete-{{ $meeting->id }}" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="">
              @csrf
              @method('DELETE')
              <div class="modal-body">
                {{ $meeting->topic }}を削除します。よろしいですか？
              </div>
              <div class="modal-footer justify-content-between">
                <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                <button type="submit" class="btn btn-danger">削除する</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- modal -->
    @endif
  </div>
  <div class="card-body pt-0">
    <table class="table">
      <tbody class="container">
        <tr class="row">
          <th scope="row" class="col-3">ミーティング名</th>
          <td class="col-9"> {{ $meeting->topic }}</th>
        </tr>
        <tr class="row">
          <th scope="row" class="col-3" scope="">テーマ</th>
          <td class="col-9">{{ $meeting->agenda }}</td>
        </tr>
        <tr class="row">
          <th scope="row" class="col-3" scope="">開始日時</th>
          <td class="col-9">{{ $meeting->start_time }}&nbsp;〜</td>
        </tr>
        @if( Auth::id() === $meeting->user_id )
          <tr class="row">
            <th scope="row" class="col-3" scope="">
              開始URL
            </th>
            <td class="col-9 ">
                <a class="text-primary" href="{{ $meeting->start_url }}">
                  {{ substr($meeting->start_url, 0, 75) }} ...
                </a>
                <br>
                <small>（※ミーティングのホストにだけ見えています）</small>
            </td>
          </tr>
        @endif
        <tr class="row">
          <th scope="row" class="col-3" scope="">参加URL</th>
          <td class="col-9">
            <a class="text-primary" href="{{ $meeting->join_url }}">
              {{ $meeting->join_url }}
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
