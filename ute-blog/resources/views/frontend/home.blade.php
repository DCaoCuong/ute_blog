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
                    <a href="{{ route('page.about') }}"
                        class="bg-white text-blue-800 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition">
                        Tìm hiểu thêm
                    </a>
                    <a href="{{ route('news') }}"
                        class="border border-white text-white px-6 py-3 rounded-lg font-medium hover:bg-white hover:text-blue-800 transition">
                        Tin tức mới nhất
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Posts -->
    @if($featuredPosts->count() > 0)
        <section class="py-12 container mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Tin nổi bật</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($featuredPosts as $post)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition group">
                        <div class="h-48 bg-gradient-to-br from-blue-100 to-blue-200 overflow-hidden">
                            @if($post->thumbnail)
                                <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-blue-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <span
                                class="text-sm text-blue-600 font-medium">{{ $post->type === 'event' ? 'Sự kiện' : 'Tin tức' }}</span>
                            <h3 class="text-lg font-semibold text-gray-800 mt-2 group-hover:text-blue-600 transition line-clamp-2">
                                <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-600 mt-2 text-sm line-clamp-2">{{ $post->excerpt }}</p>
                            <div class="flex items-center mt-4 text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $post->published_at?->format('d/m/Y') }}
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Latest News Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Tin tức mới nhất</h2>
                <a href="{{ route('news') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                    Xem tất cả
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            @if($latestNews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($latestNews as $post)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <div class="p-5">
                                <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded mb-3">Tin
                                    tức</span>
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition line-clamp-2">
                                    <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-gray-600 mt-2 text-sm line-clamp-2">{{ $post->excerpt }}</p>
                                <div class="flex items-center justify-between mt-4 text-sm text-gray-500">
                                    <span>{{ $post->published_at?->format('d/m/Y') }}</span>
                                    <span>{{ number_format($post->views_count ?? 0) }} lượt xem</span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <p>Chưa có tin tức nào.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Events Section -->
    <section class="py-12 container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Sự kiện sắp diễn ra</h2>
            <a href="{{ route('events') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                Xem tất cả
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        @if($upcomingEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($upcomingEvents as $event)
                    <div class="bg-white rounded-lg shadow-md p-6 flex gap-4 hover:shadow-lg transition">
                        <div
                            class="flex-shrink-0 w-16 h-16 bg-blue-800 rounded-lg flex flex-col items-center justify-center text-white">
                            <span class="text-2xl font-bold">{{ $event->event_date?->format('d') }}</span>
                            <span class="text-xs">Th{{ $event->event_date?->format('m') }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 hover:text-blue-600 transition line-clamp-2">
                                <a href="{{ route('post.show', $event->slug) }}">{{ $event->title }}</a>
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                🕐 {{ $event->event_date?->format('H:i') }}
                            </p>
                            @if($event->event_location)
                                <p class="text-sm text-gray-500 mt-1">
                                    📍 {{ $event->event_location }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                <p>Chưa có sự kiện sắp tới.</p>
            </div>
        @endif
    </section>

    <!-- Departments Quick Links -->
    <section class="py-12 bg-gray-800 text-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-8 text-center">Khoa & Đơn vị</h2>

            @if($departments->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($departments as $dept)
                        <a href="{{ route('department.show', $dept->slug) }}"
                            class="bg-gray-700 rounded-lg p-4 hover:bg-gray-600 transition text-center group">
                            @if($dept->logo)
                                <img src="{{ $dept->logo }}" alt="{{ $dept->name }}" class="w-12 h-12 mx-auto mb-3 object-contain">
                            @else
                                <div class="w-12 h-12 mx-auto mb-3 bg-blue-600 rounded-full flex items-center justify-center text-xl">
                                    {{ substr($dept->name, 0, 1) }}
                                </div>
                            @endif
                            <h3 class="font-medium text-sm group-hover:text-blue-300 transition line-clamp-2">{{ $dept->name }}</h3>
                        </a>
                    @endforeach
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('departments') }}"
                        class="inline-block px-6 py-3 border border-white rounded-lg hover:bg-white hover:text-gray-800 transition">
                        Xem tất cả đơn vị
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @php
                        $defaultDepts = [
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
                    @foreach($defaultDepts as $dept)
                        <a href="#" class="bg-gray-700 rounded-lg p-4 hover:bg-gray-600 transition text-center">
                            <div class="text-3xl mb-2">{{ $dept['icon'] }}</div>
                            <h3 class="font-medium text-sm">{{ $dept['name'] }}</h3>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection