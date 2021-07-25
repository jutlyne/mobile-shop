<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminUserController extends Controller
{
    //Hàm khởi tạo
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    //Hàm xử lý
    public function list()
    {
        $users = $this->user->getItems();
        return view('admin.user.list-user', compact('users'));
    }
    public function add()
    {
        return view('admin.user.add-user');
    }
    public function postAdd(Request $request)
    {
        #Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'same:password',
            'phone' => 'required',
            'role' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Nhập họ tên',
            'email.required' => 'Nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trên hệ thống',
            'password.required' => 'Nhập mật khẩu',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'confirm_password.same' => 'Xác nhận mật khẩu không trùng khớp',
            'phone.required' => 'Nhập số điện thoại',
            'role.required' => 'Chọn vai trò user',
            'status.required' => 'Chọn trạng thái hoạt động',
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => $request->status
        ];
        $result = $this->user->addItem($data);
        if ($result == true) {
            return redirect()->route('admin.user.list-user')->with('msg', 'Thêm tài khoản thành công!');
        }
    }
    public function edit($id)
    {
        $infoUser = $this->user->getItem($id);
        if ($infoUser->role == 1) {
            return redirect()->route('admin.index.index');
        }
        if (Auth::user()->id != $id && Auth::user()->role != 1) {
            return redirect()->back()->with('error', 'Bạn không được sửa thông tin của người khác!');
        }
        return view('admin.user.edit-user', compact('infoUser'));
    }
    public function postEdit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Nhập họ tên',
            'phone.required' => 'Nhập số điện thoại',
            'role.required' => 'Chọn vai trò user',
            'status.required' => 'Chọn trạng thái hoạt động',
        ]);
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'role' => $request->role,
            'status' => $request->status
        ];

        if ($request->password) {
            $request->validate([
                'password' => 'min:6',
                'confirm_password' => 'same:password'
            ], [
                'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
                'confirm_password.same' => 'Xác nhận mật khẩu không trùng khớp!'
            ]);
            $data['password'] = bcrypt($request->password);
        }

        $result = $this->user->editItem($data, $id);
        if ($result == true) {
            return redirect()->route('admin.user.list-user')->with('msg', 'Cập nhật tài khoản thành công!');
        }
    }
    public function del($id)
    {
        $user = $this->user->getItem($id);
        if ($user->role == 1) {
            return redirect()->back()->with('error', 'Tài khoản này là bất cả xâm phạm! Không thể xóa');
        }
        $result = $this->user->delItem($id);
        if ($result == true) {
            return redirect()->back()->with('msg', 'Xóa tài khoản thành công!');
        }
    }
}
