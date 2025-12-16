<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UTE Blog') - Trường Đại học Sư phạm Kỹ thuật</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts - Inter for modern, clean look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom styles -->
    <style>
        /* Apply Inter font globally */
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        /* Improve text rendering */
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }

        /* Enhanced typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Smooth transitions */
        a,
        button {
            transition: all 0.2s ease-in-out;
        }

        /* Hide elements with x-cloak */
        [x-cloak] {
            display: none !important;
        }

        /* Custom prose styles for content */
        .prose {
            line-height: 1.75;
        }

        .prose p {
            margin-bottom: 1.25em;
        }

        .prose h2 {
            margin-top: 2em;
            margin-bottom: 1em;
        }

        /* Line clamp utilities */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
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

                <!-- Search Box with Autocomplete -->
                <div class="hidden md:block flex-1 max-w-md mx-6" x-data="searchAutocomplete()">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <input type="text" name="q" x-model="query" @input.debounce.300ms="fetchSuggestions"
                            @focus="showSuggestions = true" @keydown.escape="showSuggestions = false"
                            placeholder="Tìm kiếm..."
                            class="w-full px-4 py-2 pr-10 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>

                        <!-- Autocomplete Dropdown -->
                        <div x-show="showSuggestions && suggestions.length > 0" @click.away="showSuggestions = false"
                            x-cloak
                            class="absolute top-full left-0 right-0 mt-2 bg-white rounded-lg shadow-lg py-2 z-50 max-h-96 overflow-y-auto">
                            <template x-for="suggestion in suggestions" :key="suggestion.url">
                                <a :href="suggestion.url" class="block px-4 py-2 hover:bg-gray-100 text-gray-800">
                                    <div class="font-medium" x-text="suggestion.title"></div>
                                    <div class="text-xs text-gray-500" x-text="suggestion.type"></div>
                                </a>
                            </template>
                        </div>
                    </form>
                </div>

                <!-- Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="hover:text-blue-200 transition">Trang chủ</a>
                    <a href="{{ route('page.about') }}" class="hover:text-blue-200 transition">Giới thiệu</a>
                    <a href="{{ route('news') }}" class="hover:text-blue-200 transition">Tin tức</a>
                    <a href="{{ route('events') }}" class="hover:text-blue-200 transition">Sự kiện</a>
                    <a href="{{ route('departments') }}" class="hover:text-blue-200 transition">Khoa - Phòng</a>

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
                    <p class="text-gray-400">Điện thoại: 0236 3894 123</p>
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
                <p>&copy; {{ date('Y') }} UTE Blog</p>
            </div>
        </div>
    </footer>

    <script>
        function searchAutocomplete() {
            return {
                query: '',
                suggestions: [],
                showSuggestions: false,

                fetchSuggestions() {
                    if (this.query.length < 2) {
                        this.suggestions = [];
                        return;
                    }

                    fetch(`/api/search/autocomplete?q=${encodeURIComponent(this.query)}`)
                        .then(response => response.json())
                        .then(data => {
                            this.suggestions = data;
                            this.showSuggestions = data.length > 0;
                        })
                        .catch(() => {
                            this.suggestions = [];
                        });
                }
            }
        }
    </script>

    @stack('scripts')
</body>

</html>