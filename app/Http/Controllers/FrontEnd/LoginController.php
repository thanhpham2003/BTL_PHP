<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    public function index()
    {
        return view('frontend.login.login');
    }

    public function show()
    {
        return view('frontend.login.register');
    }

    public function login(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Trả về lỗi nếu validate thất bại
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Đăng nhập người dùng
        if (Auth::guard('frontend')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'success',
                'message' => 'Đăng nhập thành công!',
                'redirect' => route('fr.homepage')
            ]);
        }

        // Sai thông tin đăng nhập
        return response()->json([
            'status' => 'error',
            'message' => 'Email hoặc mật khẩu không chính xác!'
        ], 401);
    }


    public function register(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required', // password_confirmation phải có trong form nếu sử dụng xác nhận mật khẩu
        ]);

        // Trả về lỗi nếu validate thất bại
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Tạo mới người dùng
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0, // Mặc định là 0
        ]);
        session()->flash('success', 'Đăng ký thành công, vui lòng đăng nhập!');
        return redirect()->route('fr.login');
    }

    public function logout(Request $request)
    {
        Auth::guard('frontend')->logout(); // Đăng xuất user của guard 'frontend'

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Chuyển hướng về trang đăng nhập sau khi đăng xuất
    }
}
