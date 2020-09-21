<div class="card mt-3">
  <div class="card-header">
    <a href="{{ route('users.show', ['name' => $meeting->user->name]) }}" class="text-dark">
      <i class="fas fa-user-circle fa-3x mr-1"></i>
    </a>
    <a href="{{ route('users.show', ['name' => $meeting->user->name]) }}" class="text-dark">
        {{ $meeting->user->name }}
    </a>
  </div>
  <div class="card-body d-flex flex-row">
      <div class="font-weight-lighter">
        {{ $meeting->start_time }}
      </div>

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
    <h3 class="h4 card-title">
      <a class="text-dark" href="">
        {{ $meeting->topic }}
      </a>
    </h3>
    <div class="card-text">
    {{ $meeting->agenda }}
    </div>
    @if( Auth::id() === $meeting->user_id )
    <div class="card-text">
      <a href="{{ $meeting->start_url }}">
        {{ $meeting->start_url }}
      </a>
    </div>
    @endif
    <div class="card-text">
      <a href="{{ $meeting->join_url }}">
        {{ $meeting->join_url }}
      </a>
    </div>
  </div>
</div>
