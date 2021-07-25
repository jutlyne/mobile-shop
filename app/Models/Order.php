<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $primaryKey = "order_id";
    protected $fillable = [
        'order_code',
        'order_qty',
        'order_total',
        'order_name',
        'order_email',
        'order_address',
        'order_phone',
        'order_note',
        'order_payment',
        'order_status',
        'user_id',
    ];

    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetails', 'order_id');
    }
    public function addItem($data)
    {
        return $this->insertGetId($data);
    }
    public function getItems($date_from = null, $date_to = null, $search = null)
    {
        if ($date_from && $date_to) {
            return $this->whereBetween('created_at', [$date_from . ' 00:00:00', $date_to . ' 23:59:59'])->orderBy('order_id', 'DESC')->paginate(10);
        } elseif ($search) {
            return $this->where('order_code', $search)->orWhere('order_email', $search)->orderBy('order_id', 'DESC')->paginate(10);
        }
        return $this->orderBy('order_id', 'DESC')->paginate(10);
    }
    public function getItem($id)
    {
        return $this->find($id);
    }
    public function editItem($data, $id)
    {
        return $this->where('order_id', $id)->update($data);
    }
    public function getOrderById($id)
    {
        return $this->where('user_id', $id)->orderBy('order_id', 'DESC')->paginate(5);
    }
    public function getOrderByOrderId($id)
    {
        return $this->find($id);
    }
}
