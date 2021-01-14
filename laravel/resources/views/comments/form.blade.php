<li class="list-group-item card">
    <div class="py-3">
        <form method="POST" action="{{ route('comments.store') }}">
            @csrf

            <div class="form-group row mb-0">
                <div class="col-md-12 p-3 w-100 d-flex">
                    <a href="{{ route('users.show', ['name' => Auth::user()->name]) }}" class="in-link text-dark">
                        <img class="user-icon rounded-circle" src="{{ Auth::user()->profile_image }}" alt="プロフィールアイコン">
                    </a>
                    <div class="ml-2 d-flex flex-column font-weight-bold">
                        <a href="{{ route('users.show', ['name' => Auth::user()->name]) }}" class="in-link text-dark">
                            <p class="mb-0">{{ Auth::user()->name }}</p>
                        </a>
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <textarea class="form-control @error('comment') is-invalid @enderror" name="comment"  rows="4">
                    @error('comment')
                        {{ old('comment') }}
                    @enderror
                    </textarea>
                    @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12 text-right">
                    <p class="mb-4 text-danger">250文字以内</p>
                    <button type="submit" class="btn peach-gradient">
                        コメントする
                    </button>
                </div>
            </div>
        </form>
    </div>
</li>
