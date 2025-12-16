<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UTE Blog') - Trường Đại học Sư phạm Kỹ thuật</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-800 to-blue-600 text-white shadow-lg">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                        <span class="text-blue-800 font-bold text-xl">UTE</span>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">Trường ĐH Sư phạm Kỹ thuật</h1>
                        <p class="text-blue-200 text-sm">Đại học Đà Nẵng</p>
                    </div>
                </a>

                <!-- Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="hover:text-blue-200 transition">Trang chủ</a>
                    <a href="/gioi-thieu" class="hover:text-blue-200 transition">Giới thiệu</a>
                    <a href="/tin-tuc" class="hover:text-blue-200 transition">Tin tức</a>
                    <a href="/su-kien" class="hover:text-blue-200 transition">Sự kiện</a>
                    <a href="/khoa-phong" class="hover:text-blue-200 transition">Khoa - Phòng</a>

                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-2 hover:text-blue-200">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                @if(Auth::user()->isAdmin() || Auth::user()->isContentManager())
                                    <a href="/admin" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Quản trị</a>
                                @endif
                                <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Tài khoản</a>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login"
                            class="bg-white text-blue-800 px-4 py-2 rounded-lg font-medium hover:bg-blue-50 transition">
                            Đăng nhập
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button class="md:hidden" x-data @click="$dispatch('toggle-mobile-menu')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-bold text-lg mb-4">Trường ĐH Sư phạm Kỹ thuật</h3>
                    <p class="text-gray-400">Đại học Đà Nẵng</p>
                    <p class="text-gray-400 mt-2">Địa chỉ: 48 Cao Thắng, Đà Nẵng</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4">Liên hệ</h3>
                    <p class="text-gray-400">Email: contact@ute.udn.vn</p>
                    <p class="text-gray-400">Điện thoại: (0236) 3894 xxx</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-4">Kết nối</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white">YouTube</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} UTE Blog. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>