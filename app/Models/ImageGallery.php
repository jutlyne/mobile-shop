<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    use HasFactory;
    protected $table = "image_galleries";
    protected $primaryKey = "gallery_id";
    protected $fillable = [
        'gallery_path',
        'product_id'
    ];
    public $timestamps = false;

    public function getItems($id = '')
    {
        if ($id) {
            return $this->where('product_id', $id)->get();
        } else {
            return $this->all();
        }
    }
    public function addItem($data)
    {
        return $this->insert($data);
    }
    public function delItem($id)
    {
        $gallery = $this->find($id)->gallery_path;
        unlink('uploads/gallery/' . $gallery);
        return $this->destroy($id);
    }
    public function delItems($id)
    {
        $galleries = $this->getItems($id);
        foreach ($galleries as $gallery) {
            unlink('uploads/gallery/' . $gallery->gallery_path);
        }
        return $this->where('product_id', $id)->delete();
    }
}
