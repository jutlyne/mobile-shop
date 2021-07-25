@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> DANH SÁCH NGƯỜI DÙNG </h3>
    </div>
    <div class="row">

        {{-- Add Brand Product --}}
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thêm người dùng</h4>
                    <form method="POST" action="{{ route('admin.user.edit-user', $infoUser->id) }}" id="form-cat-post"
                        class="forms-sample">
                        @csrf
                        <div class="form-group">
                            <label for="name">Họ tên</label>
                            <input type="text" name="name" value="{{ $infoUser->name }}" class="form-control" id="name"
                                placeholder="Nhập họ tên (*)">
                        </div>

                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ $infoUser->email }}" class="form-control" id="email"
                                disabled>
                        </div>

                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Nhập mật khẩu (*)">
                        </div>

                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="confirm-password">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm-password"
                                placeholder="Xác nhận mật khẩu (*)">
                        </div>

                        @error('confirm_password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="phone">Điện thoại</label>
                            <input type="text" name="phone" value="{{ $infoUser->phone }}" class="form-control"
                                id="password" placeholder="Nhập số điện thoại (*)">
                        </div>

                        @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="role">Vai trò</label>
                            <select name="role" id="role" class="form-control">
                                <option value="">-- Chọn vai trò --</option>
                                <option {{ $infoUser->role == 2 ? 'selected' : '' }} value="2">Biên tập</option>
                                <option {{ $infoUser->role == 3 ? 'selected' : '' }} value="3">Cộng tác</option>
                            </select>
                        </div>

                        @error('role')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">-- Chọn trạng thái --</option>
                                <option {{ $infoUser->status == 1 ? 'selected' : '' }} value="1">Kích hoạt</option>
                                <option {{ $infoUser->status == 2 ? 'selected' : '' }} value="2">Không kích hoạt</option>
                            </select>
                        </div>

                        @error('status')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="btn btn-gradient-primary btn-block">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
