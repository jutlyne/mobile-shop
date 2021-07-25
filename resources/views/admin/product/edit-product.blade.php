@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> SỬA SẢN PHẨM </h3>
    </div>
    <form action="{{ route('admin.product.edit-product', $infoProduct->product_id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="product_image_old" value="{{ $infoProduct->product_image }}">
                        <div class="form-group">
                            <label for="product-name">Tên sản phẩm</label>
                            <input type="text" name="product_name" value="{{ $infoProduct->product_name }}"
                                class="form-control" id="product-name" placeholder="Nhập tên sản phẩm (*)">
                        </div>

                        @error('product_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="product-cat">Danh mục</label>
                            <select name="cat_product_id" id="product-cat" class="form-control">
                                <option value="">-- Chọn danh mục (*) --</option>
                                @foreach ($cat_products as $cat_product)
                                    @if ($infoProduct->cat_product_id == $cat_product->cat_product_id)
                                        <option selected value="{{ $cat_product->cat_product_id }}">
                                            {{ str_repeat('--', $cat_product->level) }}
                                            {{ $cat_product->cat_product_name }}
                                        </option>
                                    @endif
                                    <option value="{{ $cat_product->cat_product_id }}">
                                        {{ str_repeat('--', $cat_product->level) }}
                                        {{ $cat_product->cat_product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @error('cat_product_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="product-brand">Thương hiệu</label>
                            <select name="brand_id" id="product-brand" class="form-control">
                                <option value="">-- Chọn thương hiệu (*) --</option>
                                @foreach ($brand_products as $brand_product)
                                    @if ($infoProduct->brand_id == $brand_product->brand_id)
                                        <option selected value="{{ $brand_product->brand_id }}">
                                            {{ $brand_product->brand_name }}
                                        </option>
                                    @endif
                                    <option value="{{ $brand_product->brand_id }}">{{ $brand_product->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @error('brand_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="product-price">Giá bán</label>
                            <input type="text" name="product_price" value="{{ $infoProduct->product_price }}"
                                class="form-control" id="product-price" placeholder="Nhập giá bán (*)">
                        </div>

                        @error('product_price')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="product-sale">Giảm giá</label>
                            <input type="number" name="product_sale" value="{{ $infoProduct->product_sale }}" min="0"
                                max="100" class="form-control" id="product-sale" placeholder="Nhập số % cần giảm">
                        </div>

                        <div class="form-group">
                            <label for="product-price">Số lượng</label>
                            <input type="number" name="product_qty" value="{{ $infoProduct->product_qty }}"
                                class="form-control" id="product-price" placeholder="Nhập số lượng hiện có">
                        </div>

                        @error('product_qty')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="product-popular">Sản phẩm phổ biến</label>
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input {{ $infoProduct->product_popular == 1 ? 'checked' : '' }} type="radio"
                                                class="form-check-input" name="product_popular" id="radio1" value="1">
                                            Sản phẩm thường
                                        </label>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input {{ $infoProduct->product_popular == 2 ? 'checked' : '' }} type="radio"
                                                class="form-check-input" name="product_popular" id="radios2" value="2">
                                            Phổ biến
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="product-image">Ảnh đại diện (*)</label>
                            <input type="file" name="product_image"
                                class="border border-secondary rounded p-2 form-control-file" id="product-image">
                        </div>

                        @error('product_image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <span class="d-inline-block m-1 border">
                                <img width="100px" src="uploads/product/{{ $infoProduct->product_image }}" alt="">
                            </span>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label for="gallery">Thư viện ảnh</label>
                                <input type="file" name="gallery[]"
                                    class="border border-secondary rounded p-2 form-control-file" id="gallery" multiple>
                            </div>
                        </div>

                        <div class="form-group">
                            @foreach ($infoProduct->imageGallery as $gallery)
                                <span class="d-inline-block m-1">
                                    <div class="position-relative border">
                                        <img width="100px" src="uploads/gallery/{{ $gallery->gallery_path }}" alt="">
                                        <button type="button" data-id="{{ $gallery->gallery_id }}"
                                            class="del-gallery position-absolute fixed-top btn-gradient-danger btn-icon">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </span>
                            @endforeach
                        </div>

                        @error('gallery.*')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="product-desc">Mô tả sản phẩm</label>
                            <textarea name="product_desc" class="form-control" id="product-desc"
                                rows="10">{{ $infoProduct->product_desc }}</textarea>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="product-spec">Thông số kỹ thuật</label>
                            <textarea name="product_spec"
                                class="summernote form-control">{{ $infoProduct->product_spec }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="product-article">Bài viết mô tả</label>
                            <textarea name="product_article" class="summernote form-control"
                                id="product-article">{{ $infoProduct->product_article }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary">Cập nhật</button>
                        <button type="reset" class="btn btn-gradient-danger">Nhập lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('.del-gallery').on('click', function() {
                if (!confirm('Xác nhận xóa hình ảnh')) {
                    return false;
                }
                var gallery_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.gallery.del') }}",
                    data: {
                        gallery_id: gallery_id
                    },
                    success: function(data) {
                        toastr.success(data.success);
                        setTimeout(function() {
                            window.location.reload();
                        }, 100);
                    }
                });
            });
        });

    </script>

@endsection
