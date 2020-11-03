@csrf
<div class="form-group mt-4">
  <article-tags-input
  :initial-tags='@json($tagNames ?? [])'
  :autocomplete-items='@json($allTagNames ?? [])'
  >
  </article-tags-input>
</div>
<div class="form-group">
  <label></label>
  <textarea name="body" class="form-control" rows="8" placeholder="本文">{{ $article->body ?? old('body') }}</textarea>
</div>
