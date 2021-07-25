<div class="section" id="category-product-wp">
    <div class="section-head">
        <h3 class="section-title">Tin tức</h3>
    </div>
    <div class="secion-detail">
        <ul class="list-item">
            @foreach ($menuCatPost as $item)
                <li>
                    <a href="{{ route('esmart.post.cat', [$item->cat_post_slug, $item->cat_post_id]) }}">
                        {{ $item->cat_post_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
