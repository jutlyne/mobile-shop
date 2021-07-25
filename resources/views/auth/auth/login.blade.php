@extends('templates.esmart.layout-cart')

@section('main-content')
<?php
  if(isset($_POST['submit'])){
     $name;
     $captcha;
     if(isset($_POST['name'])){
        $name = $_POST['name'];
     }
     if(isset($_POST['g-recaptcha-response'])){
        $captcha = $_POST['g-recaptcha-response'];
     }
     if(!$captcha){
        echo '<h2>Hay xac nhan CAPTCHA</h2>';
     }else{
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret==== Your Secret key ===&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
        if($response.success == false){
           echo '<h2>SPAM!</h2>';
        }else{
           echo '<h2>'.$name.' Khong phai robot :)</h2>';
        }
     }
  }
?>
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
                            <form action="{{ route('auth.auth.login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="inputemail">Email</label>
                                    <input type="text" id="email-login" name="email" value="{{ old('email') }}" class="form-control"
                                        id="inputemail" placeholder="Email">
                                </div>

                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group">
                                    <label for="inputpassword">Mật khẩu</label>
                                    <input type="password" id="pass-login" name="password" class="form-control" id="inputpassword"
                                        placeholder="Mật khẩu">
                                </div>

                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror

                                <div class="form-group text-right">
                                    <a href="{{ route('auth.auth.reset-password') }}" class="">Quên mật khẩu?</a>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="cmdSubmit" class="btn btn-block"
                                        style="background: #17a2b8; color: #fff">Đăng nhập</button>
                                </div>

                                {{-- <div class="form-group text-center">
                                    <a href="" class="btn btn-block" style="background: #dc3545; color: #fff">Đăng nhập bằng
                                        Google
                                    </a>
                                </div> --}}
                                <div class="g-recaptcha" style="margin-bottom : 10px;" data-sitekey="6LdqWY8aAAAAAMWjKhBRjVbE60-24bTnfrAEqis9"></div>
                                <div class="form-group">
                                    <span class="text-muted">Nếu bạn chưa có tài khoản?</span>
                                    <a href="{{ route('auth.auth.register') }}">Đăng ký</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
      $("#cmdSubmit").click(function () {
          var email  = document.getElementById('email-login').value;
          var pass = document.getElementById('pass-login').value;
          var response = grecaptcha.getResponse();
          var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
          if(email == '' || pass == ''){
            Swal.fire({
                icon: 'error',
                title: 'Thông tin không hợp lệ',
                text: 'Vui lòng nhập vào đẩy đủ các trường để thực hiện việc đăng nhập!',
            });
            return false;
          }else if(!re.test(email)){
            Swal.fire({
                icon: 'error',
                title: 'Thông tin không hợp lệ',
                text: 'Vui lòng nhập đúng định dạng của Email!\nExample@gmail.com',
            });
            return false;
          }
          if(response.length == 0){
            Swal.fire({
                icon: 'error',
                title: 'Hoàn thành reCAPTCHA',
                text: 'Có vẻ như bạn chưa hoàn thành việc kiểm tra bảo mật của chúng tôi',
            });
            return false;
          }
      });
    </script>
@endsection
