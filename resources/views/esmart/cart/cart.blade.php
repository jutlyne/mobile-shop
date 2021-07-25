<div id="btn-cart">
    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
    <span id="num">
        {{ Session::get('cart') == true ? Session::get('cart')['totalQty'] : '' }}
    </span>
</div>
@if (Session::get('cart') == true)
    @php
      $infoCart = Session::get('cart');
    @endphp
    <div id="dropdown">
        <p class="desc">
            Có <span>{{ $infoCart['totalQty'] }} sản phẩm</span> trong giỏ hàng
        </p>
        <ul class="list-cart">
            @foreach ($infoCart['buy'] as $item)
                <li class="clearfix">
                    <a href="" title="" class="thumb fl-left">
                        <img src="uploads/product/{{ $item['infoProduct']['product_image'] }}" alt="">
                    </a>
                    <div class="info fl-right">
                        <a href="" title="" class="product-name">{{ $item['infoProduct']['product_name'] }}</a>
                        <p class="price">
                            {{ number_format($item['infoProduct']['product_price'], '0', ',', '.') }}đ
                        </p>
                        <p class="qty">Số lượng: <span>{{ $item['qty'] }}</span></p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="total-price clearfix">
            <p class="title fl-left">Tổng:</p>
            <p class="price fl-right">
                {{ number_format($infoCart['totalPrice'], '0', ',', '.') }}đ
            </p>
        </div>
        <div class="action-cart clearfix">
            <a href="{{ route('esmart.cart.show-cart') }}" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
            <a href="?page=checkout" title="Thanh toán" class="checkout fl-right">Thanh
                toán</a>
        </div>
    </div>
@endif
