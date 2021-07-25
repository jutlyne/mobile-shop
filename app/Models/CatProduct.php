<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatProduct extends Model
{
    use HasFactory;
    protected $table = "cat_products";
    protected $primaryKey = "cat_product_id";
    protected $fillable = [
        'cat_product_name',
        'cat_product_slug',
        'cat_product_desc',
        'cat_product_parent',
    ];
    public $timestamps = false;
    //Relationships
    public function product()
    {
        return $this->hasMany('App\Models\Product', 'cat_product_id');
    }

    public function addItem($data)
    {
        return $this->insert($data);
    }
    public function getItems()
    {
        return $this->all();
    }
    public function getItem($id)
    {
        return $this->find($id);
    }
    public function editItem($data, $id)
    {
        return $this->where('cat_product_id', $id)->update($data);
    }
    public function delItem($id)
    {
        return $this->destroy($id);
    }
}
