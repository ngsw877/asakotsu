<div class="row">
  <div class="col-md mb-4">
    <div class="card article-card">
      <!-- このリンククリック範囲が親<div>全体まで広がる -->
      <a href="{{ route('articles.show', ['article' => $article]) }}" class="full-range-link"></a>

      <div class="card-body d-flex flex-row row">
        <div class="col-2 text-center">
          <a href="{{ route('users.show', ['name' => $article->user->name]) }}" class="in-link text-dark">
            <img class="user-icon rounded-circle" src="{{ $article->user->profile_image }}">
          </a>
        </div>
        <div class="col-7">
          <p class="mb-1">
            <a href="{{ route('users.show', ['name' => $article->user->name]) }}" class="font-weight-bold user-name-link text-dark mr-4">
              {{ $article->user->name }}
            </a>
            <span class="font-weight-lighter">{{ $article->created_at->format('Y/m/d H:i') }}</span>
          </p>
          <p class="text-primary m-0">
            <i class="fas fa-clock mr-2"></i>目標起床時間：{{ $article->user->wake_up_time->format('H:i') }}
          </p>
        </div>

        <div class="col-2 rounded peach-gradient d-flex align-items-center justify-content-center p-1">
            <div class="text-white text-center">
              <p class="small m-0">早起き</p>
              <p class="m-0">
                <span class="h5 mr-1">{{
                  $article->user->achievement_days()
                  ->where('date', '>=', \Carbon\Carbon::now()->startOfMonth()->toDateString())
                  ->where('date', '<=', \Carbon\Carbon::now()->endOfMonth()->toDateString())
                  ->count()
                }}</span>日目
              </p>
            </div>
        </div>

        @if( Auth::id() === $article->user_id )
          <!-- dropdown -->
          <div class="col-1 card-text">
            <div class="dropdown text-center">
              <a class="in-link p-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-lg"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('articles.edit', ['article' => $article]) }}">
                  <i class="fas fa-pen mr-1"></i>投稿を編集する
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $article->id }}">
                  <i class="fas fa-trash-alt mr-1"></i>投稿を削除する
                </a>
              </div>
            </div>
          </div>
          <!-- dropdown -->

          <!-- modal -->
          <div id="modal-delete-{{ $article->id }}" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form method="POST" action="{{ route('articles.destroy', ['article' => $article]) }}">
                  @csrf
                  @method('DELETE')
                  <div class="modal-body">
                    投稿を削除します。よろしいですか？
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
      @foreach($article->tags as $tag)
        @if($loop->first)
          <div class="card-body pt-0">
            <div class="card-text line-height px-3">
        @endif
          <a href="{{ route('tags.show', ['name' => $tag->name]) }}" class="border border-default text-default p-1 mr-1 mt-1 in-link">
            {{ $tag->hashtag }}
          </a>
        @if($loop->last)
            </div>
          </div>
        @endif
      @endforeach
      <div class="card-body pt-0">
        <div class="px-3">
          {!! nl2br(e( $article->body )) !!}
        </div>

      </div>
      <div class="card-footer py-1 d-flex justify-content-end bg-white">
        <!-- コメントアイコン -->
        <div class="mr-3 d-flex align-items-center">
            <a class="in-link p-1" href="{{ route('articles.show', ['article' => $article]) }}"><i class="far fa-comment fa-fw fa-lg"></i></a>
            <p class="mb-0">{{ count($article->comments) }}</p>
        </div>
        <!-- いいねアイコン -->
        <div class="d-flex align-items-center">
          <article-like
            :initial-is-liked-by='@json($article->isLikedBy(Auth::user()))'
            :initial-count-likes='@json($article->count_likes)'
            :authorized='@json(Auth::check())'
            endpoint="{{ route('articles.like', ['article' => $article]) }}"
            >
          </article-like>
        </div>
      </div>
    </div>
  </div>
</div>
