<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     * Supports login with email or user_code (MSSV/MSGV)
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = $request->input('login');
        $password = $request->input('password');

        // Determine if login is email or user_code
        $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_code';

        // Find user
        $user = User::where($fieldType, $loginField)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Thông tin đăng nhập không chính xác.'],
            ]);
        }

        // Check user status
        if ($user->status === User::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'login' => ['Tài khoản của bạn đang chờ Admin phê duyệt. Vui lòng đợi hoặc liên hệ quản trị viên.'],
            ]);
        }

        if ($user->status === User::STATUS_INACTIVE) {
            throw ValidationException::withMessages([
                'login' => ['Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.'],
            ]);
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // Redirect based on role
        if ($user->isAdmin() || $user->isContentManager()) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     * New users will have 'pending' status and require admin approval
     */
    public function register(Request $request)
    {
        $request->validate([
            'user_code' => 'required|string|unique:users,user_code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'user_code.required' => 'Vui lòng nhập MSSV hoặc MSGV.',
            'user_code.unique' => 'MSSV/MSGV này đã được đăng ký.',
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được đăng ký.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // Create user with PENDING status - requires admin approval
        $user = User::create([
            'user_code' => strtoupper(trim($request->input('user_code'))),
            'name' => $request->input('name'),
            'email' => strtolower(trim($request->input('email'))),
            'password' => $request->input('password'),
            'role' => User::ROLE_MEMBER,
            'status' => User::STATUS_PENDING, // Requires admin approval
        ]);

        // Redirect to registration success page (not logged in yet)
        return redirect()->route('register.success');
    }

    /**
     * Show registration success page
     */
    public function registerSuccess()
    {
        return view('auth.register-success');
    }
}
