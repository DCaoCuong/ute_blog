@extends('layouts.admin')

@section('title', 'Thêm người dùng')

@section('content')
    <div class="max-w-2xl">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Quay lại danh sách
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Thêm người dùng mới</h2>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                <!-- User Code -->
                <div>
                    <label for="user_code" class="block text-sm font-medium text-gray-700 mb-1">
                        MSSV / MSGV <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="user_code" name="user_code" value="{{ old('user_code') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="VD: SV12345 hoặc GV001">
                    @error('user_code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Họ và tên <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Nhập họ và tên">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="email@ute.udn.vn">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Mật khẩu <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tối thiểu 8 ký tự">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                        Vai trò <span class="text-red-500">*</span>
                    </label>
                    <select id="role" name="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member (Sinh viên/Giảng viên)
                        </option>
                        <option value="content_manager" {{ old('role') == 'content_manager' ? 'selected' : '' }}>Content
                            Manager</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Trạng thái <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Đã khóa</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex space-x-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Tạo người dùng
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection