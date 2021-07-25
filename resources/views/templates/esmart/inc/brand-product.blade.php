<div class="section" id="category-product-wp">
    <div class="section-head">
        <h3 class="section-title">Thương hiệu</h3>
    </div>
    <div class="secion-detail">
        <ul class="list-item">
            @foreach ($menuBrandProduct as $item)
                <li>
                    <a href="{{ route('esmart.product.brand', [$item->brand_slug, $item->brand_id]) }}">
                        {{ $item->brand_name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
