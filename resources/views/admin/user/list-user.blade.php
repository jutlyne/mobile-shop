@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> DANH SÁCH NGƯỜI DÙNG </h3>
        <p id="result"></p>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @if (session('msg'))
                        <div class="alert alert-success">
                            {{ session('msg') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Vai trò</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $temp++ }}</td>
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->phone }}
                                        </td>
                                        <td>
                                            @if ($user->role == 1)

                                                <span class="text-success">
                                                    Quản trị
                                                    @if ($user->email == 'minhlam1996vn@gmail.com')
                                                        <i class="mdi mdi-bookmark-check"></i>
                                                    @endif
                                                </span>
                                            @elseif($user->role == 2)
                                                <span class="text-info">Biên tập</span>
                                            @elseif($user->role == 3)
                                                <span class="text-secondary">Cộng tác</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status == 1)
                                                <small class="text-light bg-success p-1">Hoạt động</small>
                                            @else
                                                <small class="text-light bg-danger p-1">Tạm khóa</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->role != 1)
                                                <a href="{{ route('admin.user.edit-user', $user->id) }}"
                                                    title="Sửa thông tin + quyền" class="badge badge-gradient-info">
                                                    <i class="mdi mdi-table-edit"></i>
                                                </a>
                                                <div class="mb-1"></div>
                                                <a href="{{ route('admin.user.del-user', $user->id) }}"
                                                    onclick="return(confirm('Xác nhận xóa người dùng'))"
                                                    class="badge badge-gradient-danger">
                                                    <i class="mdi mdi-delete-forever"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block text-center mt-3">
                        <div class="d-inline-block">
                            {{-- {{ $users->links() }} --}}
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
