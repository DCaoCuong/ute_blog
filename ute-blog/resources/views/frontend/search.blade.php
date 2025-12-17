@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-gray-800 to-gray-700 text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4">Tìm kiếm</h1>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('search') }}" class="max-w-2xl">
            <div class="flex gap-2">
                <input type="text" name="q" value="{{ $query }}" 
                       placeholder="Tìm kiếm tin tức, sự kiện, đơn vị..."
                       class="flex-1 px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       autofocus>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>

        @if($query)
        <p class="text-gray-300 mt-4">
            Kết quả cho: <strong>"{{ $query }}"</strong>
        </p>
        @endif
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    @if(empty($query))
        <!-- Empty State -->
        <div class="text-center py-16">
            <svg class="w-20 h-20 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-gray-500 mt-4 text-lg">Nhập từ khóa để tìm kiếm</p>
        </div>
    @else
        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-2 mb-8">
            <a href="{{ route('search', ['q' => $query]) }}" 
               class="px-4 py-2 rounded-lg font-medium transition {{ $type === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Tất cả ({{ $posts->count() + $departments->count() }})
            </a>
            <a href="{{ route('search', ['q' => $query, 'type' => 'posts']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition {{ $type === 'posts' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Bài viết ({{ $posts->count() }})
            </a>
            <a href="{{ route('search', ['q' => $query, 'type' => 'departments']) }}" 
               class="px-4 py-2 rounded-lg font-medium transition {{ $type === 'departments' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Đơn vị ({{ $departments->count() }})
            </a>
        </div>

        <!-- Results -->
        @if($posts->count() === 0 && $departments->count() === 0)
            <div class="text-center py-16">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-500 mt-4">Không tìm thấy kết quả nào cho "{{ $query }}"</p>
                <a href="{{ route('search') }}" class="inline-block mt-4 text-blue-600 hover:text-blue-800">
                    Thử tìm kiếm khác
                </a>
            </div>
        @else
            <!-- Posts Results -->
            @if($posts->count() > 0 && ($type === 'all' || $type === 'posts'))
            <section class="mb-12">
                <h2 class="text-xl font-bold text-gray-800 mb-6">
                    Bài viết ({{ $posts->count() }})
                </h2>
                <div class="space-y-4">
                    @foreach($posts as $post)
                    <article class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                        <div class="flex items-start gap-4">
                            @if($post->thumbnail)
                            <div class="w-32 h-24 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            </div>
                            @endif
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $post->type === 'event' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $post->type === 'event' ? 'Sự kiện' : 'Tin tức' }}
                                    </span>
                                    @if($post->category)
                                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition">
                                    <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-gray-600 mt-2 text-sm line-clamp-2">{{ $post->excerpt }}</p>
                                <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                                    <span>{{ $post->published_at?->format('d/m/Y') }}</span>
                                    <span>{{ number_format($post->views_count ?? 0) }} lượt xem</span>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Departments Results -->
            @if($departments->count() > 0 && ($type === 'all' || $type === 'departments'))
            <section>
                <h2 class="text-xl font-bold text-gray-800 mb-6">
                    Đơn vị ({{ $departments->count() }})
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($departments as $dept)
                    <a href="{{ route('department.show', $dept->slug) }}" 
                       class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group flex items-start gap-4">
                        @if($dept->logo)
                            <img src="{{ $dept->logo }}" alt="{{ $dept->name }}" class="w-16 h-16 object-contain">
                        @else
                            <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-2xl font-bold">
                                {{ substr($dept->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <span class="text-xs text-gray-500">
                                @switch($dept->type)
                                    @case('faculty') Khoa @break
                                    @case('office') Phòng Ban @break
                                    @case('center') Trung tâm @break
                                @endswitch
                            </span>
                            <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 transition">
                                {{ $dept->name }}
                            </h3>
                            @if($dept->description)
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $dept->description }}</p>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif
        @endif
    @endif
</div>
@endsection
