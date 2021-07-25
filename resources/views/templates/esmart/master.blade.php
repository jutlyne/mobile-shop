@include('templates.esmart.inc.header')
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">

        @yield('main-content')

        <!-- Sidebar -->
        <div class="sidebar fl-left">

            @include('templates.esmart.inc.category-product')

            <div style="margin-top: 25px"></div>
            @include('templates.esmart.inc.category-post')

            @include('templates.esmart.inc.product-selling')

        </div>
        <!-- /End Sidebar -->
    </div>
</div>
@include('templates.esmart.inc.footer')
