@extends('templates.admin.master')

@section('main-content')

    <div class="row" id="proBanner">
        <div class="col-12">
            @if (session('msg'))
                <span class="d-flex align-items-center purchase-popup">
                    <div class="text-danger">
                        {{ session('msg') }}
                    </div>
                </span>
            @endif
            @if (session('error'))
                <span class="d-flex align-items-center purchase-popup">
                    <div class="text-danger">
                        {{ session('error') }}
                    </div>
                </span>
            @endif
        </div>
    </div>
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>
            </span> Tổng quan
        </h3>
    </div>
    <div class="row">
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="templates/admin/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Thành công<i class="mdi mdi-chart-line mdi-24px float-right"></i>
                    </h4>
                    <h5>{{ $orderSuccess }}</h5>
                    <small class="card-text">Đơn hàng thành công</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="templates/admin/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Đơn hàng mới<i
                            class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                    </h4>
                    <h5>{{ $orderNew }}</h5>
                    <small class="card-text">Đơn hàng mới</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-warning card-img-holder text-white">
                <div class="card-body">
                    <img src="templates/admin/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Doanh thu<i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h5>{{ number_format($totalOrderSuccess, '0', '.', '.') }} VNĐ</h5>
                    <small class="card-text">Tổng doanh thu</small>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="templates/admin/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Đơn đã hủy<i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h5>{{ $orderCancel }}</h5>
                    <small class="card-text">Đơn hàng đã hủy</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Đơn hàng mới
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Đơn hàng</th>
                                    <th>Thông tin khách hàng</th>
                                    <th>Tổng quan đơn hàng</th>
                                    <th>Trang thái</th>
                                    <th>Hình thức thanh toán</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listOrder as $item)
                                    <tr>
                                        <td>#{{ $item->order_code }}</td>
                                        <td>
                                            <div class="mb-1">
                                                {{ $item->order_email }}
                                            </div>
                                            <small style="font-family: roboto">
                                                Người nhận: <span class="text-muted">{{ $item->order_name }}</span>
                                            </small>
                                            <br>
                                            <small style="font-family: roboto">
                                                Thời gian: <span class="text-muted">
                                                    @php
                                                    $time = $item->created_at;
                                                    @endphp
                                                    {{ $time->diffForHumans($now) }}
                                                </span>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                Tổng tiền: <span
                                                    class="text-danger">{{ number_format($item->order_total, '0', ',', '.') }}đ</span>
                                            </div>
                                            <small style="font-family: roboto">
                                                Số lượng: <span class="text-muted">{{ $item->order_qty }}</span>
                                            </small>

                                        </td>
                                        <td>
                                            <span class="text-light">
                                                @if ($item->order_status == 1)
                                                    <span class="bg-info p-1 rounded">
                                                        Đơn hàng mới
                                                    </span>
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            @if ($item->order_payment == 1)
                                                <span class="text-success">Thanh toán online</span>
                                            @else
                                                <span class="text-secondary">Khi nhận hàng</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.order.detail-order', $item->order_id) }}"
                                                class="badge badge-gradient-info">
                                                <i class="mdi mdi-table-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block text-center mt-3">
                        <div class="d-inline-block">
                            {{ $listOrder->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
