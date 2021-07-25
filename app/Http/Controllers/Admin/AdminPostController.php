<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdminPostController extends Controller
{
    public function __construct(CatPost $catPost, Post $post)
    {
        $this->catPost = $catPost;
        $this->post = $post;
    }
    //Danh sách
    public function list(Request $request)
    {
        $cat_posts = $this->catPost->getItems();
        $cat_post_id = '';
        if ($request->cat) {
            $cat_post_id = (int)$request->cat;
        }
        $posts = $this->post->getItems($cat_post_id);
        return view('admin.post.list-post', compact('posts', 'cat_posts', 'cat_post_id'));
    }
    //Thêm
    public function add()
    {
        $cat_posts = $this->catPost->getItems();
        return view('admin.post.add-post', compact('cat_posts'));
    }
    public function postAdd(Request $request)
    {
        #Validation
        $request->validate([
            'post_name' => 'required',
            'cat_post_id' => 'required',
            'post_image' => 'required|image',
            'post_desc' => 'required',
            'post_content' => 'required'
        ], [
            'post_name.required' => 'Nhập tên tin tức',
            'cat_post_id.required' => 'Chọn danh mục tin tức',
            'post_image.required' => 'Chọn ảnh upload',
            'post_image.image' => 'Chọn hình ảnh (jpeg, png, bmp, gif, svg hoặc webp)',
            'post_desc.required' => 'Nhập mô tả tin tức',
            'post_content.required' => 'Nhập nội dung tin tức'
        ]);
        #Insert DB
        $data = [
            'post_name' => $request->post_name,
            'post_slug' => Str::slug($request->post_name),
            'cat_post_id' => $request->cat_post_id,
            'post_desc' => $request->post_desc,
            'post_content' => $request->post_content,
            'post_status' => $request->post_status,
        ];
        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $imageName = "image-post-" . time() . '.' . $image->extension();
            $resizeImage = Image::make($image->getRealPath());
            $resizeImage->resize(480, 320);
            $resizeImage->save(public_path('uploads/post/' . $imageName));
            $data['post_image'] = $imageName;
        }
        $result = $this->post->addItem($data);

        if ($result == true) {
            return redirect()->route('admin.post.list-post')->with('msg', 'Thêm tin thành công!');
        }
    }
    //Sửa
    public function edit($id)
    {
        $infoPost = $this->post->getItem($id);
        $cat_posts = $this->catPost->getItems();
        return view('admin.post.edit-post', compact('infoPost', 'cat_posts'));
    }
    public function postEdit(Request $request, $id)
    {
        #Validation
        $request->validate([
            'post_name' => 'required',
            'cat_post_id' => 'required',
            'post_image' => 'image',
            'post_desc' => 'required',
            'post_content' => 'required'
        ], [
            'post_name.required' => 'Nhập tên tin tức',
            'cat_post_id.required' => 'Chọn danh mục tin tức',
            'post_image.image' => 'Chọn hình ảnh (jpeg, png, bmp, gif, svg hoặc webp)',
            'post_desc.required' => 'Nhập mô tả tin tức',
            'post_content.required' => 'Nhập nội dung tin tức'
        ]);
        #Insert DB
        $data = [
            'post_name' => $request->post_name,
            'post_slug' => Str::slug($request->post_name),
            'cat_post_id' => $request->cat_post_id,
            'post_desc' => $request->post_desc,
            'post_content' => $request->post_content,
            'post_status' => $request->post_status,
        ];
        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $imageName = "image-post-" . time() . '.' . $image->extension();
            $resizeImage = Image::make($image->getRealPath());
            $resizeImage->resize(480, 320);
            $resizeImage->save(public_path('uploads/post/' . $imageName));
            unlink('uploads/post/' . $request->post_image_old);
            $data['post_image'] = $imageName;
        }
        $this->post->editItem($data, $id);
        return redirect()->route('admin.post.list-post')->with('msg', 'Cập nhật tin tức thành công!');
    }
    //Xóa
    public function del($id)
    {
        $this->post->delItem($id);
        return redirect()->back()->with('msg', 'Xóa tin thành công!');
    }
    //Thay đổi trạng thái bài viết
    public function changeStatusPost(Request $request)
    {
        $post_status = $this->post->getItem($request->post_id)->post_status;
        if ($post_status == 1) {
            $this->post->editItem(['post_status' => 2], $request->post_id);
            return response()->json([
                'icon' => ' <small class="badge badge-gradient-danger">
                            <i class="mdi mdi-window-close"></i>
                        </small>'
            ]);
        } else {
            $this->post->editItem(['post_status' => 1], $request->post_id);
            return response()->json([
                'icon' => ' <small class="badge badge-gradient-success">
                            <i class="mdi mdi-check"></i>
                        </small>'
            ]);
        }
    }
}
