@extends('templates.esmart.layout-cart')

@section('main-content')
    <div id="main-content-wp" class="checkout-page">
        <div id="wrapper" class="wp-inner clearfix">
            <div class="text-center mb-3">
                <p class="text-dark" style="font-size: 23px; font-weight: bold">
                    Thanh toán đơn hàng
                </p>
            </div>
            <div class="card rounded-0 mb-3 mx-auto" style="max-width: 600px">
                <div class="card-header">
                    Thông tin vận chuyển
                </div>
                <div class="card-body">
                    <p>
                        <strong>Họ tên người nhận: </strong>
                        <span class="text-info">
                            {{ $infoShipping['name'] }}
                        </span>
                    </p>
                    <p>
                        <strong>Email: </strong>
                        <span class="text-muted">
                            {{ $infoShipping['email'] }}
                        </span>
                    </p>
                    <p>
                        <strong>Số điện thoại: </strong>
                        <span class="text-muted">
                            {{ $infoShipping['phone'] }}
                        </span>
                    </p>
                    <p>
                        <strong>Địa chỉ nhận hàng: </strong>
                        <span class="text-muted">
                            {{ $infoShipping['address'] }}
                        </span>
                    </p>
                    <p>
                        <strong>Hình thức thanh toán: </strong>
                        <span class="text-success">
                            Thanh toán Online
                        </span>
                    </p>
                    <p>
                        <strong>Tổng thanh toán: </strong>
                        <span class="text-danger font-weight-bold">
                            {{ number_format($infoShipping['total'], '0', ',', '.') }} VNĐ
                        </span>
                    </p>
                    <p>
                        <strong>Ghi chú: </strong>
                        <span class="text-muted">
                            {{ $infoShipping['note'] }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="card rounded-0 mb-3 mx-auto" style="max-width: 600px">
                <div class="card-header">
                    Chọn hình thức thanh toán
                </div>

                <div class="card-body">
                    <form action="{{ route('esmart.checkout.payment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_type" value="Thanh toán hóa đơn">
                        <input type="hidden" name="order_id" value="{{ date('YmdHis') }}">
                        <input type="hidden" name="amount" value="{{ $infoShipping['total'] }}">
                        <input type="hidden" name="order_desc" value="Thanh toán đơn hàng">
                        <input type="hidden" name="bank_code" value="">
                        <input type="hidden" name="language" value="vn">
                        <button type="submit" class="btn btn-block py-2 font-weight-bold border">
                            <span class="text-danger">VN</span><span class="text-info">PAY</span>
                        </button>
                    </form>
                    <br>
                    <div style="min-height: 92px">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>

            <div class="card mb-3 mx-auto" style="max-width: 250px">
                <a href="{{ route('esmart.index.index') }}" class="btn btn-outline-info">
                    Mua thêm sản phẩm khác
                </a>
            </div>
        </div>
    </div>

    {{-- Xử lý thanh toán đặt hàng --}}
    @php
    $totalUSA = round($infoShipping['total']/23135.13, 2);
    @endphp
    <script>
        //Thanh toán
        paypal.Buttons({
            style: {
                layout: 'horizontal',
                // color: 'blue',
                shape: 'rect',
                label: 'paypal'
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "{{ $totalUSA }}"
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    toastr.info('Đang tiến hành đặt hàng! Đợi tý nhé...');
                    toastr.success('Thanh toán thành công!');
                    addOrder();
                });
            }
        }).render('#paypal-button-container');
        //Đặt hàng
        function addOrder() {
            var name = "{{ $infoShipping['name'] }}";
            var email = "{{ $infoShipping['email'] }}";
            var phone = "{{ $infoShipping['phone'] }}";
            var address = "{{ $infoShipping['address'] }}";
            var note = "{{ $infoShipping['note'] }}";
            $.ajax({
                url: "{{ route('esmart.checkout.add-order') }}",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    address: address,
                    note: note
                },
                cache: false,
                success: function(data) {
                    var urlRedirect = "{{ route('esmart.checkout.notification') }}/" + data;
                    window.location.href = urlRedirect;
                }
            });
        }

    </script>
    {{-- /. Xử lý thanh toán đặt hàng --}}
@endsection
