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
                    <h1 class="section-title">Lịch sử mua hàng</h1>
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
                                <tr class="text-center">
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã đơn hàng</th>
                                    <th scope="col">Ngày mua</th>
                                    <th scope="col">Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp
                                @foreach ($infoOrder as $item)
                                    <tr class="text-center">
                                        <th scope="row">{{ $temp++ }}</th>
                                        <td>#{{ $item->order_code }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if ($item->order_status == 1)
                                                <span class="text-info">Đơn hàng mới</span>
                                            @elseif($item->order_status == 2)
                                                <span class="text-warning">Đang giao</span>
                                            @elseif($item->order_status == 3)
                                                <span class="text-success">Hoàn thành</span>
                                            @elseif($item->order_status == 4)
                                                <span class="text-danger">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('esmart.user.vieworderdetail', $item->order_id) }}"
                                                class="text-link">
                                                Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="section" id="paging-wp">
                        <div class="section-detail">
                            {{ $infoOrder->links('vendor.pagination.pagination-public') }}
                        </div>
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

@endsection
