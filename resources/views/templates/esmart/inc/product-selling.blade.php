<div class="section" id="selling-wp">
    <div class="section-head">
        <h3 class="section-title">Sản phẩm bán chạy</h3>
    </div>
    <div class="section-detail">
        <ul class="list-item">
            @foreach ($productSelling as $item)
                <li class="clearfix">
                    <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}" title=""
                        class="thumb fl-left">
                        <img src="uploads/product/{{ $item->product_image }}" alt="">
                    </a>
                    <div class="info fl-right">
                        <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                            title="{{ $item->product_name }}" class="product-name">{{ $item->product_name }}</a>
                        <div class="price">
                            <span class="new">
                                {{ number_format($item->product_price - ($item->product_price * $item->product_sale) / 100, 0, ',', '.') }}đ
                            </span>
                            <span class="text-success">
                                -{{ $item->product_sale }} %
                            </span>
                            <br>
                            <span class="old">
                                {{ number_format($item->product_price, 0, ',', '.') }}đ
                            </span>
                            <span class="text-muted ml-1">
                                Đã bán: {{ $item->product_sold }}
                            </span>
                        </div>
                        <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                            title="" class="buy-now">Mua ngay</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
