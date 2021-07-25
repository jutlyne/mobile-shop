@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> DANH MỤC TIN </h3>
    </div>
    <div class="row">

        {{-- Add Brand Product --}}
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm danh mục</h4>
                    <form id="form-cat-post" class="forms-sample">
                        @csrf
                        <div class="form-group">
                            <label for="cat-post-name">Tên danh mục</label>
                            <input type="text" name="cat_post_name" class="cat_post_name form-control" id="cat-post-name"
                                placeholder="Nhập tên danh mục (*)">
                        </div>
                        <div class="form-group">
                            <label for="cat-post-desc">Mô tả danh mục</label>
                            <textarea name="cat_post_desc" id="cat-post-desc" class="cat_post_desc form-control" rows="5"
                                placeholder="Nhập mô tả danh mục (*)"></textarea>
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
                    <h4 class="card-title">Danh Sách Danh Mục</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th class="text-center"> Tên danh mục</th>
                                    <th class="text-center"> Chức năng </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp
                                @foreach ($catPosts as $catPost)
                                    <tr>
                                        <td> {{ $temp++ }} </td>
                                        <td class="text-center"> {{ $catPost->cat_post_name }}</td>
                                        <td class="text-center">
                                            <button type="button" data-id="{{ $catPost->cat_post_id }}"
                                                class="edit-cat-post btn btn-gradient-info btn-sm">
                                                <i class="mdi mdi-table-edit"></i>
                                            </button>
                                            <button type="button" data-id="{{ $catPost->cat_post_id }}"
                                                class="delete-cat-post btn btn-gradient-danger btn-sm">
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
        <div class="modal fade" id="update-cat-post" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Cập nhật danh mục</h4>
                                <form id="form-update-cat-post" class="forms-sample">
                                    @csrf
                                    <input type="hidden" name="cat_post_id" class="edit-cat-post-id">
                                    <div class="form-group">
                                        <label for="cat-post-name">Tên danh mục</label>
                                        <input type="text" name="cat_post_name" class="edit-cat-post-name form-control"
                                            id="cat-post-name" placeholder="Nhập tên thương hiệu (*)">
                                    </div>
                                    <div class="form-group">
                                        <label for="cat-post-desc">Mô tả danh mục</label>
                                        <textarea name="cat_post_desc" id="cat-post-desc"
                                            class="edit-cat-post-desc form-control" rows="5"
                                            placeholder="Nhập mô tả thương hiệu (*)"></textarea>
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
            //Thêm danh mục tin
            $("#form-cat-post").on('submit', function(e) {
                e.preventDefault();
                var cat_post_name = $('.cat_post_name').val();
                var cat_post_desc = $('.cat_post_desc').val();
                $.ajax({
                    url: "{{ route('admin.cat-post.add') }}",
                    method: "POST",
                    cache: false,
                    data: {
                        cat_post_name: cat_post_name,
                        cat_post_desc: cat_post_desc
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
            //Xóa danh mục tin
            $('.delete-cat-post').on('click', function() {
                if (!confirm('Bạn có chắc chắn muốn xóa danh mục tin này không')) {
                    return false;
                }
                var cat_post_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.cat-post.del') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        cat_post_id: cat_post_id
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
            //Cập nhật danh mục tin
            $('.edit-cat-post').on('click', function() {
                var cat_post_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.cat-post.edit') }}",
                    method: "GET",
                    cache: false,
                    data: {
                        cat_post_id: cat_post_id
                    },
                    success: function(data) {
                        $('.edit-cat-post-id').val(data.cat_post_id);
                        $('.edit-cat-post-name').val(data.cat_post_name);
                        $('.edit-cat-post-desc').val(data.cat_post_desc);
                        $('#update-cat-post').modal('show');
                    }
                });
            });

            $('#form-update-cat-post').on('submit', function(e) {
                e.preventDefault();
                var cat_post_id = $('.edit-cat-post-id').val();
                var cat_post_name = $('.edit-cat-post-name').val();
                var cat_post_desc = $('.edit-cat-post-desc').val();
                $.ajax({
                    url: "{{ route('admin.cat-post.edit') }}",
                    method: "POST",
                    cache: false,
                    data: {
                        cat_post_id: cat_post_id,
                        cat_post_name: cat_post_name,
                        cat_post_desc: cat_post_desc
                    },
                    success: function(data) {
                        if (data.errors) {
                            for (var count = 0; count < data.errors.length; count++) {
                                toastr.error(data.errors[count]);
                            }
                        } else {
                            $('#update-cat-post').modal('hide');
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
