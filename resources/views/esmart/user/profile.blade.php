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
                            <a href="javascript:void(0)" title="">Tài khoản</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">
                        Hồ sơ
                    </h1>
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
                    @if (Auth::check())
                        @php
                        $infoUser = Auth::user();
                        @endphp
                        <form action="{{ route('esmart.user.profile') }}" method="POST">
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="name">Họ tên</label>
                                    <input type="text" value="{{ $infoUser->name }}" name="name" id="name">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-col fl-right">
                                    <label for="email">Email</label>
                                    <input type="email" value="{{ $infoUser->email }}" name="email" disabled>
                                </div>

                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="birthday">Ngày sinh</label>
                                    <input type="date" value="{{ $infoUser->birthday }}" name="birthday">
                                </div>
                                <div class="form-col fl-left" style="cursor: pointer">
                                    <label for="gender">Giới tính</label>
                                    <input type="radio" value="1" name="gender"
                                        {{ $infoUser->gender == 1 ? 'checked' : '' }}> Nam
                                    <span class="mx-1"></span>
                                    <input type="radio" value="2" name="gender"
                                        {{ $infoUser->gender == 2 ? 'checked' : '' }}> Nữ
                                    <span class="mx-1"></span>
                                    <input type="radio" value="3" name="gender"
                                        {{ $infoUser->gender == 3 ? 'checked' : '' }}> Khác
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="tel" value="{{ $infoUser->phone }}" name="phone" id="phone">
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="place-order-wp clearfix">
                                <input type="submit" id="order-now" value="Lưu">
                            </div>
                            <input type="hidden" name="id" value="{{ $infoUser->id }}">
                            @csrf
                        </form>
                    @endif
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
                                <a href="{{ route('esmart.user.profile') }}" class="text-danger">Hồ sơ</a>
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
                                <a href="{{ route('esmart.user.password') }}" class="text-muted">Đổi mật khẩu</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
