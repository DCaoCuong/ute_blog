@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <!-- Hero Banner -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white">
        <div class="container mx-auto px-4 py-16">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Chào mừng đến với UTE
                </h1>
                <p class="text-xl text-blue-100 mb-8">
                    Trường Đại học Sư phạm Kỹ thuật - Đại học Đà Nẵng.
                    Nơi đào tạo nguồn nhân lực chất lượng cao cho công nghiệp hóa, hiện đại hóa đất nước.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="/gioi-thieu"
                        class="bg-white text-blue-800 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition">
                        Tìm hiểu thêm
                    </a>
                    <a href="/tin-tuc"
                        class="border border-white text-white px-6 py-3 rounded-lg font-medium hover:bg-white hover:text-blue-800 transition">
                        Tin tức mới nhất
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured News Section -->
    <section class="py-12 container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Tin tức tiêu biểu</h2>
            <a href="/tin-tuc" class="text-blue-600 hover:text-blue-800 font-medium">
                Xem tất cả →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Placeholder News Cards -->
            @for ($i = 1; $i <= 6; $i++)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                        <span class="text-gray-400 text-lg">Hình ảnh {{ $i }}</span>
                    </div>
                    <div class="p-5">
                        <span class="text-sm text-blue-600 font-medium">Tin tức</span>
                        <h3 class="text-lg font-semibold text-gray-800 mt-2 hover:text-blue-600 transition">
                            <a href="#">Tiêu đề bài viết mẫu số {{ $i }}</a>
                        </h3>
                        <p class="text-gray-600 mt-2 text-sm line-clamp-2">
                            Đây là nội dung tóm tắt của bài viết. Đây là nội dung tóm tắt của bài viết.
                        </p>
                        <div class="flex items-center mt-4 text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ now()->subDays($i)->format('d/m/Y') }}
                        </div>
                    </div>
                </article>
            @endfor
        </div>
    </section>

    <!-- Events Section -->
    <section class="bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Sự kiện sắp diễn ra</h2>
                <a href="/su-kien" class="text-blue-600 hover:text-blue-800 font-medium">
                    Xem tất cả →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="bg-white rounded-lg shadow-md p-6 flex gap-4">
                        <div
                            class="flex-shrink-0 w-16 h-16 bg-blue-800 rounded-lg flex flex-col items-center justify-center text-white">
                            <span class="text-2xl font-bold">{{ 15 + $i }}</span>
                            <span class="text-xs">Th12</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 hover:text-blue-600 transition">
                                <a href="#">Sự kiện mẫu {{ $i }}</a>
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Thời gian: 08:00 - 17:00</p>
                            <p class="text-sm text-gray-500 mt-1">📍 Hội trường UTE</p>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Quick Links Section -->
    <section class="py-12 container mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Khoa & Đơn vị</h2>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $departments = [
                    ['name' => 'Khoa Công nghệ Thông tin', 'icon' => '💻'],
                    ['name' => 'Khoa Cơ khí', 'icon' => '⚙️'],
                    ['name' => 'Khoa Điện - Điện tử', 'icon' => '⚡'],
                    ['name' => 'Khoa Xây dựng', 'icon' => '🏗️'],
                    ['name' => 'Khoa Kinh tế', 'icon' => '📊'],
                    ['name' => 'Phòng Đào tạo', 'icon' => '📚'],
                    ['name' => 'Phòng CTSV', 'icon' => '👥'],
                    ['name' => 'Thư viện', 'icon' => '📖'],
                ];
            @endphp

            @foreach ($departments as $dept)
                <a href="#"
                    class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg hover:border-blue-500 border-2 border-transparent transition text-center">
                    <div class="text-3xl mb-2">{{ $dept['icon'] }}</div>
                    <h3 class="font-medium text-gray-800 text-sm">{{ $dept['name'] }}</h3>
                </a>
            @endforeach
        </div>
    </section>
@endsection