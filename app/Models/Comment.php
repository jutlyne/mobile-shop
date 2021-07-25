<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = "comments";
    protected $primaryKey = "comment_id";
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function addItem($data)
    {
        return $this->insert($data);
    }
    public function getItems($id = '')
    {
        if ($id) {
            return $this->where('product_id', $id)->where('comment_parent', 0)->where('comment_status', 1)->orderBy('comment_id', 'DESC')->paginate(5);
        } else {
            return $this->where('comment_parent', 0)->orderBy('comment_id', 'DESC')->paginate(10);
        }
    }
    public function getItem($id)
    {
        return $this->find($id);
    }
    public function editItem($data, $id)
    {
        return $this->where('comment_id', $id)->update($data);
    }
    public function delItem($id)
    {
        $this->where('comment_parent', $id)->delete();
        return $this->where('comment_id', $id)->delete();
    }
}
