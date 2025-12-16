@extends('layouts.app')

@section('title', 'Đăng ký thành công')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-green-50 to-blue-50">
        <div class="max-w-md w-full text-center">
            <!-- Success Icon -->
            <div class="mx-auto w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Message -->
            <div class="bg-white py-8 px-6 shadow-lg rounded-lg">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Đăng ký thành công!
                </h2>

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 text-left">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Chờ phê duyệt:</strong> Tài khoản của bạn đang chờ Admin xác nhận.
                                Bạn sẽ nhận được thông báo qua email khi tài khoản được kích hoạt.
                            </p>
                        </div>
                    </div>
                </div>

                <p class="text-gray-600 mb-6">
                    Cảm ơn bạn đã đăng ký tài khoản tại UTE Blog.
                    Vui lòng đợi Admin phê duyệt trước khi đăng nhập.
                </p>

                <div class="space-y-3">
                    <a href="/"
                        class="block w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-800 hover:bg-blue-700 transition text-center">
                        Về trang chủ
                    </a>
                    <a href="/login"
                        class="block w-full py-3 px-4 border border-blue-800 rounded-lg text-sm font-medium text-blue-800 hover:bg-blue-50 transition text-center">
                        Đến trang đăng nhập
                    </a>
                </div>
            </div>

            <!-- Contact Info -->
            <p class="mt-6 text-sm text-gray-500">
                Có thắc mắc? Liên hệ: <a href="mailto:admin@ute.udn.vn"
                    class="text-blue-600 hover:underline">admin@ute.udn.vn</a>
            </p>
        </div>
    </div>
@endsection