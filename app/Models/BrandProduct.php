<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandProduct extends Model
{
    use HasFactory;
    protected $table = "brand_products";
    protected $primaryKey = "brand_id";
    protected $fillable = [
        'brand_name',
        'brand_slug',
        'brand_desc',
    ];
    public $timestamps = false;

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
        return $this->where('brand_id', $id)->update($data);
    }
    public function delItem($id)
    {
        return $this->destroy($id);
    }
}
