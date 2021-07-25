@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> THƯƠNG HIỆU SẢN PHẨM </h3>
    </div>
    <div class="row">

        {{-- Add Brand Product --}}
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm thương hiệu</h4>
                    <form id="form-brand-product" class="forms-sample">
                        @csrf
                        <div class="form-group">
                            <label for="brand-name">Tên thương hiệu</label>
                            <input type="text" name="brand_name" class="brand_name form-control" id="brand-name"
                                placeholder="Nhập tên thương hiệu (*)">
                        </div>
                        <div class="form-group">
                            <label for="brand-desc">Mô tả thương hiệu</label>
                            <textarea name="brand_desc" id="brand-desc" class="brand_desc form-control" rows="5"
                                placeholder="Nhập mô tả thương hiệu (*)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary btn-block">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
        {{-- List Brand Product --}}
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Danh sách thương hiệu</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th class="text-center"> Tên thương hiệu</th>
                                    <th class="text-center"> Chức năng </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td> {{ $temp++ }} </td>
                                        <td class="text-center"> {{ $brand->brand_name }}</td>
                                        <td class="text-center">
                                            <button type="button" data-id="{{ $brand->brand_id }}"
                                                class="edit-brand btn btn-gradient-info btn-sm">
                                                <i class="mdi mdi-table-edit"></i>
                                            </button>
                                            <button type="button" data-id="{{ $brand->brand_id }}"
                                                class="delete-brand btn btn-gradient-danger btn-sm">
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
        {{-- Edit Brand Product --}}
        <div class="modal fade" id="update-brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Cập nhật thương hiệu</h4>
                                <form id="form-update" class="forms-sample">
                                    @csrf
                                    <input type="hidden" name="brand_id" class="edit-brand-id">
                                    <div class="form-group">
                                        <label for="brand-name">Tên thương hiệu</label>
                                        <input type="text" name="brand_name" class="edit-brand-name form-control"
                                            id="brand-name" placeholder="Nhập tên thương hiệu (*)">
                                    </div>
                                    <div class="form-group">
                                        <label for="brand-desc">Mô tả thương hiệu</label>
                                        <textarea name="brand_desc" id="brand-desc" class="edit-brand-desc form-control"
                                            rows="5" placeholder="Nhập mô tả thương hiệu (*)"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary btn-block">Cập nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            //Thêm thương hiệu
            $("#form-brand-product").on('submit', function(e) {
                e.preventDefault();
                var brand_name = $('.brand_name').val();
                var brand_desc = $('.brand_desc').val();
                $.ajax({
                    url: "{{ route('admin.brand-product.add') }}",
                    method: "POST",
                    cache: false,
                    data: {
                        brand_name: brand_name,
                        brand_desc: brand_desc
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
                            }, 100);
                        }
                    }
                });
            });
            //Xóa thương hiệu
            $('.delete-brand').on('click', function() {
                if (!confirm('Bạn có chắc chắn muốn xóa thương hiệu này không')) {
                    return false;
                }
                var brand_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.brand-product.del') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        brand_id: brand_id
                    },
                    success: function(data) {
                        if (data.error) {
                            toastr.error(data.error);
                        } else {
                            toastr.success(data.success);
                            setTimeout(function() {
                                window.location.reload();
                            }, 100);
                        }
                    }
                });
            });
            //Cập nhật thương hiệu
            $('.edit-brand').on('click', function() {
                var brand_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.brand-product.edit') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        brand_id: brand_id
                    },
                    success: function(data) {
                        $('.edit-brand-id').val(data.brand_id);
                        $('.edit-brand-name').val(data.brand_name);
                        $('.edit-brand-desc').val(data.brand_desc);
                        $('#update-brand').modal('show');
                    }
                });
            });

            $('#form-update').on('submit', function(e) {
                e.preventDefault();
                var brand_id = $('.edit-brand-id').val();
                var brand_name = $('.edit-brand-name').val();
                var brand_desc = $('.edit-brand-desc').val();
                $.ajax({
                    url: "{{ route('admin.brand-product.edit') }}",
                    method: "POST",
                    cache: false,
                    data: {
                        brand_id: brand_id,
                        brand_name: brand_name,
                        brand_desc: brand_desc
                    },
                    success: function(data) {
                        if (data.errors) {
                            for (var count = 0; count < data.errors.length; count++) {
                                toastr.error(data.errors[count]);
                            }
                        } else {
                            $('#update-brand').modal('hide');
                            toastr.success(data.success);
                            setTimeout(function() {
                                window.location.reload();
                            }, 100);
                        }
                    }
                });
            });
        });

    </script>

@endsection
