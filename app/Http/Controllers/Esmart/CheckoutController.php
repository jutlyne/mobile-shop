<?php

namespace App\Http\Controllers\Esmart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct(UserAddress $userAddress, Order $order, OrderDetails $orderDetails, Product $product)
    {
        $this->userAddress = $userAddress;
        $this->order = $order;
        $this->orderDetails = $orderDetails;
        $this->product = $product;
    }

    public function checkout()
    {
        if (Session::get('cart') == false) {
            return redirect()->route('esmart.index.index');
        }
        $infoUser = Auth::user();
        if ($infoUser) {
            $infoAddress = $this->userAddress->getItem($infoUser->id);
            if ($infoAddress) {
                $infoCity = DB::table('devvn_tinhthanhpho')->where('matp', $infoAddress->city)->first()->name;
                $infoDistrict = DB::table('devvn_quanhuyen')->where('maqh', $infoAddress->district)->first()->name;
                $infoWard = DB::table('devvn_xaphuongthitran')->where('xaid', $infoAddress->ward)->first()->name;
                if ($infoAddress->ar_detail) {
                    $addressDetail = $infoCity . ' - ' . $infoDistrict . ' - ' . $infoWard . ' (' . $infoAddress->ar_detail . ')';
                } else {
                    $addressDetail = $infoCity . ' - ' . $infoDistrict . ' - ' . $infoWard;
                }
                return view('esmart.checkout.checkout', compact('infoAddress', 'addressDetail'));
            } else {
                return view('esmart.checkout.checkout');
            }
        }
        return view('esmart.checkout.checkout');
    }
    public function postCheckout(Request $request)
    {
        if (Session::get('cart') == false) {
            return redirect()->route('esmart.index.index');
        }
        #Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required',
            'payment' => 'required'
        ], [
            'name.required' => 'Nhập họ tên',
            'email.required' => 'Nhập email',
            'email.email' => 'Email không đúng định dạng',
            'address.required' => 'Nhập địa chỉ nhận hàng',
            'phone.required' => 'Nhập số điện thoại liên hệ',
            'payment.required' => 'Chọn hình thức thanh toán'
        ]);
        if ($request->payment == 1) {
            #--THANH TOÁN ONLINE--#
            $cart = Session::get('cart');
            $infoShipping = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'payment' => $request->payment,
                'note' => '',
                'total' => $cart['totalPrice']
            ];
            if ($request->note) {
                $infoShipping['note'] = $request->note;
            }
            Session::put('infoShipping', $infoShipping);
            return redirect()->route('esmart.checkout.payment');
        } else {
            #--THANH TOÁN COD--#
            $cart = Session::get('cart');
            $dataOrder = [
                'order_code' => strtoupper(substr(md5(microtime()), rand(0, 26), 5)),
                'order_qty' => $cart['totalQty'],
                'order_total' => $cart['totalPrice'],
                'order_name' => $request->name,
                'order_email' => $request->email,
                'order_address' => $request->address,
                'order_phone' => $request->phone,
                'order_note' => $request->note,
                'order_payment' => $request->payment,
                'order_status' => 1,
            ];
            if (Auth::check()) {
                $dataOrder['user_id'] = Auth::id();
            }
            $order_id = $this->order->addItem($dataOrder);
            foreach ($cart['buy'] as $item) {
                $dataOrderDetail = [
                    'product_id' => $item['infoProduct']['product_id'],
                    'order_id' => $order_id,
                    'order_product_name' => $item['infoProduct']['product_name'],
                    'order_product_price' => $item['infoProduct']['product_price'],
                    'order_product_qty' => $item['qty']
                ];
                $this->orderDetails->addItem($dataOrderDetail);
                $infoProduct = $this->product->getItem($item['infoProduct']['product_id']);
                $product_qty = $infoProduct->product_qty - $item['qty'];
                if ($product_qty < 0) {
                    $product_qty = 0;
                }
                $dataProduct = [
                    'product_qty' => $product_qty,
                ];
                $this->product->editItem($dataProduct, $item['infoProduct']['product_id']);
            }
            if ($order_id) {
                $data = [
                    'dataOrder' => $dataOrder,
                    'name' =>  $request->name,
                    'body' => $cart['buy'],
                    'total' => $cart['totalPrice'],
                ];
                $to_email = $request->email;
                $to_name = $request->name;
                Mail::send('mail.notication-buy', $data, function ($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)->subject('Đặt hàng thành công');
                    $message->from('minhlamtestsendmail@gmail.com', 'E-Smart');
                });
                Session::forget('cart');
                return redirect()->route('esmart.checkout.notification', $dataOrder['order_code']);
            }
        }
    }
    public function payment(Request $request)
    {
        if (Session::get('cart') == false) {
            return redirect()->route('esmart.index.index');
        }
        if (Session::get('infoShipping') == false) {
            return redirect()->route('esmart.index.index');
        }
        $infoShipping = Session::get('infoShipping');

        //****Thực hiện đặt hàng với dữ liệu trả về khi thanh toán thành công bằng vnpay****/
        if ($request->all()) {
            $data = $request->all();
            $vnp_HashSecret = "DTHXNFNBUMNKFKQOZVHTXUXNUQUUXMTV";
            $vnp_SecureHash = $data['vnp_SecureHash'];
            $inputData = array();
            foreach ($data as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }
            unset($inputData['vnp_SecureHashType']);
            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . $key . "=" . $value;
                } else {
                    $hashData = $hashData . $key . "=" . $value;
                    $i = 1;
                }
            }
            $secureHash = hash('sha256', $vnp_HashSecret . $hashData);
            if ($secureHash == $vnp_SecureHash) {
                //--Kiểm tra giao dịch thành công thì thêm sản phẩm vào database--//
                if ($_GET['vnp_ResponseCode'] == '00') {
                    //Lấy dữ liệu đơn hàng
                    $cart = Session::get('cart');
                    $dataOrder = [
                        'order_code' => strtoupper(substr(md5(microtime()), rand(0, 26), 5)),
                        'order_qty' => $cart['totalQty'],
                        'order_total' => $cart['totalPrice'],
                        'order_name' => $infoShipping['name'],
                        'order_email' => $infoShipping['email'],
                        'order_address' => $infoShipping['address'],
                        'order_phone' => $infoShipping['phone'],
                        'order_note' => $infoShipping['note'],
                        'order_payment' => $infoShipping['payment'],
                        'order_status' => 1,
                    ];
                    if (Auth::check()) {
                        $dataOrder['user_id'] = Auth::id();
                    }
                    //Thêm dữ liệu đơn hàng
                    $order_id = $this->order->addItem($dataOrder);
                    //Thêm dữ liệu chi tiết đơn hàng
                    foreach ($cart['buy'] as $item) {
                        $dataOrderDetail = [
                            'product_id' => $item['infoProduct']['product_id'],
                            'order_id' => $order_id,
                            'order_product_name' => $item['infoProduct']['product_name'],
                            'order_product_price' => $item['infoProduct']['product_price'],
                            'order_product_qty' => $item['qty']
                        ];
                        $this->orderDetails->addItem($dataOrderDetail);
                        #Cập nhật lại số lượng sản phẩm
                        $infoProduct = $this->product->getItem($item['infoProduct']['product_id']);
                        $product_qty = $infoProduct->product_qty - $item['qty'];
                        if ($product_qty < 0) {
                            $product_qty = 0;
                        }
                        $dataProduct = [
                            'product_qty' => $product_qty,
                        ];
                        $this->product->editItem($dataProduct, $item['infoProduct']['product_id']);
                    }
                    //Chuyển hướng và thông báo
                    if ($order_id) {
                        #Gửi mail
                        $data = [
                            'dataOrder' => $dataOrder,
                            'name' =>  $infoShipping['name'],
                            'body' => $cart['buy'],
                            'total' => $cart['totalPrice'],
                        ];
                        $to_email = $infoShipping['email'];
                        $to_name = $infoShipping['name'];
                        Mail::send('mail.notication-buy', $data, function ($message) use ($to_name, $to_email) {
                            $message->to($to_email, $to_name)->subject('Đặt hàng thành công');
                            $message->from('minhlamtestsendmail@gmail.com', 'E-Smart');
                        });
                        #Thông báo
                        Session::forget('cart');
                        Session::forget('infoShipping');
                        return redirect()->route('esmart.checkout.notification', $dataOrder['order_code']);
                    }
                } else {
                    echo "GD Khong thanh cong";
                }
            } else {
                echo "Chu ky khong hop le";
            }
        }
        //****Kết thúc thanh toán vnpay****/

        return view('esmart.checkout.payment', compact('infoShipping'));
    }
    public function postPayment(Request $request)
    {
        $data = $request->all();

        $vnp_TmnCode = "Y4U88XFK";
        $vnp_HashSecret = "DTHXNFNBUMNKFKQOZVHTXUXNUQUUXMTV";
        $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('esmart.checkout.payment');

        $vnp_TxnRef = $data['order_id'];
        $vnp_OrderInfo = $data['order_desc'];
        $vnp_OrderType = $data['order_type'];
        $vnp_Amount = $data['amount'] * 100;
        $vnp_Locale = $data['language'];
        $vnp_BankCode = $data['bank_code'];
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if ($returnData['data']) {
            return redirect()->to($returnData['data']);
        }
    }
    public function addOrder(Request $request)
    {
        if (Session::get('cart') == false) {
            return redirect()->route('esmart.index.index');
        }
        $cart = Session::get('cart');
        $dataOrder = [
            'order_code' => strtoupper(substr(md5(microtime()), rand(0, 26), 5)),
            'order_qty' => $cart['totalQty'],
            'order_total' => $cart['totalPrice'],
            'order_name' => $request->name,
            'order_email' => $request->email,
            'order_address' => $request->address,
            'order_phone' => $request->phone,
            'order_note' => $request->note,
            'order_payment' => 1,
            'order_status' => 1,
        ];
        if (Auth::check()) {
            $dataOrder['user_id'] = Auth::id();
        }
        //Thêm dữ liệu đơn hàng
        $order_id = $this->order->addItem($dataOrder);
        //Thêm dữ liệu chi tiết đơn hàng
        foreach ($cart['buy'] as $item) {
            $dataOrderDetail = [
                'product_id' => $item['infoProduct']['product_id'],
                'order_id' => $order_id,
                'order_product_name' => $item['infoProduct']['product_name'],
                'order_product_price' => $item['infoProduct']['product_price'],
                'order_product_qty' => $item['qty']
            ];
            $this->orderDetails->addItem($dataOrderDetail);
            #Cập nhật lại số lượng sản phẩm
            $infoProduct = $this->product->getItem($item['infoProduct']['product_id']);
            $product_qty = $infoProduct->product_qty - $item['qty'];
            if ($product_qty < 0) {
                $product_qty = 0;
            }
            $dataProduct = [
                'product_qty' => $product_qty,
            ];
            $this->product->editItem($dataProduct, $item['infoProduct']['product_id']);
        }
        //Chuyển hướng và thông báo
        if ($order_id) {
            #Gửi mail
            $data = [
                'dataOrder' => $dataOrder,
                'name' =>  $request->name,
                'body' => $cart['buy'],
                'total' => $cart['totalPrice'],
            ];
            $to_email = $request->email;
            $to_name = $request->name;
            Mail::send('mail.notication-buy', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Đặt hàng thành công');
                $message->from('vocaoky290999@gmail.com', 'E-Smart');
            });
            #Thông báo
            Session::forget('cart');
            Session::forget('infoShipping');
            return $dataOrder['order_code'];
        }
    }
    public function notification($code)
    {
        $infoOrder = Order::where('order_code', $code)->first();
        if ($infoOrder) {
            return view('esmart.checkout.notication', compact('infoOrder'));
        } else {
            return redirect()->route('admin.index.index');
        }
    }
}
