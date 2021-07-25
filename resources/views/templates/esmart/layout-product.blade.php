@include('templates.esmart.inc.header')
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ route('esmart.product.index') }}">Sản phẩm</a>
                    </li>
                    @if (isset($infoCat))
                        <li>
                            <a
                                href="{{ route('esmart.product.cat', [$infoCat->cat_product_slug, $infoCat->cat_product_id]) }}">
                                {{ $infoCat->cat_product_name }}</a>
                        </li>
                    @endif
                    @if (isset($infoBrand))
                        <li>
                            <a
                                href="{{ route('esmart.product.brand', [$infoBrand->brand_slug, $infoBrand->brand_id]) }}">
                                {{ $infoBrand->brand_name }}</a>
                        </li>
                    @endif
                    @if (isset($infoProduct))
                        <li>
                            <a
                                href="{{ route('esmart.product.detail', [$infoProduct->product_slug, $infoProduct->product_id]) }}">
                                {{ $infoProduct->product_name }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        @yield('main-content')

        <!-- Sidebar  -->
        <div class="sidebar fl-left">

            @include('templates.esmart.inc.category-product')

            <div style="margin-top: 25px"></div>

            @include('templates.esmart.inc.brand-product')

            @include('templates.esmart.inc.product-selling')

        </div>
        <!-- /. End Sidebar  -->
    </div>
</div>
@include('templates.esmart.inc.footer')
