@extends('templates.esmart.layout-cart')

@section('main-content')

    <div id="main-content-wp" class="checkout-page">
        <form action="{{ route('esmart.checkout.checkout') }}" method="POST">
            @csrf
            <div class="section" id="breadcrumb-wp">
                <div class="wp-inner">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <a href="?page=home" title="">Trang chủ</a>
                            </li>
                            <li>
                                <a href="" title="">Thanh toán</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="wrapper" class="wp-inner clearfix">
                <div class="section" id="customer-info-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin gửi hàng</h1>

                    </div>
                    @if (Auth::check())
                        @if (isset($infoAddress))
                            <div class="section-detail">
                                <div class="form-row clearfix">
                                    <div class="form-col fl-left">
                                        <label for="name">Họ tên</label>
                                        <input type="text" name="name" value="{{ $infoAddress->name }}" id="fullname"
                                            readonly>
                                    </div>
                                    <div class="form-col fl-right">
                                        <label for="email">Email</label>
                                        <input type="email" value="{{ Auth::user()->email }}" name="email" readonly>
                                    </div>
                                </div>
                                <div class="form-row clearfix">
                                    <div class="form-col fl-left">
                                        <label for="address">Địa chỉ</label>
                                        <input type="text" value="{{ $addressDetail }}" name="address" id="address"
                                            readonly>
                                    </div>
                                    <div class="form-col fl-right">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="tel" value="{{ $infoAddress->phone }}" name="phone" id="phone"
                                            readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col">
                                        <label for="notes">Ghi chú</label>
                                        <textarea name="note" placeholder="Nhập ghi chú đơn hàng nếu có"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <a href="{{ route('esmart.user.address') }}" class="btn btn-link">Thay đổi địa chỉ</a>
                                </div>
                            </div>
                        @else
                            <div class="form-row">
                                <div class="alert alert-dark" role="alert">
                                    Bạn chưa có thông tin địa chỉ nhận hàng
                                </div>
                            </div>
                            <div class="form-row">
                                <a href="{{ route('esmart.user.address') }}" class="btn btn-link">Thêm địa chỉ nhận hàng</a>
                            </div>
                        @endif
                    @else
                        <div class="section-detail">
                            <p class="mb-2 text-muted">
                                Nhập thông tin địa chỉ nhận hàng hoặc <a href="{{ route('auth.auth.login') }}">đăng nhập</a>
                                để
                                mua hàng nếu bạn đã có tài
                                khoản
                            </p>
                            <div>
                                <div class="form-row clearfix">
                                    <div class="form-col fl-left">
                                        <label for="name">Họ tên</label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-col fl-right">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" value="{{ old('email') }}">
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row clearfix">
                                    <div class="form-col fl-left">
                                        <label for="address">Địa chỉ</label>
                                        <input type="text" name="address" id="address" value="{{ old('address') }}">
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-col fl-right">
                                        <label for="phone">Số điện thoại</label>
                                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-col">
                                        <label for="notes">Ghi chú</label>
                                        <textarea name="note">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="section" id="order-review-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin đơn hàng</h1>
                    </div>
                    <div class="section-detail">
                        <table class="shop-table">
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Tổng</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (Session::get('cart'))
                                    @php
                                    $cart = Session::get('cart');
                                    @endphp
                                    @foreach ($cart['buy'] as $itemCart)
                                        <tr class="cart-item">
                                            <td class="product-name">
                                                {{ $itemCart['infoProduct']['product_name'] }}
                                                <strong class="product-quantity">x {{ $itemCart['qty'] }}</strong>
                                            </td>
                                            <td class="product-total">
                                                {{ number_format($itemCart['infoProduct']['product_price'] * $itemCart['qty'], '0', ',', '.') }}đ
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td>Tổng đơn hàng:</td>
                                    <td>
                                        <strong class="total-price">
                                            {{ number_format($cart['totalPrice'], '0', ',', '.') }}đ
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="payment-checkout-wp">
                            <ul id="payment_methods">
                                <li>
                                    <input type="radio" value="1" id="direct-payment" name="payment"
                                        {{ old('payment') == 1 ? 'checked' : '' }}>
                                    <label for="direct-payment">Thanh toán Online</label>
                                </li>

                                <li>
                                    <input type="radio" value="2" id="payment-home" name="payment"
                                        {{ old('payment') == 2 ? 'checked' : '' }}>
                                    <label for="payment-home">Thanh toán khi nhận hàng</label>
                                </li>
                            </ul>
                            @error('payment')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="place-order-wp clearfix">
                            @if (Auth::check())
                                @if (isset($infoAddress))
                                    <input type="submit" id="order-now" value="Đặt hàng">
                                @else
                                    <input type="submit" id="order-now" value="Đặt hàng" disabled>
                                @endif
                            @else
                                <input type="submit" id="order-now" value="Đặt hàng">
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $("#order-now").click(function() {
                toastr.info('Đang tiến hành đặt hàng! Đơi tý nhé...');
            });
        });

    </script>
@endsection
