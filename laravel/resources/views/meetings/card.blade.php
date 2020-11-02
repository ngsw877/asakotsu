<div class="card mb-4">
  <div class="card-header d-flex flex-row align-items-center blue-gradient text-white">
    <a href="{{ route('users.show', ['name' => $meeting->user->name]) }}" class="text-dark m">
      <img class="user-icon rounded-circle mr-3" src="{{ $meeting->user->profile_image }}">
    </a>
    <a href="{{ route('users.show', ['name' => $meeting->user->name]) }}" class="text-white">
      <strong>{{ $meeting->user->name }}</strong> &nbsp;さんのミーティング
      <i class="fas fa-video ml-2"></i>
    </a>

     @if( Auth::id() === $meeting->user_id )
      <!-- dropdown -->
      <div class="ml-auto card-text">
        <div class="dropdown">
          <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-v fa-lg"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('meetings.edit', ['meeting' => $meeting]) }}">
              <i class="fas fa-pen mr-1"></i>ミーティングを編集する
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
            <form method="POST" action="{{ route('meetings.destroy', ['meeting' => $meeting]) }}">
              @csrf
              @method('DELETE')
              <div class="modal-body text-center text-dark">
                {{ $meeting->topic }} を削除します。よろしいですか？
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
  <div class="card-body">
    <table class="table table w-75 mx-auto">
      <tbody class="container">
        <tr class="row">
          <th scope="row" class="col-4 border-top-0 font-weight-bold">ミーティング名</th>
          <td class="col-8 border-top-0"> {{ $meeting->topic }}</th>
        </tr>
        @isset($meeting->agenda)
        <tr class="row">
          <th scope="row" class="col-4 font-weight-bold">テーマ</th>
          <td class="col-8">{{ $meeting->agenda }}</td>
        </tr>
        @endisset
        <tr class="row">
          <th scope="row" class="col-4 font-weight-bold">開始日時</th>
          <td class="col-8">
            <i class="fas fa-clock mr-2 text-primary"></i>
            {{ date('Y/m/d　H時i分', strtotime($meeting->start_time)) }}&nbsp;〜
          </td>
        </tr>
        @if( Auth::id() === $meeting->user_id )
          <tr class="row">
            <th scope="row" class="col-4 font-weight-bold">
              開始URL
            </th>
            <td class="col-8 ">
                <a class="text-primary" href="{{ $meeting->start_url }}">
                  {{ substr($meeting->start_url, 0, 75) }} ...
                </a>
                <br>
                <small>（※ミーティングのホストにだけ見えています）</small>
            </td>
          </tr>
        @endif
        <tr class="row">
          <th scope="row" class="col-4 font-weight-bold">参加URL</th>
          <td class="col-8">
            <a class="text-primary" href="{{ $meeting->join_url }}">
              {{ $meeting->join_url }}
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
