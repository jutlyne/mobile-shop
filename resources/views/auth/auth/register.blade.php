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
                            <a href="javascript:void(0)" title="">Đăng ký</a>
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
                                <p class="text-danger text-center">
                                    {{ session('msg') }}
                                </p>
                            @endif
                            @if (session('error'))
                                <p class="text-danger text-center">
                                    {{ session('error') }}
                                </p>
                            @endif
                            <form action="{{ route('auth.auth.register') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="inputname">Họ tên</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                        id="inputname" placeholder="Họ tên">
                                </div>

                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label for="inputemail">Email (*)</label>
                                    <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                        id="inputemail" placeholder="Email">
                                </div>

                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label for="inputpassword">Mật khẩu (*)</label>
                                    <input type="password" name="password" class="form-control" id="inputpassword"
                                        placeholder="Password">
                                </div>

                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label for="confirmpassword">Nhập lại mật khẩu (*)</label>
                                    <input type="password" name="confirm_password" class="form-control" id="confirmpassword"
                                        placeholder="Password">
                                </div>

                                @error('confirm_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label for="phonenumber">Điện thoại</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control"
                                        id="phonenumber" placeholder="Số điện thoại">
                                </div>

                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <button type="submit" class="btn btn-block"
                                        style="background: #17a2b8; color: #fff">Đăng ký</button>
                                </div>

                                <div class="form-group">
                                    <span class="text-muted">Nếu bạn đã có tài khoản?</span>
                                    <a href="{{ route('auth.auth.login') }}">Đăng nhập</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
