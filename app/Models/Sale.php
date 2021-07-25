<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = "sale";
    protected $primaryKey = "id_sale";
    protected $fillable = [
        'name_sale',
        'date_start',
        'date_end',
        'status',
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
    // public function addItem($data)
    // {
    //     return $this->insert($data);
    // }
    public function getItem($id)
    {
        return $this->find($id);
    }

    public function addItemSale($data){
      return $this->insert($data);
    }

    public function removeItem($id)
    {
        return $this->destroy($id);
    }
    public function editItemSale($data, $id)
    {
        return $this->where('id_sale', $id)->update($data);
    }
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
