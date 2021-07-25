<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CatPost;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminCatPostController extends Controller
{
    public function __construct(CatPost $catPost, Post $post)
    {
        $this->catPost = $catPost;
        $this->post = $post;
    }
    public function index()
    {
        $catPosts = $this->catPost->getItems();
        return view('admin.cat-post.index', compact('catPosts'));
    }
    public function postAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_post_name' => 'required',
            'cat_post_desc' => 'required|min:10',
        ], [
            'cat_post_name.required' => 'Nhập tên danh mục',
            'cat_post_desc.required' => 'Nhập mô tả danh mục',
            'cat_post_desc.min' => 'Mô tả tối thiểu 10 ký tự',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $data = [
            'cat_post_name' => $request->cat_post_name,
            'cat_post_slug' => Str::slug($request->cat_post_name),
            'cat_post_desc' => $request->cat_post_desc,
        ];
        $result = $this->catPost->addItem($data);
        if ($result == true) {
            return response()->json([
                'success' => 'Thêm danh mục tin thành công!',
            ]);
        }
    }
    public function edit(Request $request)
    {
        $cat_post_id = $request->cat_post_id;
        $catPost = $this->catPost->getItem($cat_post_id);
        return response()->json([
            'cat_post_id' => $catPost->cat_post_id,
            'cat_post_name' => $catPost->cat_post_name,
            'cat_post_desc' => $catPost->cat_post_desc
        ]);
    }
    public function postEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cat_post_name' => 'required',
            'cat_post_desc' => 'required|min:10',
        ], [
            'cat_post_name.required' => 'Nhập tên danh mục',
            'cat_post_desc.required' => 'Nhập mô tả danh mục',
            'cat_post_desc.min' => 'Mô tả tối thiểu 10 ký tự',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
            ]);
        }
        $data = [
            'cat_post_name' => $request->cat_post_name,
            'cat_post_slug' => Str::slug($request->cat_post_name),
            'cat_post_desc' => $request->cat_post_desc,
        ];
        $result = $this->catPost->editItem($data, $request->cat_post_id);
        if ($result == true) {
            return response()->json([
                'success' => 'Cập nhật danh mục tin thành công!',
            ]);
        } else {
            return response()->json([
                'success' => 'Không sửa gì hết mà cũng cập nhật hehe!',
            ]);
        }
    }
    public function del(Request $request)
    {
        $cat_post_id = $request->cat_post_id;
        $checkPost = $this->post->getItems($cat_post_id);
        if ($checkPost->count() > 0) {
            return response()->json([
                'error' => 'Vui lòng xóa bài viết thuộc danh mục trước!'
            ]);
        }

        $result = $this->catPost->delItem($cat_post_id);
        if ($result == true) {
            return response()->json([
                'success' => 'Xóa danh mục tin thành công!'
            ]);
        }
    }
}
