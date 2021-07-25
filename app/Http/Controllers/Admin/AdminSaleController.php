<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;


class AdminSaleController extends Controller
{
    //Hàm khởi tạo
    public function __construct(Sale $sale, Product $product, SaleDetail $detail)
    {
        $this->sale = $sale;
        $this->product = $product;
        $this->detail  = $detail;
    }
    //Hàm xử lý
    public function index()
    {
        $sale = $this->sale->getItems();
        return view('admin.sale.list-sale', compact('sale'));
    }

    //Lay info
    // public function info($id)
    // {
    //   $sale = $this->sale->getItems();
    //   $product = $this->product->getAll();
    //   $infoproduct = $this->product->getItem($id);
    //   return
    //   //return view('admin.sale.add-sale', compact('infoproduct','product'));
    // }

    //Thêm
    public function add()
    {
        $sale = $this->sale->getItems();
        $product = $this->product->getAll();

        return view('admin.sale.add-sale', compact('product'));
    }

    //show san pham
    public function show()
    {

    }
    //Them san pham
    public function addItem(Request $rq, $id){
      $sid = $rq->sid;
      $soluong = $rq->soluong;
      $name = $rq->ten;
      $data = [
          'id_sale' => $sid,
          'name_product' => $name,
          'id_product_sale' => $id,
          'soluong_sale' => $soluong,
          'soluong_sale_thuc' => 0,
      ];
      $result = $this->detail->addItemSale($data);
      return response()->json(array('sucid' => $result));
    }

    //Xoa san pham
    public function removeItem($id){
      $result = $this->detail->removeItem($id);
      return response()->json(array('success' => 'thanhcong'));
    }

    //Sua
    public function edit($id)
    {
      $infoSale = $this->sale->getItem($id);
      $product = $this->product->getAll();
      $detail = $this->detail->show($id);
      return view('admin.sale.edit-sale', compact('infoSale', 'product', 'detail'));
    }

    public function postEdit(Request $request, $id)
    {
        $request->validate([
            'sale_name' => 'required',
            'sale_discount' => 'required',
            'sale_start' => 'required',
            'sale_end' => 'required',
        ], [
            'sale_name.required' => 'Nhập tên',
            'sale_discount.required' => 'Nhập giảm giá',
            'sale_start.required' => 'Nhập ngày bắt đầu',
            'sale_end.required' => 'Nhập ngày kết thúc',
        ]);
        $data = [
            'name_sale' => $request->sale_name,
            'discount' => $request->sale_discount,
            'date_start' => $request->sale_start,
            'date_end' => $request->sale_end
        ];

        $result = $this->sale->editItemSale($data, $id);
        if ($result == true) {
            return redirect()->route('admin.sale.list-sale')->with('msg', 'Cập nhật thành công!');
        }
    }
}
