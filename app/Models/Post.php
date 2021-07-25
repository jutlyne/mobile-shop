<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "posts";
    protected $primaryKey = "post_id";
    protected $fillable = [
        'cat_post_id',
        'post_name',
        'post_slug',
        'post_desc',
        'post_content',
        'post_image',
        'post_views',
        'post_status'
    ];

    //Relationships
    public function catPost()
    {
        return $this->belongsTo('App\Models\CatPost', 'cat_post_id');
    }

    //Xử lý Admin
    public function getItems($cat = '')
    {
        if ($cat != '') {
            return $this->where('cat_post_id', $cat)->orderBy('post_id', 'DESC')->paginate(10);
        }
        return $this->orderBy('post_id', 'DESC')->paginate(10);
    }
    public function addItem($data)
    {
        return $this->insert($data);
    }
    public function getItem($id)
    {
        return $this->find($id);
    }
    public function editItem($data, $id)
    {
        return $this->where('post_id', $id)->update($data);
    }
    public function delItem($id)
    {
        $post_image = $this->getItem($id)->post_image;
        unlink('uploads/post/' . $post_image);
        return $this->destroy($id);
    }
    //Xử lý Public
    public function getPostAll()
    {
        return $this->where('post_status', 1)->orderBy('post_id', 'DESC')->paginate(6);
    }
    public function getPostCat($id)
    {
        return $this->where('post_status', 1)->where('cat_post_id', $id)->orderBy('post_id', 'DESC')->paginate(6);
    }
}
