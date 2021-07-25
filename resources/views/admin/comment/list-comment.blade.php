@extends('templates.admin.master')

@section('main-content')

    <div class="page-header">
        <h3 class="page-title"> DANH SÁCH BÌNH LUẬN </h3>
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
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Duyệt</th>
                                    <th>Sản phẩm</th>
                                    <th>Tên người gửi</th>
                                    <th>Bình luận</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listComment as $item)
                                    <tr>
                                        <td id="comment-result-{{ $item->comment_id }}">
                                            @if ($item->comment_status == 1)
                                                <button data-id="{{ $item->comment_id }}"
                                                    class="comment-status border-0 text-light bg-info rounded p-1">
                                                    Duyệt
                                                </button>
                                            @else
                                                <button data-id="{{ $item->comment_id }}"
                                                    class="comment-status border-0 text-light bg-danger rounded p-1">
                                                    Bỏ duyệt
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->product->product_name }}
                                        </td>
                                        <td>
                                            <div class="mb-1">{{ $item->comment_name }}</div>
                                            <small style="font-family: roboto">
                                                {{ $item->comment_email }}
                                            </small>
                                            <br>
                                            <small style="font-family: roboto">
                                                Thời gian: {{ $item->comment_date }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="mb-1 text-info">
                                                {{ $item->comment_content }}
                                            </div>
                                            <span class="text-muted">Trả lời:</span>
                                            @php
                                            $commentChild =
                                            DB::table('comments')->where('comment_parent',$item->comment_id)->orderBy('comment_id',
                                            'DESC')->get();
                                            @endphp
                                            @foreach ($commentChild as $child)
                                                <div>
                                                    <small class="text-success">{{ $child->comment_content }}</small>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="#" data-id="{{ $item->comment_id }}"
                                                class="reply-comment badge badge-gradient-info">
                                                <i class="mdi mdi-table-edit"></i>
                                            </a>
                                            <div class="mb-1"></div>
                                            <a href="#" data-id="{{ $item->comment_id }}"
                                                class="del-comment badge badge-gradient-danger">
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
                            {{ $listComment->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-reply-comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Trả lời bình luận</h4>
                            <form id="form-reply-comment" class="forms-sample">
                                @csrf
                                <input type="hidden" value="" class="comment-parent-id">
                                <div class="form-group">
                                    <label for="cat-post-desc">Nhập nội dung trả lời</label>
                                    <textarea name="comment_content" id="comment-content"
                                        class="comment-content form-control" rows="5"
                                        placeholder="Nhập nội dung trả lời (*)"></textarea>
                                </div>
                                <button type="submit" class="btn btn-gradient-primary btn-block">Gửi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            //Duyệt bình luận
            $(document).on('click', '.comment-status', function() {
                var comment_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.comment.change-status') }}",
                    type: "GET",
                    data: {
                        comment_id: comment_id
                    },
                    success: function(data) {
                        $('#comment-result-' + comment_id).html(data);
                    }
                });
            });
            //Trả lời bình luận
            $(document).on('click', '.reply-comment', function(e) {
                e.preventDefault();
                var comment_id = $(this).attr('data-id');
                $('#form-reply-comment .comment-parent-id').val(comment_id);
                $('#modal-reply-comment').modal('show');
            });

            $(document).on('submit', '#form-reply-comment', function(e) {
                e.preventDefault();
                var comment_parent = $('#form-reply-comment .comment-parent-id').val();
                var comment_content = $('#form-reply-comment .comment-content').val();
                if (comment_content == '') {
                    toastr.error('Nhập trả lời bình luận');
                    return false;
                }

                $.ajax({
                    url: "{{ route('admin.comment.reply-comment') }}",
                    type: "POST",
                    data: {
                        comment_parent: comment_parent,
                        comment_content: comment_content
                    },
                    cache: false,
                    success: function(data) {
                        toastr.success(data);
                        $('#modal-reply-comment').modal('hide');
                        setTimeout(function() {
                            window.location.reload();
                        }, 100);
                    }
                });

            });
            //Xóa bình luận
            $(document).on('click', '.del-comment', function(e) {
                e.preventDefault();
                if (!confirm('Bạn có chắc chắn muốn xóa bình luận này không')) {
                    return false;
                }
                var comment_id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('admin.comment.del-comment') }}",
                    type: "GET",
                    data: {
                        comment_id: comment_id
                    },
                    success: function(data) {
                        toastr.success(data);
                        setTimeout(function() {
                            window.location.reload();
                        }, 100);
                    }
                })
            });
        });

    </script>
@endsection
