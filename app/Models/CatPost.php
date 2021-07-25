<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatPost extends Model
{
    use HasFactory;
    protected $table = "cat_posts";
    protected $primaryKey = "cat_post_id";
    protected $fillable = [
        'cat_post_name',
        'cat_post_slug',
        'cat_post_desc'
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
        return $this->where('cat_post_id', $id)->update($data);
    }
    public function delItem($id)
    {
        return $this->destroy($id);
    }
}
