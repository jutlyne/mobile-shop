@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> CẬP NHẬT TIN TỨC </h3>
    </div>
    <form action="{{ route('admin.post.edit-post', $infoPost->post_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="post_image_old" value="{{ $infoPost->post_image }}">
                        <div class="form-group">
                            <label for="post-name">Tên tin tức</label>
                            <input type="text" name="post_name" value="{{ $infoPost->post_name }}" class="form-control"
                                id="post-name" placeholder="Nhập tên tin tức (*)">
                        </div>

                        @error('post_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="post-cat">Danh mục</label>
                            <select name="cat_post_id" id="post-cat" class="form-control">
                                <option value="">-- Chọn danh mục tin (*) --</option>
                                @foreach ($cat_posts as $cat_post)
                                    @if ($cat_post->cat_post_id == $infoPost->cat_post_id)
                                        <option selected value="{{ $cat_post->cat_post_id }}">
                                            {{ $cat_post->cat_post_name }}
                                        </option>
                                    @endif
                                    <option value="{{ $cat_post->cat_post_id }}">
                                        {{ $cat_post->cat_post_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @error('cat_post_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <label for="product-popular">Trạng thái</label>
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="post_status" id="radio1"
                                                value="1" {{ $infoPost->post_status == 1 ? 'checked' : '' }}>
                                            Hiển thị
                                        </label>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="post_status" id="radios2"
                                                value="2" {{ $infoPost->post_status == 2 ? 'checked' : '' }}>
                                            Ẩn
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
                            <label for="post-image">Ảnh đại diện (*)</label>
                            <input type="file" name="post_image"
                                class="border border-secondary rounded p-2 form-control-file" id="post-image">
                        </div>

                        @error('post_image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                        <div class="form-group">
                            <span class="d-inline-block m-1 border">
                                <img width="200px" src="uploads/post/{{ $infoPost->post_image }}" alt="">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="post-desc">Mô tả tin tức</label>
                            <textarea name="post_desc" class="form-control" id="post-desc"
                                rows="10">{{ $infoPost->post_desc }}</textarea>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="post-content">Nội dung tin tức</label>
                            <textarea name="post_content"
                                class="summernote form-control">{{ $infoPost->post_content }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary">Cập nhật</button>
                        <button type="reset" class="btn btn-gradient-danger">Nhập lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
