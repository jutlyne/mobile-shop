<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table = "orders_details";
    protected $primaryKey = "order_details_id";
    protected $fillable = [
        'product_id',
        'order_id',
        'order_product_name',
        'order_product_price',
        'order_product_qty',
    ];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function addItem($data)
    {
        return $this->insert($data);
    }

    public function getItems($id)
    {
    }
}
