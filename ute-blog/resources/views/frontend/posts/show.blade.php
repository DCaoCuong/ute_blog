@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-gray-100 py-3">
        <div class="container mx-auto px-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="/" class="text-gray-500 hover:text-gray-700">Trang chủ</a>
                <span class="text-gray-400">/</span>
                @if($post->type === 'event')
                    <a href="{{ route('events') }}" class="text-gray-500 hover:text-gray-700">Sự kiện</a>
                @else
                    <a href="{{ route('news') }}" class="text-gray-500 hover:text-gray-700">Tin tức</a>
                @endif
                <span class="text-gray-400">/</span>
                <span class="text-gray-800 line-clamp-1">{{ $post->title }}</span>
            </nav>
        </div>
    </div>

    <article class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <header class="mb-8">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    @if($post->type === 'event')
                        <span class="px-3 py-1 text-sm font-medium bg-purple-100 text-purple-800 rounded-full">Sự kiện</span>
                    @else
                        <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">Tin tức</span>
                    @endif
                    @if($post->category)
                        <span
                            class="px-3 py-1 text-sm font-medium bg-gray-100 text-gray-700 rounded-full">{{ $post->category->name }}</span>
                    @endif
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $post->title }}</h1>

                <div class="flex flex-wrap items-center gap-4 mt-4 text-gray-500">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $post->published_at?->format('d/m/Y') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        {{ number_format($post->views_count ?? 0) }} lượt xem
                    </div>
                    @if($post->author)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $post->author->name }}
                        </div>
                    @endif
                </div>

                <!-- Event Info -->
                @if($post->type === 'event' && $post->event_date)
                    <div class="mt-6 p-4 bg-purple-50 rounded-lg border border-purple-100">
                        <div class="flex flex-wrap gap-6">
                            <div class="flex items-center text-purple-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="font-medium">{{ $post->event_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center text-purple-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">{{ $post->event_date->format('H:i') }}</span>
                            </div>
                            @if($post->event_location)
                                <div class="flex items-center text-purple-800">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    <span class="font-medium">{{ $post->event_location }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </header>

            <!-- Featured Image -->
            @if($post->thumbnail)
                <div class="mb-8 rounded-lg overflow-hidden">
                    <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full h-auto">
                </div>
            @endif

            <!-- Content -->
            <div class="prose prose-lg max-w-none">
                {!! $post->content !!}
            </div>

            <style>
                /* Enhanced styling for post content */
                .prose {
                    color: #374151;
                    line-height: 1.75;
                }

                .prose p {
                    margin-bottom: 1.25rem;
                    line-height: 1.75;
                }

                .prose h1,
                .prose h2,
                .prose h3,
                .prose h4,
                .prose h5,
                .prose h6 {
                    font-weight: 600;
                    margin-top: 2rem;
                    margin-bottom: 1rem;
                    line-height: 1.3;
                    color: #111827;
                }

                .prose h1 {
                    font-size: 2.25rem;
                }

                .prose h2 {
                    font-size: 1.875rem;
                }

                .prose h3 {
                    font-size: 1.5rem;
                }

                .prose h4 {
                    font-size: 1.25rem;
                }

                .prose img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 0.5rem;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                    margin: 2rem auto;
                    display: block;
                }

                .prose ul,
                .prose ol {
                    margin: 1.25rem 0;
                    padding-left: 1.75rem;
                }

                .prose li {
                    margin: 0.5rem 0;
                }

                .prose a {
                    color: #2563eb;
                    text-decoration: underline;
                }

                .prose a:hover {
                    color: #1d4ed8;
                }

                .prose strong {
                    font-weight: 600;
                    color: #111827;
                }

                .prose em {
                    font-style: italic;
                }

                .prose blockquote {
                    border-left: 4px solid #e5e7eb;
                    padding-left: 1rem;
                    margin: 1.5rem 0;
                    font-style: italic;
                    color: #6b7280;
                }

                .prose code {
                    background: #f3f4f6;
                    padding: 0.2rem 0.4rem;
                    border-radius: 0.25rem;
                    font-size: 0.875em;
                    font-family: 'Courier New', monospace;
                }

                .prose pre {
                    background: #1f2937;
                    color: #f9fafb;
                    padding: 1rem;
                    border-radius: 0.5rem;
                    overflow-x: auto;
                    margin: 1.5rem 0;
                }

                .prose table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 1.5rem 0;
                }

                .prose th,
                .prose td {
                    border: 1px solid #e5e7eb;
                    padding: 0.75rem;
                    text-align: left;
                }

                .prose th {
                    background: #f9fafb;
                    font-weight: 600;
                }

                /* Preserve whitespace and line breaks */
                .prose {
                    white-space: pre-wrap;
                    word-wrap: break-word;
                }
            </style>

            <!-- Tags -->
            @if($post->tags && count($post->tags) > 0)
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-gray-600 font-medium">Tags:</span>
                        @foreach($post->tags as $tag)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Share -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center gap-4">
                    <span class="text-gray-600 font-medium">Chia sẻ:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                        class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </article>

    <!-- Comments Section -->
    <section class="bg-white py-8 border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Bình luận ({{ $post->comments->count() }})</h2>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 flex items-center shadow-sm" role="alert">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Comment Form -->
            @auth
                <div class="mb-10 p-6 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                                    class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            @else
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="content" class="sr-only">Nội dung bình luận</label>
                                    <textarea name="content" id="content" rows="3"
                                        class="w-full px-4 py-3 rounded-lg border {{ $errors->has('content') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500' }} focus:ring-2 transition resize-none"
                                        placeholder="Comment nào ... .>>>" required></textarea>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-sm">
                                        Gửi bình luận
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="mb-10 p-6 bg-blue-50 rounded-xl border border-blue-100 text-center">
                    <p class="text-blue-800 mb-3">Vui lòng đăng nhập để bình luận.</p>
                    <a href="{{ route('login') }}" class="inline-block px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-sm">
                        Đăng nhập ngay
                    </a>
                </div>
            @endauth

            <!-- Comments List -->
            <div id="comment-list" class="space-y-6">
                @forelse($post->comments as $comment)
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            @if($comment->user && $comment->user->avatar)
                                <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}"
                                    class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            @elseif($comment->user)
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold border border-gray-200">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-200">
                                    <svg class="w-6 h-6" fill="fill" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <!-- View Mode -->
                            <div id="comment-view-{{ $comment->id }}" class="bg-gray-50 p-3 rounded-2xl rounded-tl-none border border-gray-100 group relative">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-semibold text-gray-900 text-sm">
                                        {{ $comment->user ? $comment->user->name : 'Người dùng ẩn danh' }}
                                    </h4>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        @auth
                                            @if(auth()->id() === $comment->user_id)
                                                <button onclick="toggleEdit('{{ $comment->id }}')" class="text-xs text-blue-600 hover:text-blue-800 font-medium ml-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    Sửa
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                                <div class="text-gray-700 text-sm whitespace-pre-wrap">{{ $comment->content }}</div>
                            </div>

                            <!-- Edit Mode -->
                            @auth
                                @if(auth()->id() === $comment->user_id)
                                    <div id="comment-edit-{{ $comment->id }}" class="hidden">
                                        <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="bg-white p-4 rounded-2xl border border-blue-200 shadow-sm">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="content-{{ $comment->id }}" class="sr-only">Nội dung</label>
                                                <textarea name="content" id="content-{{ $comment->id }}" rows="3"
                                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 focus:ring-2 transition resize-none"
                                                    required>{{ $comment->content }}</textarea>
                                            </div>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" onclick="toggleEdit('{{ $comment->id }}')"
                                                    class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium text-sm transition">
                                                    Hủy
                                                </button>
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 text-sm transition shadow-sm">
                                                    Cập nhật
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div id="no-comments-message" class="text-center py-8 text-gray-500 italic">
                        Chưa có bình luận nào. Hãy là người đầu tiên bình luận >>
                    </div>
                @endforelse
            </div>

            <script>
                function toggleEdit(commentId) {
                    const viewEl = document.getElementById(`comment-view-${commentId}`);
                    const editEl = document.getElementById(`comment-edit-${commentId}`);
                    
                    if (viewEl && editEl) {
                        viewEl.classList.toggle('hidden');
                        editEl.classList.toggle('hidden');
                    }
                }
            </script>
        </div>
    </section>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <section class="bg-gray-50 py-12">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-8">Bài viết liên quan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedPosts as $related)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            <div class="h-40 bg-gradient-to-br from-gray-100 to-gray-200">
                                @if($related->thumbnail)
                                    <img src="{{ $related->thumbnail }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-800 hover:text-blue-600 transition line-clamp-2">
                                    <a href="{{ route('post.show', $related->slug) }}">{{ $related->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-500 mt-2">{{ $related->published_at?->format('d/m/Y') }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@push('scripts')
{{-- Load Socket.io from a reliable CDN --}}
<script src="https://cdn.socket.io/4.7.2/socket.io.min.js" integrity="sha384-mZLF4UVrpi/QTWPA7BjNPEnkIfRFn4ZEO3Qt/HFklTJBj/gBOV8G3HcKn4NfQblz" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing Socket.io...');
        
        // Ensure io is defined
        if (typeof io === 'undefined') {
            console.error('Socket.io library not loaded!');
            return;
        }

        const socket = io('http://localhost:3000', {
            transports: ['websocket', 'polling'], // Allow fallback
            reconnection: true
        });

        const postId = "{{ $post->id }}"; // Ensure string context for ID if needed, though unquoted works for ints
        
        // Debug connection status
        socket.on('connect', () => {
            console.log(' Connected to socket server with ID:', socket.id);
        });

        socket.on('connect_error', (err) => {
            console.error('Connection failed:', err);
        });

        socket.on('new_comment', (data) => {
            console.log(' New comment received:', data);
            
            // Check type equality loosely to handle string/int differences
            if (data.post_id == postId) {
                console.log(' Comment matches current post, appending...');
                const commentList = document.getElementById('comment-list');
                
                if (!commentList) {
                    console.error(' Could not find element with id "comment-list"');
                    return;
                }

            
            // XSS protection
            const content = data.content.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            
            // Render avatar based on data
            let avatarHtml = '';
            if (data.user_avatar) {
                avatarHtml = `<img src="${data.user_avatar}" alt="${data.user_name}" class="w-10 h-10 rounded-full object-cover border border-gray-200">`;
            } else {
                const firstLetter = data.user_name ? data.user_name.charAt(0).toUpperCase() : 'A';
                avatarHtml = `
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold border border-gray-200">
                        ${firstLetter}
                    </div>
                `;
            }

            const newCommentHtml = `
                <div class="flex gap-4 animate-pulse-once" id="comment-${data.id}">
                    <div class="flex-shrink-0">
                        ${avatarHtml}
                    </div>
                    <div class="flex-grow">
                        <div class="bg-gray-50 p-3 rounded-2xl rounded-tl-none border border-gray-100 group relative">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="font-semibold text-gray-900 text-sm">
                                    ${data.user_name}
                                </h4>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Vừa xong</span>
                                </div>
                            </div>
                            <div class="text-gray-700 text-sm whitespace-pre-wrap">${content}</div>
                        </div>
                    </div>
                </div>
            `;
            
            if(commentList) {
               // Remove empty message if it exists
               const emptyMsg = document.getElementById('no-comments-message');
               if (emptyMsg) emptyMsg.remove();

               // Create temporary container
               const tempDiv = document.createElement('div');
               tempDiv.innerHTML = newCommentHtml;
               
               // Append to list (at bottom)
               commentList.appendChild(tempDiv.firstElementChild);
            }
        });
    });
</script>

<style>
    @keyframes highlight {
        0% { background-color: #e0e7ff; }
        100% { background-color: #f9fafb; }
    }
    .animate-pulse-once {
        animation: highlight 2s ease-out;
    }
</style>
@endpush
@endsection