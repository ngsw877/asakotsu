<div class="card mb-4 sidebar-content">
    <div class="card-header text-center"><i class="fas fa-tags mr-2"></i>メインタグ</div>
    <div class="card-body main-tag-list py-3 mx-auto">
        <a href="{{
            \App\Models\Tag::where('name', '行動宣言')->first()
            ? route('tags.show', ['name' => '行動宣言'])
            : ''
        }}">
            <p>#行動宣言</p>
        </a>
        <a href="{{
            \App\Models\Tag::where('name', '朝コツ')->first()
            ? route('tags.show', ['name' => '朝コツ'])
            : ''
        }}">
            <p>#朝コツ</p>
        </a>
        <a href="{{
            \App\Models\Tag::where('name', '今朝の積み上げ')->first()
            ? route('tags.show', ['name' => '今朝の積み上げ'])
            : ''
        }}">
            <p>#今朝の積み上げ</p>
        </a>
        <a href="{{
            \App\Models\Tag::where('name', '反省・気付き')->first()
            ? route('tags.show', ['name' => '反省・気付き'])
            : ''
        }}">
            <p>#反省・気付き</p>
        </a>
        <a href="{{
            \App\Models\Tag::where('name', '質問')->first()
            ? route('tags.show', ['name' => '質問'])
            : ''
        }}">
            <p>#質問</p>
        </a>
    </div>
</div>
