@extends('layouts.admin')

@section('title', 'Quản lý Bài viết')

@section('content')
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Danh sách Bài viết & Sự kiện</h2>
            <p class="text-gray-600">Quản lý tin tức và sự kiện của trường</p>
        </div>
        <a href="{{ route('admin.posts.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tạo bài viết
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Tìm kiếm theo tiêu đề, nội dung..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <select name="type"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">Tất cả loại</option>
                <option value="news" {{ request('type') == 'news' ? 'selected' : '' }}>Tin tức</option>
                <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Sự kiện</option>
            </select>
            <select name="status"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">Tất cả trạng thái</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
            </select>
            <select name="category_id"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">Tất cả danh mục</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->_id }}" {{ request('category_id') == $cat->_id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">
                Lọc
            </button>
            @if(request()->hasAny(['search', 'type', 'status', 'category_id']))
                <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Xóa bộ lọc
                </a>
            @endif
        </form>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 gap-4">
        @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="flex items-start p-6">
                    <!-- Thumbnail -->
                    @if($post->thumbnail)
                        <div class="w-32 h-24 flex-shrink-0 mr-6 bg-gray-100 rounded overflow-hidden">
                            <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div
                            class="w-32 h-24 flex-shrink-0 mr-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">
                                    <a href="{{ route('admin.posts.edit', $post->_id) }}" class="hover:text-blue-600">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                @if($post->excerpt)
                                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $post->excerpt }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Meta & Badges -->
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            <!-- Type Badge -->
                            @if($post->type === 'event')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                    📅 Sự kiện
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    📰 Tin tức
                                </span>
                            @endif

                            <!-- Status Badge -->
                            @if($post->status === 'published')
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    ✓ Đã xuất bản
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">
                                    📝 Bản nháp
                                </span>
                            @endif

                            <!-- Featured/Pinned -->
                            @if($post->is_featured)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                    ⭐ Nổi bật
                                </span>
                            @endif
                            @if($post->is_pinned)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                    📌 Ghim
                                </span>
                            @endif

                            <!-- Category -->
                            @if($post->category)
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200">
                                    {{ $post->category->name }}
                                </span>
                            @endif

                            <!-- Metadata -->
                            <span class="text-xs text-gray-500">
                                {{ $post->published_at?->format('d/m/Y') ?? $post->created_at->format('d/m/Y') }}
                            </span>
                            <span class="text-xs text-gray-500">
                                {{ number_format($post->views_count ?? 0) }} lượt xem
                            </span>
                            @if($post->author)
                                <span class="text-xs text-gray-500">
                                    bởi {{ $post->author->name }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col space-y-2 ml-4">
                        <!-- View -->
                        <a href="{{ route('post.show', $post->slug) }}" target="_blank"
                            class="px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded transition"
                            title="Xem">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('admin.posts.edit', $post->_id) }}"
                            class="px-3 py-2 text-sm text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded transition"
                            title="Sửa">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>

                        <!-- Publish/Unpublish -->
                        @if($post->status === 'draft')
                            <form method="POST" action="{{ route('admin.posts.publish', $post->_id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-2 text-sm text-green-600 hover:text-green-900 hover:bg-green-50 rounded transition w-full"
                                    title="Xuất bản">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.posts.unpublish', $post->_id) }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded transition w-full"
                                    title="Chuyển về nháp">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        @endif

                        <!-- Delete -->
                        <form method="POST" action="{{ route('admin.posts.destroy', $post->_id) }}" class="inline"
                            onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-2 text-sm text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition w-full"
                                title="Xóa">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <p class="text-gray-500 mt-4">Không tìm thấy bài viết nào</p>
                <a href="{{ route('admin.posts.create') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                    Tạo bài viết đầu tiên
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
        <div class="mt-6">
            {{ $posts->withQueryString()->links() }}
        </div>
    @endif
@endsection