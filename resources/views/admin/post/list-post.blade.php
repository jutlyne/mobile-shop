@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> DANH SÁCH TIN </h3>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group" style="width: 200px">
                        <select name="" class="form-control" onchange="location=this.value">
                            <option value="{{ route('admin.post.list-post') }}">Tất cả danh mục</option>
                            @foreach ($cat_posts as $cat_post)
                                <option value="{{ route('admin.post.list-post') }}?cat={{ $cat_post->cat_post_id }}"
                                    {{ $cat_post_id == $cat_post->cat_post_id ? 'selected' : '' }}>
                                    {{ $cat_post->cat_post_name }}
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
                                    <th>Tên bài viết</th>
                                    <th>Danh mục</th>
                                    <th>Hình ảnh</th>
                                    <th class="text-center">Hiển thị</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $temp++ }}</td>
                                        <td>
                                            <div class="mb-1" title="{{ $post->post_name }}" style="cursor: pointer">
                                                {{ Str::limit($post->post_name, 50, '...') }}</div>
                                            <small style="font-family: roboto">
                                                {{ $post->created_at }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                {{ $post->catPost->cat_post_name }}
                                            </div>
                                        </td>
                                        <td>
                                            <img style="width: 75px!important;height: auto!important; border-radius: 5%!important"
                                                src="{{ 'uploads/post/' . $post->post_image }}" class="mr-2" alt="image">
                                        </td>
                                        <td class="text-center">
                                            <div class="change-status-post" data-id="{{ $post->post_id }}"
                                                id="status-post-{{ $post->post_id }}">
                                                @if ($post->post_status == 1)
                                                    <small class="badge badge-gradient-success">
                                                        <i class="mdi mdi-check"></i>
                                                    </small>
                                                @else
                                                    <small class="badge badge-gradient-danger">
                                                        <i class="mdi mdi-window-close"></i>
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.post.edit-post', $post->post_id) }}"
                                                class="badge badge-gradient-info">
                                                <i class="mdi mdi-table-edit"></i>
                                            </a>
                                            <div class="mb-1"></div>
                                            <a href="{{ route('admin.post.del-post', $post->post_id) }}"
                                                onclick="return(confirm('Xác nhận xóa bài viết'))"
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
                            @if ($cat_post_id)
                                {{ $posts->appends(['cat' => $cat_post_id])->links() }}
                            @else
                                {{ $posts->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.change-status-post').on('click', function() {
                var post_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.post.change-status-post') }}",
                    method: "GET",
                    data: {
                        post_id: post_id
                    },
                    success: function(data) {
                        $("#status-post-" + post_id).html(data.icon)
                    }
                });
            });
        });

    </script>
@endsection
