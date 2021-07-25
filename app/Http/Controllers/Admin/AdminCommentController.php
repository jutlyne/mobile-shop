<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class AdminCommentController extends Controller
{
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function list()
    {
        $listComment = $this->comment->getItems();
        return view('admin.comment.list-comment', compact('listComment'));
    }
    public function changeStatus(Request $request)
    {
        $comment_id = $request->comment_id;
        $infoComment = $this->comment->getItem($comment_id);
        $commentStatus = $infoComment->comment_status;
        if ($commentStatus == 1) {
            $this->comment->editItem(['comment_status' => 2], $comment_id);
            return '
                    <button data-id="' . $comment_id . '"
                        class="comment-status border-0 text-light bg-danger rounded p-1">
                        Bỏ duyệt
                    </button>
            ';
        } elseif ($commentStatus == 2) {
            $this->comment->editItem(['comment_status' => 1], $comment_id);
            return '
                    <button data-id="' . $comment_id . '"
                        class="comment-status border-0 text-light bg-info rounded p-1">
                        Duyệt
                    </button>
                ';
        }
    }
    public function replyComment(Request $request)
    {
        $comment_parent = $request->comment_parent;
        $comment_content = $request->comment_content;
        $product_id = $this->comment->getItem($comment_parent)->product_id;
        $comment_name = Auth::user()->name;
        $comment_email = Auth::user()->email;

        $data = [
            'comment_name' => $comment_name,
            'comment_email' => $comment_email,
            'comment_content' => $comment_content,
            'product_id' => $product_id,
            'comment_parent' => $comment_parent,
            'comment_status' => 1
        ];

        $result = $this->comment->addItem($data);
        if ($result == true) {
            return "Trả lời bình luận thành công";
        }
    }
    public function delComment(Request $request)
    {
        $comment_id = $request->comment_id;
        $result = $this->comment->delItem($comment_id);
        if ($result == true) {
            return "Xóa bình luận thành công";
        }
    }
}
