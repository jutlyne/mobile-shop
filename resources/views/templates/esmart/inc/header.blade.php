<!DOCTYPE html>
<html>

<head>
    <title>E-Smart Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="{{ asset('') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="templates/esmart/images/iconlogo.png" />
    <link href="templates/esmart/css/bootstrap/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="templates/esmart/reset.css" rel="stylesheet" type="text/css" />
    <link href="templates/esmart/css/carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
    <link href="templates/esmart/css/carousel/owl.theme.css" rel="stylesheet" type="text/css" />
    <link href="templates/esmart/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="templates/esmart/style.css" rel="stylesheet" type="text/css" />
    <link href="templates/esmart/responsive.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="templates/sweetalert/sweetalert2.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" type="text/javascript"></script>
    <script src="templates/esmart/js/elevatezoom-master/jquery.elevatezoom.js" type="text/javascript"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="templates/esmart/js/carousel/owl.carousel.js" type="text/javascript"></script>
    <script src="templates/esmart/js/main.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="templates/sweetalert/sweetalert2.min.js"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script
        src="https://www.paypal.com/sdk/js?client-id=Ac9pq-kHeWuGvVAo2AYj26xJpIjetDLjfkVK0xebRl18lQpCrteZIjPE27k1KsrUQYGMcLyzUx0IPIhH&currency=USD">
    </script>
    <script>
        $(document).ready(function() {
            $("#search-wp #s").keyup(function() {
                var keyword = $(this).val();
                if (keyword != '') {
                    $.ajax({
                        url: "{{ route('esmart.search.autocomplete') }}",
                        type: "GET",
                        data: {
                            keyword: keyword
                        },
                        success: function(data) {
                            $("#result-complete").fadeIn();
                            $("#result-complete").html(data);
                        }
                    });
                } else {
                    $("#result-complete").fadeOut();
                }
            });
        });

    </script>
    <style media="screen">
      /* The container <div> - needed to position the dropdown content */
      .dropdown {
      position: relative;
      display: inline-block;
      }

      /* Dropdown Content (Hidden by Default) */
      .dropdown-content {
      display: none;
      position: absolute;
      background-color: rgb(29, 113, 171);;
      min-width: 100px;
      z-index: 1;
      }

      /* Links inside the dropdown */
      .dropdown-content a {
      color: black;
      text-decoration: none;
      display: block;
      }

      /* Change color of dropdown links on hover */
      .dropdown-content a:hover {background-color: #f1c40f;}

      /* Show the dropdown menu on hover */
      .dropdown:hover .dropdown-content {display: block;}

      /* Change the background color of the dropdown button when the dropdown content is shown */

      .height-hiden{
        height: 350px;
        overflow-y: scroll;
      }
    </style>
</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        @if (Auth::check())
                            <a href="{{ route('esmart.user.profile') }}" title="" id="payment-link" class="fl-left">
                                {{ Auth::user()->email }}
                            </a>
                        @else
                            <a href="{{ route('auth.auth.login') }}" title="" id="payment-link" class="fl-left">
                                Đăng nhập
                            </a>
                        @endif

                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <!-- <li class="">
                                  <div class="dropdown">
                                    <a class="dropbtn">Ngôn ngữ</a>
                                    <div class="dropdown-content">
                                      <a href="#">VI</a>
                                      <a href="#">EN</a>
                                    </div>
                                  </div>
                                </li> -->
                                <li>
                                    <a href="{{ route('esmart.index.index') }}" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="{{ route('esmart.product.index') }}" title="">Sản phẩm</a>
                                </li>
                                <li>
                                    <a href="{{ route('esmart.post.index') }}" title="">Tin tức</a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('esmart.about.about') }}" title="">Giới thiệu</a>
                                </li>
                                <li>
                                    <a href="{{ route('esmart.contact.contact') }}" title="">Liên hệ</a>
                                </li> --}}
                                @if (Auth::check())
                                  @if (Auth::user()->role != null)
                                      <li>
                                          <a href="{{ route('admin.index.index') }}">Trang quản trị</a>
                                      </li>
                                  @endif
                                    <li>
                                        <a href="{{ route('auth.auth.logout') }}">Đăng xuất</a>
                                    </li>

                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="{{ route('esmart.index.index') }}" title="" id="logo" class="fl-left">
                            <span style="font-size: 36px;">E-SMART</span>
                        </a>
                        <div id="search-wp" class="fl-left">
                            <form method="GET" action="{{ route('esmart.search.search') }}" autocomplete="off"
                                class="position-relative">
                                <input type="text" name="keyword" id="s" placeholder="Nhập từ khóa tìm kiếm tại đây!">
                                <button type="submit" id="sm-s">Tìm kiếm</button>
                                <div id="result-complete" class="position-absolute w-100 bg-white"
                                    style="z-index:1;top:35px;">
                                    {{-- Dữ liệu tìm kiếm ajax trả về
                                    --}}
                                </div>
                            </form>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">Tư vấn</span>
                                <span class="phone">0962.199.575</span>
                            </div>
                            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <a href="?page=cart" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">2</span>
                            </a>
                            <div id="cart-wp" class="fl-right">
                                <div id="btn-cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="num">
                                        {{ Session::get('cart') == true ? Session::get('cart')['totalQty'] : '' }}
                                    </span>
                                </div>
                                @if (Session::get('cart') == true)
                                    @php
                                    $infoCart = Session::get('cart');
                                    @endphp
                                    <div id="dropdown">
                                        <p class="desc">
                                            Có <span>{{ $infoCart['totalQty'] }} sản phẩm</span> trong giỏ hàng
                                        </p>
                                        <ul class="list-cart height-hiden">
                                            @foreach ($infoCart['buy'] as $item)
                                                <li class="clearfix">
                                                    <a href="" title="" class="thumb fl-left">
                                                        <img src="uploads/product/{{ $item['infoProduct']['product_image'] }}"
                                                            alt="">
                                                    </a>
                                                    <div class="info fl-right">
                                                        <a href="" title=""
                                                            class="product-name">{{ $item['infoProduct']['product_name'] }}</a>
                                                        <p class="price">
                                                            {{ number_format($item['infoProduct']['product_price'], '0', ',', '.') }}đ
                                                        </p>
                                                        <p class="qty">Số lượng: <span>{{ $item['qty'] }}</span></p>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng:</p>
                                            <p class="price fl-right">
                                                {{ number_format($infoCart['totalPrice'], '0', ',', '.') }}đ
                                            </p>
                                        </div>
                                        <div class="action-cart clearfix">
                                            <a href="{{ route('esmart.cart.show-cart') }}" title="Giỏ hàng"
                                                class="view-cart fl-left">
                                                Giỏ hàng
                                            </a>
                                            <a href="{{ route('esmart.checkout.checkout') }}" title="Thanh toán"
                                                class="checkout fl-right">
                                                Thanh toán
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
