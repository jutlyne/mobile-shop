@extends('templates.esmart.layout-cart')

@section('main-content')
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ route('esmart.cart.show-cart') }}">Giỏ hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix" style="min-height: 200px">
            @if (Session::get('cart') == true)
                @php
                $infoCart = Session::get('cart');
                @endphp
                <div class="section" id="info-cart-wp">
                    <div class="section-detail table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>STT</td>
                                    <td>Ảnh sản phẩm</td>
                                    <td>Tên sản phẩm</td>
                                    <td>Giá sản phẩm</td>
                                    <td>Số lượng</td>
                                    <td colspan="2">Thành tiền</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i = 1;
                                @endphp
                                @foreach ($infoCart['buy'] as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>
                                            <a href="" title="" class="thumb">
                                                <img src="uploads/product/{{ $item['infoProduct']['product_image'] }}"
                                                    alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" title=""
                                                class="name-product">{{ $item['infoProduct']['product_name'] }}</a>
                                        </td>
                                        <td>{{ number_format($item['infoProduct']['product_price'], '0', ',', '.') }}đ</td>
                                        <td>
                                            <input type="number" min="1" max="{{ $item['infoProduct']['product_qty'] }}"
                                                name="num-order" value="{{ $item['qty'] }}" class="num-order"
                                                data-id="{{ $item['infoProduct']['product_id'] }}">
                                        </td>
                                        <td id="cart-sub-total-{{ $item['infoProduct']['product_id'] }}">
                                            {{ number_format($item['infoProduct']['product_price'] * $item['qty'], '0', ',', '.') }}đ
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" data-id="{{ $item['infoProduct']['product_id'] }}"
                                                title="" class="del-product"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <p id="total-price" class="fl-right">Tổng giá:
                                                <span id="cart-total-price">
                                                    {{ number_format($infoCart['totalPrice'], '0', ',', '.') }} vnđ
                                                </span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <div class="fl-right">
                                                <a href="{{ route('esmart.checkout.checkout') }}" id="checkout-cart">
                                                    Thanh toán
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="section" id="action-cart-wp">
                    <div class="section-detail">
                        <p class="title">Click vào <span>ô số lượng</span> để cập nhật số lượng. Click vào biểu tượng
                            <span>thùng rác</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.
                        </p>
                        <a href="{{ route('esmart.index.index') }}" title="" id="buy-more">Mua tiếp</a><br />
                        <a href="{{ route('esmart.cart.del-cart') }}" title="" id="delete-cart">Xóa giỏ hàng</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        $(document).on('change', '.num-order', function() {
            var product_id = $(this).attr('data-id');
            var quantity = $(this).val();

            $.ajax({
                url: "{{ route('esmart.cart.edit') }}",
                type: 'GET',
                data: {
                    product_id: product_id,
                    quantity: quantity
                },
                success: function(data) {
                    $('#cart-sub-total-' + product_id).text(data.subTotal);
                    $('#cart-total-price').text(data.totalPrice);
                    showCart();
                }
            });
        });

        $(document).on('click', '.del-product', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Xác nhận!',
                text: "Xóa sản phẩm khỏi giỏ hàng!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    var product_id = $(this).attr('data-id');
                    $.ajax({
                        url: "{{ route('esmart.cart.del-item-cart') }}",
                        type: "GET",
                        data: {
                            product_id: product_id
                        },
                        success: function(data) {
                            window.location.reload();
                        }
                    });
                }
            })
        });

    </script>
@endsection
