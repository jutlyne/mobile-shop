<div class="section" id="category-product-wp">
    <div class="section-head">
        <h3 class="section-title">Danh mục sản phẩm</h3>
    </div>
    <div class="secion-detail">
        <ul class="list-item">
            @foreach ($menuCatProduct as $item)
                @if ($item->cat_product_parent == 0)
                    <li>
                        <a href="{{ route('esmart.product.cat', [$item->cat_product_slug, $item->cat_product_id]) }}">
                            {{ $item->cat_product_name }}
                        </a>
                        {{ showCategories($menuCatProduct, $item->cat_product_id) }}
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
