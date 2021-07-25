<?php

namespace App\Http\Controllers\Esmart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CatPost;
use Carbon\Carbon;

class PostController extends Controller
{
    public function __construct(Post $post, CatPost $catPost)
    {
        $this->post = $post;
        $this->catPost = $catPost;
    }
    public function index()
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();
        $postAll = $this->post->getPostAll();
        return view('esmart.post.index', compact('postAll', 'now'));
    }
    public function cat($slug, $id)
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();
        $infoCat = $this->catPost->getItem($id);
        $postCat = $this->post->getPostCat($id);
        return view('esmart.post.cat', compact('postCat', 'infoCat', 'now'));
    }
    public function detail($slug, $id)
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();
        $infoPost = $this->post->getItem($id);
        //Cập nhật lượt xem
        $this->post->editItem(['post_views' => $infoPost->post_views + 1], $id);
        return view('esmart.post.detail', compact('infoPost', 'now'));
    }
}
