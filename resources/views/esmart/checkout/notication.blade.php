@extends('templates.esmart.layout-cart')

@section('main-content')
    <div id="main-content-wp" class="checkout-page">
        <div id="wrapper" class="wp-inner clearfix">
            <div class="text-center mb-3">
                <p class="mx-auto mb-3" style="width:64px">
                    <img src="templates/esmart/images/check-mark-64.png" alt="">
                </p>
                <p class="text-dark" style="font-size: 23px; font-weight: bold">
                    Cảm ơn quý khách đã mua hàng tại E-SMART
                </p>
                <p>Chúng tôi sẽ liên hệ với quý khách trong vòng <strong>12 giờ</strong> làm việc tới để xác nhận đơn hàng.
                </p>
                <p>Hệ thống đã gửi một tin nhắn chi tiết về đơn hàng vào mail của quý khách. Vui lòng kiểm tra email để xem
                    lại thông tin đơn hàng.</p>
                <p class="text-muted">Rất hân hạnh được phục vụ!</p>
            </div>
            <div class="card rounded-0 mb-3 mx-auto" style="max-width: 600px">
                <div class="card-header">
                    Thông tin vận chuyển
                </div>
                <div class="card-body">
                    <p>
                        <strong>Mã đơn hàng: </strong>
                        <span class="text-info">
                            #{{ $infoOrder->order_code }}
                        </span>
                    </p>
                    <p>
                        <strong>Hình thức thanh toán: </strong>
                        <span class="text-success">
                            @if ($infoOrder->order_payment == 1)
                                Thanh toán online
                            @else
                                Thanh toán khi nhận hàng
                            @endif
                        </span>
                    </p>
                    <p>
                        <strong>Họ tên người nhận: </strong>
                        <span class="text-muted">
                            {{ $infoOrder->order_name }}
                        </span>
                    </p>
                    <p>
                        <strong>Số điện thoại: </strong>
                        <span class="text-muted">
                            {{ $infoOrder->order_phone }}
                        </span>
                    </p>
                    <p>
                        <strong>Địa chỉ nhận hàng: </strong>
                        <span class="text-muted">
                            {{ $infoOrder->order_address }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="card rounded-0 mb-3 mx-auto" style="max-width: 600px">
                <div class="card-header">
                    Sản phẩm đã đặt
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            @foreach ($infoOrder->orderDetails as $item)
                                <tr>
                                    <td>
                                        @php
                                        $picture = $item->product->product_image;
                                        @endphp
                                        <img src="uploads/product/{{ $picture }}" alt="" style="width:80px">
                                    </td>
                                    <td>
                                        <p>{{ $item->order_product_name }}</p>
                                        <p>Giá mua: {{ number_format($item->order_product_price, '0', ',', '.') }}đ</p>
                                        <p>Số lượng: {{ $item->order_product_qty }}</p>
                                    </td>
                                    <td>
                                        {{ number_format($item->order_product_price * $item->order_product_qty, '0', ',', '.') }}đ
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <span>Tổng thanh toán</span>
                                    <strong
                                        class="text-danger">{{ number_format($infoOrder->order_total, '0', ',', '.') }}đ</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-3 mx-auto" style="max-width: 250px">
                <a href="{{ route('esmart.index.index') }}" class="btn btn-outline-info">
                    Mua thêm sản phẩm khác
                </a>
            </div>
        </div>
    </div>
@endsection
