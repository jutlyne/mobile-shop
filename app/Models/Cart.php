<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;

class Cart
{
    public function add($id, $data, $quantity = 1)
    {
        $cart = Session::get('cart');
        //Thêm sản phẩm vào giỏ hàng
        if (isset($cart['buy'][$id])) {
            $cart['buy'][$id] = array(
                'infoProduct' => $data,
                'qty' => $cart['buy'][$id]['qty'] + $quantity,
            );
        } else {
            $cart['buy'][$id] = array(
                'infoProduct' => $data,
                'qty' => $quantity,
            );
        }
        if ($cart['buy'][$id]['qty'] > $data['product_qty']) {
            $cart['buy'][$id]['qty'] = $data['product_qty'];
        }
        //Tính tổng quan đơn hàng
        $cart['totalPrice'] = 0;
        $cart['totalQty'] = 0;
        foreach ($cart['buy'] as $item) {
            $cart['totalPrice'] += $item['infoProduct']['product_price'] * $item['qty'];
            $cart['totalQty'] += $item['qty'];
        }
        //Cập nhật lại giỏ hàng
        Session::put('cart', $cart);
    }
    public function addCart($id, $data, $numOrder)
    {
        $cart = Session::get('cart');
        //Thêm sản phẩm vào giỏ hàng
        $cart['buy'][$id] = array(
            'infoProduct' => $data,
            'qty' => $numOrder,
        );
        if ($cart['buy'][$id]['qty'] > $data['product_qty']) {
            $cart['buy'][$id]['qty'] = $data['product_qty'];
        }
        //Tính tổng quan đơn hàng
        $cart['totalPrice'] = 0;
        $cart['totalQty'] = 0;
        foreach ($cart['buy'] as $item) {
            $cart['totalPrice'] += $item['infoProduct']['product_price'] * $item['qty'];
            $cart['totalQty'] += $item['qty'];
        }
        //Cập nhật lại giỏ hàng
        Session::put('cart', $cart);
    }
    public function edit($id, $data, $quantity)
    {
        $cart = Session::get('cart');
        //Thêm sản phẩm vào giỏ hàng
        $cart['buy'][$id] = array(
            'infoProduct' => $data,
            'qty' => $quantity,
        );
        if ($cart['buy'][$id]['qty'] > $data['product_qty']) {
            $cart['buy'][$id]['qty'] = $data['product_qty'];
        }
        //Tính tổng quan đơn hàng
        $cart['totalPrice'] = 0;
        $cart['totalQty'] = 0;
        foreach ($cart['buy'] as $item) {
            $cart['totalPrice'] += $item['infoProduct']['product_price'] * $item['qty'];
            $cart['totalQty'] += $item['qty'];
        }
        //Cập nhật lại giỏ hàng
        Session::put('cart', $cart);
    }
    public function delItem($id)
    {
        $cart = Session::get('cart');
        //Xóa sản phẩm ra khỏi cart
        unset($cart['buy'][$id]);
        //Tính tổng quan đơn hàng
        $cart['totalPrice'] = 0;
        $cart['totalQty'] = 0;
        foreach ($cart['buy'] as $item) {
            $cart['totalPrice'] += $item['infoProduct']['product_price'] * $item['qty'];
            $cart['totalQty'] += $item['qty'];
        }
        //Cập nhật lại giỏ hàng
        Session::put('cart', $cart);
    }
    public function del()
    {
        return Session::forget('cart');
    }
}
