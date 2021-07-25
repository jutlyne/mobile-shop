<?php

namespace App\Http\Controllers\Esmart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function __construct(Cart $cart, Product $product)
    {
        $this->cart = $cart;
        $this->product = $product;
    }
    public function addCart($id)
    {
        $infoProduct = $this->product->getItem($id);
        $giamgia = 0;
        $sale = $this->product->getSaleItem($id);

        if(count($sale) == 1){
          foreach ($sale as $s) {
            $giamgia = $s->discount;
          }
        }
        $data = [
            'product_id' => $infoProduct->product_id,
            'product_name' => $infoProduct->product_name,
            'product_qty' => $infoProduct->product_qty,
            'product_price' => $infoProduct->product_price - $infoProduct->product_price * $giamgia / 100,
            'product_image' => $infoProduct->product_image,
        ];
        $this->cart->add($id, $data);
    }
    public function addCartDetail(Request $request)
    {
        $id = $request->product_id;
        $num_order = $request->num_order;
        $infoProduct = $this->product->getItem($id);
        $giamgia = 0;
        $sale = $this->product->getSaleItem($id);
        if(count($sale) == 1){
          foreach ($sale as $s) {
            $giamgia = $s->discount;
          }
        }
        $data = [
            'product_id' => $infoProduct->product_id,
            'product_name' => $infoProduct->product_name,
            'product_qty' => $infoProduct->product_qty,
            'product_price' => $infoProduct->product_price - $infoProduct->product_price * $giamgia / 100,
            'product_image' => $infoProduct->product_image,
        ];
        $this->cart->addCart($id, $data, $num_order);
    }
    public function showCart()
    {
        return view('esmart.cart.cart');
    }
    public function showAllCart()
    {
        return view('esmart.cart.show-cart');
    }
    public function editCart(Request $request)
    {
        $id = $request->product_id;
        $quantity = $request->quantity;
        $infoProduct = $this->product->getItem($id);
        $giamgia = 0;
        $sale = $this->product->getSaleItem($id);
        if(count($sale) == 1){
          foreach ($sale as $s) {
            $giamgia = $s->discount;
          }
        }
        $data = [
            'product_id' => $infoProduct->product_id,
            'product_name' => $infoProduct->product_name,
            'product_qty' => $infoProduct->product_qty,
            'product_price' => $infoProduct->product_price - $infoProduct->product_price * $giamgia / 100,
            'product_image' => $infoProduct->product_image,
        ];
        $this->cart->edit($id, $data, $quantity);
        $cart = Session::get('cart');
        return response()->json([
            'subTotal' => number_format($cart['buy'][$id]['infoProduct']['product_price'] * $cart['buy'][$id]['qty'], '0', ',', '.') . 'đ',
            'totalPrice' => number_format($cart['totalPrice'], '0', ',', '.') . ' vnđ',
        ]);
    }
    public function delItemCart(Request $request)
    {
        $id = $request->product_id;
        $this->cart->delItem($id);
        $cart = Session::get('cart');
        if (empty($cart['buy'])) {
            Session::forget('cart');
        }
    }
    public function delCart()
    {
        $this->cart->del();
        return redirect()->route('esmart.index.index');
    }
}
