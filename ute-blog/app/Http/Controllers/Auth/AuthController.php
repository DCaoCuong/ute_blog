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

        // Check if user is active
        if ($user->status !== User::STATUS_ACTIVE) {
            throw ValidationException::withMessages([
                'login' => ['Tài khoản của bạn chưa được kích hoạt hoặc đã bị khóa.'],
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
     * Show registration form (for demo purposes)
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'user_code' => 'required|string|unique:users,user_code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'user_code' => $request->input('user_code'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => User::ROLE_MEMBER,
            'status' => User::STATUS_ACTIVE,
        ]);

        Auth::login($user);

        return redirect('/');
    }
}
