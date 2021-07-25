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
                            <a href="javascript:void(0)" title="">Địa chỉ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Địa chỉ nhận hàng</h1>
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
                    @if (isset($user_address))
                        <form action="{{ route('esmart.user.address') }}" method="POST">
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="name">Họ tên</label>
                                    <input type="text" name="name" value="{{ $user_address->name }}" id="fullname">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" name="phone" value="{{ $user_address->phone }}">
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="city">Tỉnh/Thành phố</label>
                                    <select name="city" id="city" class="add-city form-control">
                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                        @foreach ($citys as $city)
                                            <option {{ $user_address->city == $city->matp ? 'selected' : '' }}
                                                value="{{ $city->matp }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="district">Quận/Huyện</label>
                                    <select name="district" id="district" class="add-district form-control">
                                        <option value="">Chọn Quận/Huyện</option>
                                        @foreach ($districts as $district)
                                            <option {{ $user_address->district == $district->maqh ? 'selected' : '' }}
                                                value="{{ $district->maqh }}">
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-col mb-3">
                                    <label for="ward">Xã/Phường</label>
                                    <select name="ward" id="ward" class="form-control">
                                        <option value="">Chọn Xã/Phường</option>
                                        @foreach ($wards as $ward)
                                            <option {{ $user_address->ward == $ward->xaid ? 'selected' : '' }}
                                                value="{{ $ward->xaid }}">{{ $ward->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('ward')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-col">
                                    <label for="address_detail">Xã/Phường - Tổ dân phố</label>
                                    <input type="text" class="form-control" value="{{ $user_address->ar_detail }}"
                                        name="address_detail" placeholder="Nhập địa chỉ cụ thể (thôn,ấp, số nhà,..)">
                                    @error('address_detail')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            @csrf
                            <div class="place-order-wp clearfix">
                                <input type="submit" id="order-now" value="Lưu">
                            </div>
                        </form>
                    @else
                        <form action="{{ route('esmart.user.address') }}" method="POST">
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="name">Họ tên</label>
                                    <input type="text" name="name" value="" id="fullname">
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" name="phone">
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row clearfix">
                                <div class="form-col fl-left">
                                    <label for="city">Tỉnh/Thành phố</label>
                                    <select name="city" id="city" class="add-city form-control">
                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                        @foreach ($citys as $city)
                                            <option value="{{ $city->matp }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-col fl-right">
                                    <label for="district">Quận/Huyện</label>
                                    <select name="district" id="district" class="add-district form-control">
                                        <option value="">Chọn quận huyện</option>
                                    </select>
                                    @error('district')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-col mb-3">
                                    <label for="ward">Xã/Phường</label>
                                    <select name="ward" id="ward" class="form-control">
                                        <option value="">Chọn xã phường</option>
                                    </select>
                                    @error('ward')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-col">
                                    <label for="address_detail">Tổ dân phố</label>
                                    <input type="text" class="form-control" name="address_detail"
                                        placeholder="Nhập địa chỉ cụ thể (thôn,ấp, số nhà,..)">
                                    @error('address_detail')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            @csrf
                            <div class="place-order-wp clearfix">
                                <input type="submit" id="order-now" value="Lưu">
                            </div>
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
                                <a href="{{ route('esmart.user.profile') }}" class="text-muted">Hồ sơ</a>
                            </td>
                            <td>
                                <a href="{{ route('esmart.user.address') }}" class="text-danger">Địa chỉ</a>
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

    <script>
        $(document).ready(function() {
            $('.add-city').on('change', function() {
                var matp = $(this).val();
                var url = "{{ route('esmart.user.getdistrict') }}";
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        matp: matp
                    },
                    success: function(data) {
                        $('#district').html(data);
                    }
                });
            });
            $('.add-district').on('change', function() {
                var maqh = $(this).val();
                var url = "{{ route('esmart.user.getward') }}";
                $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        maqh: maqh
                    },
                    success: function(data) {
                        $('#ward').html(data);
                    }
                });
            });
        });

    </script>
@endsection
