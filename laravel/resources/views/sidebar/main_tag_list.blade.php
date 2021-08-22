<div class="card mb-4 sidebar-content">
    <div class="card-header text-center"><i class="fas fa-tags mr-2"></i>メインタグ</div>
    <div class="card-body main-tag-list py-3 mx-auto">
        @foreach($mainTags as $mainTag)
            <a href="{{
            $mainTag
            ? route('tags.show', ['name' => $mainTag->name])
            : ''
        }}">
                <p>#{{ $mainTag->name }}</p>
            </a>
        @endforeach
    </div>
</div>
