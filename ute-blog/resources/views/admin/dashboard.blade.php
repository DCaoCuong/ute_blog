@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Tổng người dùng</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Users -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Chờ duyệt</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Đang hoạt động</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['active_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Posts -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Tổng bài viết</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total_posts'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Users Section -->
    @if($stats['pending_users'] > 0)
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">
                    🔔 Người dùng chờ duyệt ({{ $stats['pending_users'] }})
                </h2>
                <a href="{{ route('admin.users.index', ['status' => 'pending']) }}"
                    class="text-blue-600 hover:text-blue-800 text-sm">
                    Xem tất cả →
                </a>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($pendingUsers as $user)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $user->user_code }} • {{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <form method="POST" action="{{ route('admin.users.approve', $user->_id) }}">
                                @csrf
                                <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                                    Duyệt
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.reject', $user->_id) }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                                    Từ chối
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.users.create') }}"
            class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition flex items-center">
            <div class="p-3 bg-blue-600 rounded-lg text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-800">Thêm người dùng</p>
                <p class="text-sm text-gray-500">Tạo tài khoản mới</p>
            </div>
        </a>

        <a href="#" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition flex items-center opacity-50">
            <div class="p-3 bg-green-600 rounded-lg text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-800">Viết bài mới</p>
                <p class="text-sm text-gray-500">Sắp có</p>
            </div>
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition flex items-center">
            <div class="p-3 bg-purple-600 rounded-lg text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                    </path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="font-medium text-gray-800">Quản lý users</p>
                <p class="text-sm text-gray-500">Xem danh sách</p>
            </div>
        </a>
    </div>
@endsection