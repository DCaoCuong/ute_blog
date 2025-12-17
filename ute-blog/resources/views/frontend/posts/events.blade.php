@extends('layouts.app')

@section('title', 'Sự kiện')

@section('content')
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-purple-800 to-purple-600 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Sự kiện</h1>
            <p class="text-purple-100 mt-2">Các sự kiện và hoạt động của trường</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Filter Tabs -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('events') }}"
                class="px-6 py-2 rounded-lg font-medium transition {{ request('filter') !== 'past' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Sắp diễn ra
            </a>
            <a href="{{ route('events', ['filter' => 'past']) }}"
                class="px-6 py-2 rounded-lg font-medium transition {{ request('filter') === 'past' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Đã diễn ra
            </a>
        </div>

        <!-- Events List -->
        @if($posts->count() > 0)
            <div class="space-y-6">
                @foreach($posts as $event)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="md:flex">
                            <!-- Date Badge -->
                            <div class="md:w-32 bg-purple-800 text-white p-6 flex flex-col items-center justify-center text-center">
                                <span class="text-4xl font-bold">{{ $event->event_date?->format('d') }}</span>
                                <span class="text-lg">Tháng {{ $event->event_date?->format('m') }}</span>
                                <span class="text-sm opacity-75">{{ $event->event_date?->format('Y') }}</span>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 p-6">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    @if($event->event_date >= now())
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">Sắp diễn
                                            ra</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded">Đã kết thúc</span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-semibold text-gray-800 hover:text-purple-600 transition">
                                    <a href="{{ route('post.show', $event->slug) }}">{{ $event->title }}</a>
                                </h3>

                                <p class="text-gray-600 mt-2 line-clamp-2">{{ $event->excerpt }}</p>

                                <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $event->event_date?->format('H:i') }}
                                    </div>
                                    @if($event->event_location)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $event->event_location }}
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ route('post.show', $event->slug) }}"
                                    class="inline-block mt-4 text-purple-600 hover:text-purple-800 font-medium">
                                    Xem chi tiết →
                                </a>
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
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-gray-500 mt-4">
                    {{ request('filter') === 'past' ? 'Chưa có sự kiện nào đã diễn ra.' : 'Chưa có sự kiện sắp tới.' }}
                </p>
            </div>
        @endif
    </div>
@endsection