<div class="section" id="selling-wp">
    <div class="section-head">
        <h3 class="section-title">Lượt xem nhiều</h3>
    </div>
    <div class="section-detail">
        <ul class="list-item">
            @foreach ($postTopViews as $item)
                <li class="clearfix">
                    <a href="{{ route('esmart.post.detail', [$item->post_slug, $item->post_id]) }}" title=""
                        class="thumb fl-left">
                        <img src="uploads/post/{{ $item->post_image }}" alt="">
                    </a>
                    <div class="info fl-right">
                        <a href="{{ route('esmart.post.detail', [$item->post_slug, $item->post_id]) }}"
                            title="{{ $item->post_name }}" class="product-name">{{ $item->post_name }}</a>
                        <div class="price">
                            <span class="text-muted">{{ $item->created_at }}</span>
                            <br>
                            <span class="text-muted">Lượt xem: {{ $item->post_views }}</span>
                        </div>
                    </div>
                </li>
            @endforeach

        </ul>
    </div>
</div>
