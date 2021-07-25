<ul class="list-group list-group-flush">
    @foreach ($productSearch as $item)
        <li class="list-group-item">
            <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}" class="clear-fix">
                <img class="float-left" src="uploads/product/{{ $item->product_image }}" style="width:50px" alt="">
                <span class="float-left text-dark font-weight-bold p-2">
                    <span>{{ $item->product_name }}</span>
                    <br>
                    <span class="text-danger">
                        {{ number_format($item->product_price - ($item->product_price * $item->product_sale) / 100, 0, ',', '.') }}đ
                    </span>
                </span>
            </a>
        </li>
    @endforeach
</ul>
