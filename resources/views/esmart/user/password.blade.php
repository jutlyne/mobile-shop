@extends('templates.esmart.layout-cart')

@section('main-content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ route('esmart.user.profile') }}" title="">Tài khoản</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" title="">Đổi mật khẩu</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Hồ sơ</h1>
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
                    <form action="{{ route('esmart.user.password') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="password-old">Nhập mật khẩu cũ</label>
                            <input type="password" class="form-control" value="{{ old('password_old') }}"
                                name="password_old" id="password-old">
                            @error('password_old')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Nhập mật khẩu mới</label>
                            <input type="password" class="form-control" value="{{ old('password_new') }}"
                                name="password_new" id="password">
                            @error('password_new')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="confirm-password">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" value="{{ old('confirm_password') }}"
                                name="confirm_password" id="confirm-password">
                            @error('confirm_password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn bg-danger text-light" value="Thay đổi mật khẩu">
                        </div>
                    </form>
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
                                <a href="{{ route('esmart.user.vieworder') }}" class="text-muted">Đơn mua</a>
                            </td>
                            <td>
                                <a href="{{ route('esmart.user.password') }}" class="text-danger">Đổi mật khẩu</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
