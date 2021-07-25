@extends('templates.esmart.master')

@section('main-content')
    <div class="main-content fl-right">
        <div class="section" id="slider-wp">
            <div class="section-detail">
                <div class="item">
                    <img src="https://salt.tikicdn.com/ts/banner/2d/8e/92/c6b19af852a48191dc2208fc942acad8.jpg" alt="">
                </div>
                <div class="item">
                    <img src="https://salt.tikicdn.com/ts/banner/d3/be/71/5ef563e60c6474802ae5fe8ae0b4f9ee.jpg" alt="">
                </div>
                <div class="item">
                    <img src="https://salt.tikicdn.com/ts/banner/54/67/04/34ab5934189ed50ff1760cd03e3d8834.jpg" alt="">
                </div>
            </div>
        </div>
        @php
          dd($sale);
          die();
        @endphp
        @if(count($sale) == 0)
        <div class="section" id="feature-product-wp">
            <div class="section-head">
                <h3 class="section-title">Sự kiện giảm giá</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @foreach ($productSale as $item)
                    @php
                      $id = $item->product_id;
                    @endphp
                      @foreach ($sale as $giamgia)
                        @if ($id == $giamgia->product_id)
                        <li>
                            <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                                title="" class="thumb">
                                <img src="uploads/product/{{ $item->product_image }}">
                            </a>
                            <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                                title="" class="product-name">
                                {{ $item->product_name }}
                            </a>
                            <div class="price">
                                <span class="new">
                                    {{ number_format($item->product_price - ($item->product_price * $giamgia->discount) / 100, 0, ',', '.') }}đ
                                </span>
                                <span class="text-success">
                                    -{{ $giamgia->discount }} %
                                </span>
                                <br>
                                <span class="old">
                                    {{ number_format($item->product_price, 0, ',', '.') }}đ
                                </span>
                            </div>
                            <div class="action clearfix">
                                <a href="javascript:void(0)" onclick="addCatItem({{ $item->product_id }})"
                                    class="add-cart fl-left">Thêm
                                    giỏ hàng</a>
                                <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                                    title="" class="buy-now fl-right">Xem chi tiết</a>
                            </div>
                        </li>
                          @endif
                        @endforeach
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        <div class="section" id="list-product-wp">
            <div class="section-head">
                <h3 class="section-title">Sản phẩm nổi bật</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item clearfix">
                    @foreach ($productPopular as $item)
                        <li>
                            <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                                class="thumb">
                                <img src="uploads/product/{{ $item->product_image }}">
                            </a>
                            <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}" class="product-name">
                                {{ $item->product_name }}
                            </a>
                            <div class="price">
                                <span class="new">
                                    {{ number_format($item->product_price - ($item->product_price * $item->product_sale) / 100, 0, ',', '.') }}đ
                                </span>
                                <span class="text-success">
                                    -{{ $item->product_sale }} %
                                </span>
                                <br>
                                <span class="old">
                                    {{ number_format($item->product_price, 0, ',', '.') }}đ
                                </span>
                            </div>
                            <div class="action clearfix">
                                <a href="javascript:void(0)" onclick="addCatItem({{ $item->product_id }})"
                                    class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}"
                                    title="" class="buy-now fl-right">Xem chi tiết</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="section" id="paging-wp">
            <div class="section-detail">
                {{ $productPopular->links('vendor.pagination.pagination-public') }}
            </div>
        </div>
    </div>

    @if (isset($_GET['page']) && $_GET['page'])
        <script>
            $(document).ready(function() {
                var location = $('#list-product-wp').offset().top;
                $('html,body').animate({
                    scrollTop: location
                }, 400);
                return false;
            });

        </script>
    @endif

@endsection
