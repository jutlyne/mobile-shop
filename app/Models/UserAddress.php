<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table = "user_addresss";
    protected $primaryKey = "ar_id";
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'post_desc',
        'city',
        'district',
        'ward'
    ];
    public $timestamps = false;

    public function addItem($data)
    {
        return $this->insert($data);
    }
    public function getItem($id)
    {
        return $this->where('user_id', $id)->first();
    }
    public function editItem($data, $id)
    {
        return $this->where('ar_id', $id)->update($data);
    }
}
