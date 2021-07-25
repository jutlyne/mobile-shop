<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    //Đăng ký tài khoản
    public function register()
    {
        return view('auth.auth.register');
    }
    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'same:password',
            'phone' => 'required'
        ], [
            'name.required' => 'Nhập họ tên',
            'email.required' => 'Nhập email',
            'email.unique' => 'Email đã tồn tại trên hệ thống',
            'email.email' => 'Vui lòng nhập địa chỉ email',
            'password.required' => 'Nhập mật khẩu',
            'confirm_password.same' => 'Xác nhận mật khẩu không trùng khớp',
            'phone.required' => 'Nhập số điện thoại liên hệ',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone
        ];
        $result = $this->user->addItem($data);
        if ($result == true) {
            return redirect()->route('auth.auth.login')->with('msg', 'Đăng ký thành công. Đăng nhập để truy cập vào hệ thống');
        }
    }
    //Đăng nhập tài khoản
    public function login()
    {
        return view('auth.auth.login');
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Nhập Password'
        ]);
        $recaptcha_secret = "6LdqWY8aAAAAAD0zDc53XU5PGMWGK9TMfKAol3nC";  //khóa bí mật tùy theo project
        $recaptcha_response = $request->input('g-recaptcha-response');  // token xác thực từ client gửi về

        $veri = curl_init();  //hàm khởi tạo

        $captcha_url = "https://www.google.com/recaptcha/api/siteverify";  //url xác thực của google
        //các câu lệnh set option cho biến xác thực
        curl_setopt($veri,CURLOPT_URL,$captcha_url);
        curl_setopt($veri,CURLOPT_POST,true);
        curl_setopt($veri,CURLOPT_POSTFIELDS,"secret=".$recaptcha_secret."&response=".$recaptcha_response);
        curl_setopt($veri,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($veri,CURLOPT_RETURNTRANSFER,true);

        $recaptcha_output = curl_exec($veri); //thực thi và lấy kết quả

        curl_close($veri); //đóng

        $decode_captcha = json_decode($recaptcha_output);  //dịch ngược json

        $captcha_status = $decode_captcha->success; //lấy giá trị key success

        if ($captcha_status == true) {
          if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
              $user = Auth::user();
              if ($user->status == 2) {
                  Auth::logout();
                  return redirect()->route('auth.auth.login')->with('error', 'Tài khoản của bạn đang tạm khóa! Không thể truy cập lúc này');
              }
              return redirect()->route('esmart.index.index');
          } else {
              return redirect()->route('auth.auth.login')->with('error', 'Tài khoản đăng nhập hoặc mật khẩu không đúng!');
          }
        } else {
          return redirect()->route('auth.auth.login')->with('error', 'Vui lòng vượt qua phần kiểm tra capcha!');
        }
    }
    //Đăng xuất tài khoản
    public function logout()
    {
        Auth::logout();
        return redirect()->route('esmart.index.index');
    }
    //Quên mật khẩu
    public function resetPassword()
    {
        return view('auth.auth.reset-password');
    }
    public function postResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Nhập email đăng ký',
            'email.email' => 'Email không đúng định dạng',
        ]);
        $email = $request->email;
        $checkEmail = User::where('email', $email)->count();
        if ($checkEmail == 1) {
            $codeReset = strtoupper(substr(md5(microtime()), rand(0, 26), 6));
            $result = User::where('email', $email)->update(['reset_code' => $codeReset]);
            if ($result) {
                $data = [
                    'name' => 'Gửi bạn mã xác nhận đặt lại mật khẩu',
                    'body' => $codeReset
                ];
                $to_email = $request->email;
                Mail::send('mail.reset-password', $data, function ($message) use ($to_email) {
                    $message->to($to_email)->subject('Gửi mail mã xác nhận đặt lại mật khẩu');
                    $message->from('vocaoky290999@gmail.com', 'E-Smart');
                });
                $request->session()->put('emailReset', $email);
                return redirect()->route('auth.auth.check-code')->with('msg', 'Nhập mã xác thực để đặt lại mật khẩu');
            }
        } else {
            return redirect()->back()->with('error', 'Email không tồn tại trên hệ thống.');
        }
    }
    public function checkCode()
    {
        if (Session()->get('emailReset')) {
            $emailReset = Session()->get('emailReset');
            return view('auth.auth.check-code', compact('emailReset'));
        } else {
            return redirect()->route('auth.auth.reset-password');
        }
    }
    public function postCheckCode(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ], [
            'code.required' => 'Nhập mã xác thực',
        ]);

        $email = $request->emailReset;
        $infoUser = User::where('email', $email)->first();
        $resetCode = $infoUser->reset_code;
        if ($resetCode == $request->code) {
            $request->session()->put('code', $request->code);
            return redirect()->route('auth.auth.change-password')->with('msg', 'Nhập mật khẩu mới');
        } else {
            return redirect()->route('auth.auth.check-code')->with('error', 'Mã xác thực không đúng');
        }
    }
    public function changePassword()
    {
        if (Session()->get('emailReset') && Session()->get('code')) {
            $emailReset = Session()->get('emailReset');
            $code = Session()->get('code');
            return view('auth.auth.change-password', compact('emailReset', 'code'));
        } else {
            return redirect()->route('auth.auth.login');
        }
    }
    public function postChangePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
            'confirm_password' => 'same:password'
        ], [
            'password.required' => 'Nhập mật khẩu mới',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            'confirm_password.same' => 'Xác nhận mật khẩu không trùng khớp',
        ]);

        $email = $request->email;
        $infoUser = User::where('email', $email)->first();
        $resetCode = $infoUser->reset_code;
        if ($resetCode == $request->code) {
            $password = bcrypt($request->password);
            $result = User::where('email', $email)->update(['password' => $password]);
            if ($result == true) {
                User::where('email', $email)->update(['reset_code' => null]);
                $request->session()->forget('emailReset');
                $request->session()->forget('code');
                return redirect()->route('auth.auth.login')->with('msg', 'Đổi mật khẩu thành công! Đăng nhập lại');
            }
        } else {
            return redirect()->route('auth.auth.check-code')->with('error', 'Mã xác thực không đúng');
        }
    }
}
