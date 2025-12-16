@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 to-blue-100">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo -->
            <div class="text-center">
                <div class="mx-auto w-20 h-20 bg-blue-800 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-2xl">UTE</span>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    Đăng ký tài khoản
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Dành cho sinh viên và giảng viên UTE
                </p>
            </div>

            <!-- Register Form -->
            <div class="bg-white py-8 px-6 shadow-lg rounded-lg">
                <form class="space-y-5" method="POST" action="/register">
                    @csrf

                    <!-- User Code (MSSV/MSGV) -->
                    <div>
                        <label for="user_code" class="block text-sm font-medium text-gray-700">
                            MSSV / MSGV <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="user_code" name="user_code" type="text" required value="{{ old('user_code') }}"
                                class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="VD: SV12345 hoặc GV001">
                        </div>
                        @error('user_code')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Họ và tên <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" required value="{{ old('name') }}"
                                class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nhập họ và tên">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" required value="{{ old('email') }}"
                                class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="email@ute.udn.vn">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Mật khẩu <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required
                                class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Tối thiểu 8 ký tự">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Xác nhận mật khẩu <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nhập lại mật khẩu">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-800 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            Đăng ký
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Đã có tài khoản?
                        <a href="/login" class="font-medium text-blue-600 hover:text-blue-500">
                            Đăng nhập
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection