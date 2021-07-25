@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> CHI TIẾT ĐƠN HÀNG </h3>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <h4 class="card-header">Thông tin vận chuyển</h4>
                <div class="card-body">

                    <h5 class="card-title">Họ tên người nhận</h5>
                    <p class="card-text">{{ $order->order_name }}</p>

                    <h5 class="card-title">Email</h5>
                    <p class="card-text">{{ $order->order_email }}</p>

                    <h5 class="card-title">Điện thoại</h5>
                    <p class="card-text">{{ $order->order_phone }}</p>

                    <h5 class="card-title">Địa chỉ nhận hàng</h5>
                    <p class="card-text">{{ $order->order_address }}</p>

                    @if ($order->order_status == 1 || $order->order_status == 2)
                        <form class="form-inline" method="POST">
                            @csrf
                            <select name="order_status" class="form-control m-2">
                                <option {{ $order->order_status == 1 ? 'selected' : '' }} value="1">Đơn hàng mới</option>
                                <option {{ $order->order_status == 2 ? 'selected' : '' }} value="2">Đang giao</option>
                                <option {{ $order->order_status == 3 ? 'selected' : '' }} value="3">Hoàn thành</option>
                                <option {{ $order->order_status == 4 ? 'selected' : '' }} value="4">Hủy đơn hàng</option>
                            </select>
                            <button type="submit" class="btn btn-danger ml-2">Thay đổi</button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <h4 class="card-header">Tổng quan đơn hàng</h4>
                <div class="card-body">

                    <h5 class="card-title">Số lượng sản phẩm</h5>
                    <p class="card-text">{{ $order->order_qty }} sản phẩm</p>

                    <h5 class="card-title">Tổng hóa đơn</h5>
                    <p class="card-text">{{ number_format($order->order_total, '0', ',', '.') }} VNĐ</p>

                    <h5 class="card-title">Hình thức thanh toán</h5>

                    @if ($order->order_payment == 1)
                        <p class="card-text text-success">Thanh toán online</p>
                    @else
                        <p class="card-text text-danger">Thanh toán khi nhận hàng</p>
                    @endif

                    <h5 class="card-title">Ngày đặt</h5>
                    <p class="card-text">{{ $order->created_at }}</p>

                    <h5 class="card-title">Ghi chú đơn hàng</h5>
                    <p class="card-text">{{ $order->order_note }}</p>

                    @if ($order->order_status == 1)
                        <div class="alert alert-info" role="alert">
                            Đơn hàng mới
                        </div>
                    @elseif($order->order_status == 2)
                        <div class="alert alert-warning" role="alert">
                            Đang giao
                        </div>
                    @elseif($order->order_status == 3)
                        <div class="alert alert-success" role="alert">
                            Đã hoàn thành
                        </div>
                    @elseif($order->order_status == 4)
                        <div class="alert alert-danger" role="alert">
                            Đã hủy
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Chi tiết đơn hàng</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá tiền</th>
                                    <th class="text-center">Số lượng</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp
                                @foreach ($order->orderDetails as $item)
                                    <tr>
                                        <td>{{ $temp++ }}</td>
                                        <td>{{ $item->order_product_name }}</td>
                                        <td>{{ number_format($item->order_product_price, '0', ',', '.') }}đ</td>
                                        <td class="text-center">{{ $item->order_product_qty }}</td>
                                        <td>{{ number_format($item->order_product_qty * $item->order_product_price, '0', ',', '.') }}đ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
