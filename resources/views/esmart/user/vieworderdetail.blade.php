@extends('templates.esmart.layout-cart')

@section('main-content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ route('esmart.index.index') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ route('esmart.user.profile') }}" title="">Tài khoản</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" title="">Đơn mua</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Chi tiết đơn hàng</h1>
                    @if (session('msg'))
                        <p class="text-success">
                            {{ session('msg') }}
                        </p>
                    @endif
                    @if (session('error'))
                        <p class="text-danger">
                            {{ session('error') }}
                        </p>
                    @endif
                </div>
                <div class="section-detail">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Thông tin</th>
                                    <th scope="col">Địa chỉ nhận hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="min-width: 130px">
                                        <span>{{ $infoOrderByOrderId->order_name }}</span>
                                        <br>
                                        <span>{{ $infoOrderByOrderId->order_email }}</span>
                                        <br>
                                        <span>{{ $infoOrderByOrderId->order_phone }}</span>
                                    </td>
                                    <td class="text-muted">
                                        {{ $infoOrderByOrderId->order_address }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Giá tiền</th>
                                    <th scope="col" style="width: 80px">Số lượng</th>
                                    <th scope="col">Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp
                                @foreach ($infoOrderByOrderId->orderDetails as $item)
                                    <tr class="text-center">
                                        <th scope="row">{{ $temp++ }}</th>
                                        <td>{{ $item->order_product_name }}</td>
                                        <td>{{ number_format($item->order_product_price, '0', ',', '.') }}đ</td>
                                        <td>{{ $item->order_product_qty }}</td>
                                        <td>{{ number_format($item->order_product_price * $item->order_product_qty, '0', ',', '.') }}đ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div>
                        <strong>Tổng thanh toán: </strong>
                        <span
                            class="text-danger">{{ number_format($infoOrderByOrderId->order_total, '0', ',', '.') }}VNĐ</span>
                    </div>
                    <div class="mb-3">
                        <strong>Hình thức thanh toán: </strong>
                        @if ($infoOrderByOrderId->order_payment == 1)
                            <span class="text-success">
                                Thanh toán online
                            </span>
                        @else
                            <span class="text-secondary">
                                Thanh toán khi nhận hàng
                            </span>
                        @endif
                    </div>
                    <div>
                        <strong>Trạng thái: </strong>
                        @if ($infoOrderByOrderId->order_status == 1)
                            <small class="bg-info text-light p-2 rounded">Đơn hàng mới</small>
                            <a style="cursor: pointer" data-id="{{ $infoOrderByOrderId->order_id }}"
                                class="cancel-order bg-danger text-light p-2 rounded">Hủy đơn
                                hàng</a>
                        @elseif($infoOrderByOrderId->order_status == 2)
                            <small class="bg-warning text-light p-2 rounded">Đang giao</small>
                            <a style="cursor: pointer" data-id="{{ $infoOrderByOrderId->order_id }}"
                                class="success-order bg-success text-light p-2 rounded">Đã nhận hàng</a>
                        @elseif($infoOrderByOrderId->order_status == 3)
                            <small class="bg-success text-light p-2 rounded">Đã giao</small>
                        @elseif($infoOrderByOrderId->order_status == 4)
                            <small class="bg-danger text-light p-2 rounded">Đã hủy</small>
                        @endif
                    </div>
                </div>
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Tài khoản của tôi</h1>
                </div>
                <div class="section-detail">
                    <table class="shop-table">
                        <tr>
                            <td>
                                <a href="{{ route('esmart.user.profile') }}" class="text-muted">Hồ sơ</a>
                            </td>
                            <td>
                                <a href="{{ route('esmart.user.address') }}" class="text-muted">Địa chỉ</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{ route('esmart.user.vieworder') }}" class="text-danger">Đơn mua</a>
                            </td>
                            <td>
                                <a href="{{ route('esmart.user.password') }}" class="text-muted">Đổi mật khẩu</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            //Cancel order
            $('.cancel-order').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hủy đơn hàng',
                    text: "Bạn có chắc muốn hủy đơn hàng này không?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var order_id = $(this).attr('data-id');
                        $.ajax({
                            url: "{{ route('esmart.user.cancelorder') }}",
                            type: "GET",
                            data: {
                                order_id: order_id
                            },
                            success: function(data) {
                                toastr.success(data);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 100);
                            }
                        });
                    }
                })
            });
            //Success order
            $('.success-order').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Đã nhận được hàng',
                    text: "Xác nhận đã nhận được hàng?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var order_id = $(this).attr('data-id');
                        $.ajax({
                            url: "{{ route('esmart.user.successorder') }}",
                            type: "GET",
                            data: {
                                order_id: order_id
                            },
                            success: function(data) {
                                toastr.success(data);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 100);
                            }
                        });
                    }
                })
            });
        });

    </script>
@endsection
