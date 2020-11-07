<!-- 無限スクロールのsppiner -->
@if ($articles->nextPageUrl())
  <a href="{{ $articles->nextPageUrl() }}" infinity-scroll>
    <div class="d-flex justify-content-center my-4">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </a>
@endif
