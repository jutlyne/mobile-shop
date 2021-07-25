@extends('templates.esmart.layout-product')

@section('main-content')
    <div class="main-content fl-right">
        <div class="section" id="list-product-wp">
            <div class="section-head clearfix">
                <h3 class="section-title fl-left">{{ $infoBrand->brand_name }}</h3>
                <div class="filter-wp fl-right">
                    <p class="desc">Hiển thị {{ $productBrand->count() }} trên {{ $countProduct }} sản phẩm</p>
                    <div class="form-filter">
                        <form method="GET">
                            <select onchange="location=this.value">
                                <option
                                    value="{{ route('esmart.product.brand', [$infoBrand->brand_slug, $infoBrand->brand_id]) }}">
                                    Sắp xếp theo giá</option>
                                <option {{ $sort == 'giam-nhieu' ? 'selected' : '' }}
                                    value="{{ route('esmart.product.brand', [$infoBrand->brand_slug, $infoBrand->brand_id]) }}?sort=giam-nhieu">
                                    Giảm giá nhiều
                                </option>
                                <option {{ $sort == 'giam-dan' ? 'selected' : '' }}
                                    value="{{ route('esmart.product.brand', [$infoBrand->brand_slug, $infoBrand->brand_id]) }}?sort=giam-dan">
                                    Giá cao xuống thấp
                                </option>
                                <option {{ $sort == 'tang-dan' ? 'selected' : '' }}
                                    value="{{ route('esmart.product.brand', [$infoBrand->brand_slug, $infoBrand->brand_id]) }}?sort=tang-dan">
                                    Giá thấp lên cao</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="section-detail">
                <ul class="list-item clearfix">
                    @foreach ($productBrand as $item)
                        <li>
                            <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}" title="" class="thumb">
                                <img src="uploads/product/{{ $item->product_image }}">
                            </a>
                            <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}" title="" class="product-name">
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
                                <a href="javascript:void(0)" onclick="addCatItem({{ $item->product_id }})" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{ route('esmart.product.detail', [$item->product_slug, $item->product_id]) }}" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="section" id="paging-wp">
            <div class="section-detail">
                @if ($sort != '')
                    {{ $productBrand->appends(['sort' => $sort])->links('vendor.pagination.pagination-public') }}
                @else
                    {{ $productBrand->links('vendor.pagination.pagination-public') }}
                @endif
            </div>
        </div>
    </div>
@endsection
