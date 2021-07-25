<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
    public function __construct(Order $order, Product $product)
    {
        $this->order = $order;
        $this->product = $product;
    }
    public function list(Request $request)
    {
        if (Auth::user()->role == 3) {
            return redirect()->route('admin.index.index')->with('error', 'Bạn không có quyền thực hiện chức năng này');
        }
        Carbon::setLocale('vi');
        $now = Carbon::now();
        if ($request->date_from && $request->date_to) {
            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $listOrder = $this->order->getItems($date_from, $date_to, null);
            return view('admin.order.list-order', compact('listOrder', 'date_from', 'date_to', 'now'));
        } elseif ($request->search) {
            $search = $request->search;
            $listOrder = $this->order->getItems(null, null, $search);
            return view('admin.order.list-order', compact('listOrder', 'search', 'now'));
        } else {
            $listOrder = $this->order->getItems();
            return view('admin.order.list-order', compact('listOrder', 'now'));
        }
    }
    public function member()
    {
        if (Auth::user()->role == 3) {
            return redirect()->route('admin.index.index')->with('error', 'Bạn không có quyền thực hiện chức năng này');
        }
        return "Danh sách thành viên";
    }
    public function detail($id)
    {
        if (Auth::user()->role == 3) {
            return redirect()->route('admin.index.index')->with('error', 'Bạn không có quyền thực hiện chức năng này');
        }
        $order = $this->order->getItem($id);
        return view('admin.order.order-detail', compact('order'));
    }
    public function postDetail(Request $request, $id)
    {
        if (Auth::user()->role == 3) {
            return redirect()->route('admin.index.index')->with('error', 'Bạn không có quyền thực hiện chức năng này');
        }
        //Thay đổi trạng thái
        $order_status = $request->order_status;
        $data = [
            'order_status' => $order_status
        ];
        $this->order->editItem($data, $id);
        //Cập nhật lại số lượng sản phẩm
        if ($order_status == 3) {
            $infoOrder = $this->order->getItem($id);
            foreach ($infoOrder->orderDetails as $item) {
                $product_id = $item->product_id;
                $infoProduct = $this->product->getItem($product_id);
                if ($infoProduct->count() > 0) {
                    $data = [
                        'product_sold' => $infoProduct->product_sold + $item->order_product_qty
                    ];
                    $this->product->editItem($data, $product_id);
                }
            }
        }
        if ($order_status == 4) {
            $infoOrder = $this->order->getItem($id);
            foreach ($infoOrder->orderDetails as $item) {
                $product_id = $item->product_id;
                $infoProduct = $this->product->getItem($product_id);
                if ($infoProduct->count() > 0) {
                    $data = [
                        'product_qty' => $infoProduct->product_qty + $item->order_product_qty,
                    ];
                    $this->product->editItem($data, $product_id);
                }
            }
        }
        return redirect()->back();
    }
}
