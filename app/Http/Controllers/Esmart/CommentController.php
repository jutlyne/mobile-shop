<?php

namespace App\Http\Controllers\Esmart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function addComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required|max:100',
        ], [
            'name.required' => 'Nhập họ tên của bạn',
            'email.required' => 'Nhập email của bạn',
            'email.email' => 'Email không đúng định dạng',
            'comment.required' => 'Nhập nội dung bình luận',
            'comment.max' => 'Bình luận tối đa 100 ký tự'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }

        $data = [
            'product_id' => $request->productId,
            'comment_name' => $request->name,
            'comment_email' => $request->email,
            'comment_content' => $request->comment,
            'comment_rating' => $request->rating,
        ];
        $result = $this->comment->addItem($data);
        if ($result == true) {
            return response()->json([
                'success' => 'Bình luận thành công'
            ]);
        }
    }
   
}
