<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    protected $table = "sale_detail";
    protected $primaryKey = "id_sale_detail";
    protected $fillable = [
        'id_sale',
        'id_product_sale',
        'soluong_sale',
        'soluong_sale_thuc',
    ];

    // //Relationships
    // public function catPost()
    // {
    //     return $this->belongsTo('App\Models\CatPost', 'cat_post_id');
    // }
    //
    //Xử lý Admin
    public function getItems()
    {
        return $this->orderBy('date_start', 'DESC')->paginate(10);
    }

    public function show($id)
    {
      return $this->where('id_sale', $id)->get();
    }
    // public function addItem($data)
    // {
    //     return $this->insert($data);
    // }
    public function getItem($id)
    {
        return $this->find($id);
    }

    public function addItemSale($data){
      return $this->insertGetId($data);
    }

    public function removeItem($id){
      return $this->destroy($id);
    }
    // public function editItem($data, $id)
    // {
    //     return $this->where('post_id', $id)->update($data);
    // }
    // public function delItem($id)
    // {
    //     $post_image = $this->getItem($id)->post_image;
    //     unlink('uploads/post/' . $post_image);
    //     return $this->destroy($id);
    // }
    // //Xử lý Public
    // public function getPostAll()
    // {
    //     return $this->where('post_status', 1)->orderBy('post_id', 'DESC')->paginate(6);
    // }
    // public function getPostCat($id)
    // {
    //     return $this->where('post_status', 1)->where('cat_post_id', $id)->orderBy('post_id', 'DESC')->paginate(6);
    // }
}
