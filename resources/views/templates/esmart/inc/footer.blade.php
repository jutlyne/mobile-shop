<div id="footer-wp">
    <div id="foot-body">
        <div class="wp-inner clearfix">
            <div class="block" id="info-company">
                <h3 class="title">E-SMART</h3>
                <p class="desc">E-SMART luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ ràng, chính sách ưu
                    đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                <div id="payment">
                    <div class="thumb">
                        <img src="templates/esmart/images/img-foot.png" alt="">
                    </div>
                </div>
            </div>
            <div class="block menu-ft" id="info-shop">
                <h3 class="title">Thông tin cửa hàng</h3>
                <ul class="list-item">
                    <li>
                        <p>41 Lê Thị Tính - Thanh Khê - Đà Nẵng</p>
                    </li>
                    <li>
                        <p>0962.199.575</p>
                    </li>
                    <li>
                        <p>vocaoky0311@gmail.com</p>
                    </li>
                </ul>
            </div>
            <div class="block menu-ft policy" id="info-shop">
                <h3 class="title">Chính sách mua hàng</h3>
                <ul class="list-item">
                    <li>
                        <a href="" title="">Quy định - chính sách</a>
                    </li>
                    <li>
                        <a href="" title="">Chính sách bảo hành - đổi trả</a>
                    </li>
                    <li>
                        <a href="" title="">Chính sách hội viện</a>
                    </li>
                    <li>
                        <a href="" title="">Giao hàng - lắp đặt</a>
                    </li>
                </ul>
            </div>
            <div class="block" id="newfeed">
                <h3 class="title">Bảng tin</h3>
                <p class="desc">Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất</p>
                <div id="form-reg">
                    <form method="POST" action="javascript:void(0)">
                        <input type="text" name="email" id="email" placeholder="Nhập email tại đây">
                        <button type="submit" id="sm-reg">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="foot-bot">
        <div class="wp-inner">
            <p id="copyright">Design By Duy Vương - Coder By Kỳ Võ</p>
        </div>
    </div>
</div>
</div>
<div id="menu-respon">
    <a href="?page=home" title="" class="logo">E-SMART</a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
            <li>
                <a href="?page=home" title>Trang chủ</a>
            </li>
            <li>
                <a href="?page=category_product" title>Điện thoại</a>
                <ul class="sub-menu">
                    <li>
                        <a href="?page=category_product" title="">Iphone</a>
                    </li>
                    <li>
                        <a href="?page=category_product" title="">Samsung</a>
                        <ul class="sub-menu">
                            <li>
                                <a href="?page=category_product" title="">Iphone X</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Iphone 8</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="?page=category_product" title="">Nokia</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="?page=category_product" title>Máy tính bảng</a>
            </li>
            <li>
                <a href="?page=category_product" title>Laptop</a>
            </li>
            <li>
                <a href="?page=category_product" title>Đồ dùng sinh hoạt</a>
            </li>
            <li>
                <a href="?page=blog" title>Blog</a>
            </li>
            <li>
                <a href="#" title>Liên hệ</a>
            </li>
        </ul>
    </div>
</div>
<div id="btn-top"><img src="templates/esmart/images/icon-to-top.png" alt="" />
</div>

<!-- Load Facebook SDK for JavaScript -->
{{-- <div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v9.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat" attribution=setup_tool page_id="112950633962245" theme_color="#20cef5"
    logged_in_greeting="Xin chào các bạn!" logged_out_greeting="Xin chào bạn!">
</div> --}}

<!-- Your Comment Scricpt -->
{{-- <script async defer crossorigin="anonymous"
    src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v9.0&appId=3580890465290058&autoLogAppEvents=1"
    nonce="u8d6bbZ2">
</script> --}}


<script>
    function addCatItem(id) {
        var url = "{{ route('esmart.cart.add') }}/" + id;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                showCart();
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: 'Sản phẩm đã được thêm vào giỏ hàng!',
                    footer: '<a href = "' + "{{ route('esmart.cart.show-cart') }}" +
                        '">Đi đến giỏ hàng</a>'
                })
            }
        });
    }

    function showCart() {
        var url = "{{ route('esmart.cart.show') }}";
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#cart-wp').html(data);
            }
        });
    }

</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>

</body>

</html>
