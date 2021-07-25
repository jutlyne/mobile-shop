@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> DANH MỤC SẢN PHẨM </h3>
    </div>
    <div class="row">
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm danh mục</h4>
                    <form id="form-cat-product" class="forms-sample">
                        <div class="form-group">
                            <label for="cat-name">Tên danh mục</label>
                            <input type="text" class="cat-product-name form-control" id="cat-name"
                                placeholder="Nhập tên danh mục (*)">
                        </div>
                        <div class="form-group">
                            <label for="cat-desc">Mô tả danh mục</label>
                            <textarea id="cat-desc" class="cat-product-desc form-control" rows="5"
                                placeholder="Nhập mô tả danh mục (*)"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="cat-parent">Danh mục cha</label>
                            <select id="cat-parent" class="cat-product-parent form-control">
                                <option value="0">-- Chọn danh mục cha --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->cat_product_id }}">
                                        {{ str_repeat('--', $category->level) }}
                                        {{ $category->cat_product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary btn-block">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Danh sách danh mục</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Tên danh mục </th>
                                    <th> Chức năng </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp
                                @foreach ($categories as $category)
                                    <tr>
                                        <td> {{ $temp++ }} </td>
                                        <td>
                                            @for ($i = 1; $i <= $category->level; $i++)
                                                <i class="mdi mdi-label text-muted"></i>
                                            @endfor
                                            {{ $category->cat_product_name }}
                                        </td>
                                        <td>
                                            <button type="button" data-id="{{ $category->cat_product_id }}"
                                                class="edit-cat-product btn btn-gradient-info btn-sm">
                                                <i class="mdi mdi-table-edit"></i>
                                            </button>
                                            <button type="button" data-id="{{ $category->cat_product_id }}"
                                                class="del-cat-product btn btn-gradient-danger btn-sm">
                                                <i class="mdi mdi-delete-forever"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit CatProduct --}}
        <div class="modal fade" id="update-cat-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Cập nhật danh mục</h4>
                                <form id="form-update" class="forms-sample">
                                    @csrf
                                    <input type="hidden" class="edit-cat-product-id">
                                    <div class="form-group">
                                        <label for="">Tên danh mục</label>
                                        <input type="text" class="edit-cat-product-name form-control"
                                            placeholder="Nhập tên danh mục (*)">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Mô tả danh mục</label>
                                        <textarea class="edit-cat-product-desc form-control" rows="5"
                                            placeholder="Nhập mô tả danh mục (*)"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary btn-block">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- /.End Edit CatProduct --}}
    </div>
    
    <script>
        $(document).ready(function() {
            //Add Cat Product
            $('#form-cat-product').on('submit', function(e) {
                e.preventDefault();
                var cat_product_name = $('.cat-product-name').val();
                var cat_product_desc = $('.cat-product-desc').val();
                var cat_product_parent = $('.cat-product-parent').val();
                $.ajax({
                    url: "{{ route('admin.cat-product.add') }}",
                    method: "POST",
                    cache: false,
                    data: {
                        cat_product_name: cat_product_name,
                        cat_product_desc: cat_product_desc,
                        cat_product_parent: cat_product_parent,
                    },
                    success: function(data) {
                        if (data.errors) {
                            for (var count = 0; count < data.errors.length; count++) {
                                toastr.error(data.errors[count]);
                            }
                        } else {
                            toastr.success(data.success);
                            setTimeout(function() {
                                window.location.reload();
                            }, 200);
                        }
                    }
                });
            });
            //Edit Cat Product
            $('.edit-cat-product').on('click', function() {
                var cat_product_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.cat-product.edit') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        cat_product_id: cat_product_id
                    },
                    success: function(data) {
                        $('.edit-cat-product-id').val(data.cat_product_id);
                        $('.edit-cat-product-name').val(data.cat_product_name);
                        $('.edit-cat-product-desc').val(data.cat_product_desc);
                        $("#update-cat-product").modal('show');
                    }
                });
            });
            $("#update-cat-product").on('submit', function(e) {
                e.preventDefault();
                var cat_product_id = $('.edit-cat-product-id').val();
                var cat_product_name = $('.edit-cat-product-name').val();
                var cat_product_desc = $('.edit-cat-product-desc').val();
                $.ajax({
                    url: "{{ route('admin.cat-product.edit') }}",
                    method: "POST",
                    cache: false,
                    data: {
                        cat_product_id: cat_product_id,
                        cat_product_name: cat_product_name,
                        cat_product_desc: cat_product_desc
                    },
                    success: function(data) {
                        if (data.errors) {
                            for (var count = 0; count < data.errors.length; count++) {
                                toastr.error(data.errors[count]);
                            }
                        } else {
                            $("#update-cat-product").modal('hide');
                            toastr.success(data.success);
                            setTimeout(function() {
                                window.location.reload();
                            }, 200);
                        }
                    }
                });
            });
            //Delete Cat Product
            $('.del-cat-product').on('click', function() {
                if (!confirm('Bạn có chắc chắc muốn xóa danh mục này không?')) {
                    return false;
                }
                var cat_product_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.cat-product.del') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        cat_product_id: cat_product_id
                    },
                    success: function(data) {
                        if (data.error) {
                            toastr.error(data.error);
                        } else {
                            toastr.success(data.success);
                            setTimeout(function() {
                                window.location.reload();
                            }, 200);
                        }
                    }
                });
            });
        });

    </script>

@endsection
