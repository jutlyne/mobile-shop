<?php

namespace App\Http\Controllers\Esmart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\UserAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(User $user, UserAddress $userAddress, Order $order, OrderDetails $orderDetail)
    {
        $this->user = $user;
        $this->userAddress = $userAddress;
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }
    public function profile()
    {
        return view('esmart.user.profile');
    }
    public function postProfile(Request $request)
    {
        #Validation
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Nhập họ tên',
            'phone.required' => 'Nhập số điện thoại',
        ]);

        $data = [
            'name' => $request->name,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'phone' => $request->phone,
        ];
        $this->user->editItem($data, $request->id);
        return redirect()->back()->with('msg', 'Lưu thông tin thành công!');
    }
    public function address()
    {
        $user_id = Auth::id();
        $user_address = $this->userAddress->getItem($user_id);
        if ($user_address) {
            $citys = DB::table('devvn_tinhthanhpho')->get();
            $districts = DB::table('devvn_quanhuyen')->where('matp', $user_address->city)->get();
            $wards = DB::table('devvn_xaphuongthitran')->where('xaid', $user_address->ward)->get();
            return view('esmart.user.address', compact('citys', 'user_address', 'districts', 'wards'));
        } else {
            $citys = DB::table('devvn_tinhthanhpho')->get();
            return view('esmart.user.address', compact('citys'));
        }
    }
    public function postAddress(Request $request)
    {
        #Validation
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'district' => 'required',
            'ward' => 'required',
        ], [
            'name.required' => 'Nhập họ tên',
            'phone.required' => 'Nhập số điện thoại',
            'city.required' => 'Chọn tỉnh/thành phố',
            'district.required' => 'Chọn quận/huyện',
            'ward.required' => 'Chọn xã/phường',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'city' => $request->city,
            'district' => $request->district,
            'ward' => $request->ward,
            'ar_detail' => $request->address_detail,
            'user_id' => $request->user_id
        ];

        $checkAddress = $this->userAddress->getItem($request->user_id);
        if ($checkAddress) {
            $ar_id = $checkAddress->ar_id;
            $this->userAddress->editItem($data, $ar_id);
            return redirect()->back()->with('msg', 'Lưu thông tin thành công');
        } else {
            $result = $this->userAddress->addItem($data);
            if ($result == true) {
                return redirect()->back()->with('msg', 'Lưu thông tin thành công');
            }
        }
    }
    public function password()
    {
        return view('esmart.user.password');
    }
    public function postPassword(Request $request)
    {
        #Validation
        $request->validate([
            'password_old' => 'required',
            'password_new' => 'required|min:6',
            'confirm_password' => 'required|same:password_new',
        ], [
            'password_old.required' => 'Nhập mật khẩu cũ',
            'password_new.required' => 'Nhập mật khẩu mới',
            'password_new.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'confirm_password.required' => 'Nhập lại mật khẩu mới',
            'confirm_password.same' => 'Xác nhận mật khẩu không trùng khớp'
        ]);

        if (Hash::check($request->password_old, Auth::user()->password)) {
            $data = [
                'password' => bcrypt($request->password_new)
            ];
            $result = $this->user->editItem($data, Auth::id());
            if ($result == true) {
                Auth::logout();
                return redirect()->route('auth.auth.login')->with('msg', 'Thay đổi mật khẩu thành công!Đăng nhập lại');
            }
        } else {
            return redirect()->back()->with('error', 'Mật khẩu cũ không đúng!');
        }
    }

    public function getDistrict(Request $request)
    {
        $matp = $request->matp;
        $districts = DB::table('devvn_quanhuyen')->where('matp', $matp)->get();
        echo "<option value=''>Chọn Tỉnh/Thành phố</option>";
        foreach ($districts as $district) {
            echo "<option value='$district->maqh'>$district->name</option>";
        }
    }
    public function getWard(Request $request)
    {
        $maqh = $request->maqh;
        $wards = DB::table('devvn_xaphuongthitran')->where('maqh', $maqh)->get();
        echo "<option value=''>Chọn Xã/Phường</option>";
        foreach ($wards as $ward) {
            echo "<option value='$ward->xaid'>$ward->name</option>";
        }
    }
    public function viewOrder()
    {
        $id = Auth::id();
        $infoOrder = $this->order->getOrderById($id);
        return view('esmart.user.vieworder', compact('infoOrder'));
    }
    public function viewOrderDetail($id)
    {
        $infoOrderByOrderId = $this->order->getOrderByOrderId($id);
        return view('esmart.user.vieworderdetail', compact('infoOrderByOrderId'));
    }
    public function cancelOrder(Request $request)
    {
        $order_id = $request->order_id;
        $result = $this->order->editItem(['order_status' => 4], $order_id);
        if ($result == true) {
            return "Hủy đơn hàng thành công";
        }
    }
    public function successOrder(Request $request)
    {
        $order_id = $request->order_id;
        $result = $this->order->editItem(['order_status' => 3], $order_id);
        if ($result == true) {
            return "Đã nhận hàng";
        }
    }
}
