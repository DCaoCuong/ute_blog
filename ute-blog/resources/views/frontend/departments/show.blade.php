@extends('layouts.app')

@section('title', $department->name)

@section('content')
<!-- Page Header with Banner -->
<div class="relative">
    @if($department->banner)
        <div class="h-64 md:h-80 bg-cover bg-center" style="background-image: url('{{ $department->banner }}');">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
    @else
        <div class="h-64 md:h-80 bg-gradient-to-r from-blue-800 to-blue-600"></div>
    @endif
    
    <div class="absolute inset-0 flex items-center">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-white">
                @if($department->logo)
                    <img src="{{ $department->logo }}" alt="{{ $department->name }}" class="w-24 h-24 object-contain bg-white rounded-lg p-2 mr-6">
                @else
                    <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center text-blue-600 text-4xl font-bold mr-6">
                        {{ substr($department->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <span class="text-blue-200 text-sm">
                        @switch($department->type)
                            @case('faculty') Khoa @break
                            @case('office') Phòng Ban @break
                            @case('center') Trung tâm @break
                            @default Đơn vị
                        @endswitch
                    </span>
                    <h1 class="text-3xl md:text-4xl font-bold">{{ $department->name }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-3">
    <div class="container mx-auto px-4">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="/" class="text-gray-500 hover:text-gray-700">Trang chủ</a>
            <span class="text-gray-400">/</span>
            <a href="{{ route('departments') }}" class="text-gray-500 hover:text-gray-700">Khoa & Đơn vị</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-800">{{ $department->name }}</span>
        </nav>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Description -->
            @if($department->description)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Giới thiệu</h2>
                <p class="text-gray-600">{{ $department->description }}</p>
            </div>
            @endif

            <!-- Rich Content -->
            @if($department->content)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="prose max-w-none">
                    {!! $department->content !!}
                </div>
            </div>
            @endif

            <!-- Department News -->
            @if($posts->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Tin tức từ {{ $department->name }}</h2>
                <div class="space-y-4">
                    @foreach($posts as $post)
                    <article class="flex gap-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                        <div class="w-24 h-20 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                            @if($post->thumbnail)
                                <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800 hover:text-blue-600 transition line-clamp-2">
                                <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $post->published_at?->format('d/m/Y') }}</p>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Thông tin liên hệ</h3>
                <div class="space-y-3 text-gray-600">
                    @if($department->contact_email)
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:{{ $department->contact_email }}" class="hover:text-blue-600">
                            {{ $department->contact_email }}
                        </a>
                    </div>
                    @endif
                    @if($department->contact_phone)
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <a href="tel:{{ $department->contact_phone }}" class="hover:text-blue-600">
                            {{ $department->contact_phone }}
                        </a>
                    </div>
                    @endif
                    @if($department->address)
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <span>{{ $department->address }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sub-departments -->
            @if($subDepartments->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Đơn vị trực thuộc</h3>
                <div class="space-y-2">
                    @foreach($subDepartments as $sub)
                    <a href="{{ route('department.show', $sub->slug) }}" 
                       class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        <span class="font-medium text-gray-700">{{ $sub->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
