@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> DANH SÁCH SẢN PHẨM </h3>
        <p id="result"></p>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group" style="width: 200px">
                        <select name="" class="form-control" onchange="location=this.value">
                            <option value="{{ route('admin.product.list-product') }}">Tất cả danh mục</option>
                            @foreach ($cat_products as $cat_product)
                                <option
                                    value="{{ route('admin.product.list-product') }}?cat={{ $cat_product->cat_product_id }}"
                                    {{ $cat_product_id == $cat_product->cat_product_id ? 'selected' : '' }}>
                                    {{ str_repeat('--', $cat_product->level) }}
                                    {{ $cat_product->cat_product_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá bán</th>
                                    <th>Danh mục</th>
                                    <th>Hình ảnh</th>
                                    <th>Hiển thị</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $temp++ }}</td>
                                        <td>
                                            <div class="mb-1" title="{{ $product->product_name }}" style="cursor: pointer">
                                                {{ Str::limit($product->product_name, 40, '...') }}</div>
                                            <div class="change-popular-product" data-id="{{ $product->product_id }}"
                                                id="change-popular-{{ $product->product_id }}">
                                                @if ($product->product_popular == 1)
                                                    <a href="javascript:void(0)" class="badge badge-gradient-success">
                                                        Sản phẩm thường
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" class="badge badge-gradient-danger">
                                                        Phổ biến
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                {{ $product->product_price }}
                                            </div>
                                            <small style="font-family: roboto">
                                                Số lượng: {{ $product->product_qty }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                {{ $product->catProduct->cat_product_name }}
                                            </div>
                                            <small class="text-info" style="font-family: roboto">
                                                {{ $product->brandProduct->brand_name }}
                                            </small>
                                        </td>
                                        <td>
                                            <img style="width: 75px!important;height: auto!important; border-radius: 5%!important"
                                                src="{{ 'uploads/product/' . $product->product_image }}" class="mr-2"
                                                alt="image">
                                        </td>
                                        <td id="change-stutus-{{ $product->product_id }}"
                                            class="text-center change-status-product" data-id="{{ $product->product_id }}">
                                            @if ($product->product_status == 1)
                                                <small class="badge badge-gradient-success">
                                                    <i class="mdi mdi-check"></i>
                                                </small>
                                            @else
                                                <small class="badge badge-gradient-danger">
                                                    <i class="mdi mdi-window-close"></i>
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.product.edit-product', $product->product_id) }}"
                                                class="badge badge-gradient-info">
                                                <i class="mdi mdi-table-edit"></i>
                                            </a>
                                            <div class="mb-1"></div>
                                            <a href="{{ route('admin.product.del-product', $product->product_id) }}"
                                                onclick="return(confirm('Xác nhận xóa sản phẩm'))"
                                                class="badge badge-gradient-danger">
                                                <i class="mdi mdi-delete-forever"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block text-center mt-3">
                        <div class="d-inline-block">
                            @if ($cat_product_id != '')
                                {{ $products->appends(['cat' => $cat_product_id])->links() }}
                            @else
                                {{ $products->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.change-status-product').on('click', function() {
                var product_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.product.change-status-product') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        // toastr.success(data.status);
                        $('#change-stutus-' + product_id).html(data.icon);
                    }
                });
            });
            $('.change-popular-product').on('click', function() {
                var product_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.product.change-popular-product') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        $('#change-popular-' + product_id).html(data.icon);
                    }
                });
            });
        });

    </script>
@endsection
