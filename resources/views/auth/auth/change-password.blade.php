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
                            <a href="javascript:void(0)" title="">Đăng nhập</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="pb-5 mx-5">
                            <div class="">
                                <img src="https://i.imgur.com/uNGdWHi.png" class="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 p-sm-5">
                            @if (session('msg'))
                                <p class="text-success text-center">
                                    {{ session('msg') }}
                                </p>
                            @endif
                            @if (session('error'))
                                <p class="text-danger text-center">
                                    {{ session('error') }}
                                </p>
                            @endif
                            <form action="{{ route('auth.auth.change-password') }}" method="POST">
                                @csrf
                                <input type="hidden" name="email" value="{{ $emailReset }}">
                                <input type="hidden" name="code" value="{{ $code }}">
                                <div class="form-group">
                                    <label for="inputpassword">Mật khẩu mới</label>
                                    <input type="password" name="password" value="{{ old('password') }}"
                                        class="form-control" id="inputpassword" placeholder="Nhập mật khẩu mới">
                                </div>

                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label for="confirm-password">Xác nhận mật khẩu mới</label>
                                    <input type="password" name="confirm_password" value="{{ old('confirm_password') }}"
                                        class="form-control" id="confirm-password" placeholder="Xác nhận mật khẩu mới">
                                </div>

                                @error('confirm_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <button type="submit" class="btn btn-block" style="background: #17a2b8; color: #fff">Đặt
                                        lại mật khẩu</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
