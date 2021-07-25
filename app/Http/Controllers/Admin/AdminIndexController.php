<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class AdminIndexController extends Controller
{
    public function index()
    {
        Carbon::setLocale('vi');
        $now = Carbon::now();
        $orderSuccess = Order::where('order_status', 3)->count();
        $orderNew = Order::where('order_status', 1)->count();
        $orderCancel = Order::where('order_status', 4)->count();

        $infoOrderSuccess = Order::where('order_status', 3)->get();
        $totalOrderSuccess = 0;
        foreach ($infoOrderSuccess as $item) {
            $totalOrderSuccess += $item->order_total;
        }

        $listOrder = Order::where('order_status', 1)->orderBy('order_id', 'DESC')->paginate(10);
        return view('admin.index.index', compact('listOrder', 'now', 'orderSuccess', 'orderNew', 'orderCancel', 'totalOrderSuccess'));
    }
}
