@extends('layouts.app')

@section('title', 'Tin tức')

@section('content')
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Tin tức</h1>
            <p class="text-blue-100 mt-2">Cập nhật thông tin mới nhất từ trường Đại học Sư phạm Kỹ thuật</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow p-4 mb-8">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm tin tức..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <select name="category"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->_id }}" {{ request('category') == $category->_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Tìm kiếm
                </button>
                @if(request()->hasAny(['q', 'category']))
                    <a href="{{ route('news') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Xóa bộ lọc
                    </a>
                @endif
            </form>
        </div>

        <!-- Posts Grid -->
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition group">
                        <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                            @if($post->thumbnail)
                                <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            @if($post->category)
                                <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded mb-2">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                            <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition line-clamp-2">
                                <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-gray-600 mt-2 text-sm line-clamp-2">{{ $post->excerpt }}</p>
                            <div class="flex items-center justify-between mt-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ $post->published_at?->format('d/m/Y') }}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    {{ number_format($post->views_count ?? 0) }}
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                </svg>
                <p class="text-gray-500 mt-4">Không tìm thấy tin tức nào.</p>
                @if(request()->hasAny(['q', 'category']))
                    <a href="{{ route('news') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                        ← Quay lại danh sách
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection