@extends('layouts.app')

@section('title', 'Khoa & Đơn vị')

@section('content')
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-gray-800 to-gray-700 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold">Khoa & Đơn vị</h1>
            <p class="text-gray-300 mt-2">Cơ cấu tổ chức của Trường Đại học Sư phạm Kỹ thuật</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Faculties -->
        @if($faculties->count() > 0)
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white mr-3">
                        🎓
                    </span>
                    Các Khoa
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($faculties as $dept)
                        <a href="{{ route('department.show', $dept->slug) }}"
                            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group border-l-4 border-blue-600">
                            <div class="flex items-start">
                                @if($dept->logo)
                                    <img src="{{ $dept->logo }}" alt="{{ $dept->name }}" class="w-16 h-16 object-contain mr-4">
                                @else
                                    <div
                                        class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-2xl font-bold mr-4">
                                        {{ substr($dept->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-600 transition">{{ $dept->name }}
                                    </h3>
                                    @if($dept->description)
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $dept->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Offices -->
        @if($offices->count() > 0)
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-white mr-3">
                        🏢
                    </span>
                    Các Phòng Ban
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($offices as $dept)
                        <a href="{{ route('department.show', $dept->slug) }}"
                            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group border-l-4 border-green-600">
                            <div class="flex items-start">
                                @if($dept->logo)
                                    <img src="{{ $dept->logo }}" alt="{{ $dept->name }}" class="w-16 h-16 object-contain mr-4">
                                @else
                                    <div
                                        class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center text-green-600 text-2xl font-bold mr-4">
                                        {{ substr($dept->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-semibold text-gray-800 group-hover:text-green-600 transition">{{ $dept->name }}
                                    </h3>
                                    @if($dept->description)
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $dept->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Centers -->
        @if($centers->count() > 0)
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center text-white mr-3">
                        🔬
                    </span>
                    Các Trung tâm
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($centers as $dept)
                        <a href="{{ route('department.show', $dept->slug) }}"
                            class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition group border-l-4 border-purple-600">
                            <div class="flex items-start">
                                @if($dept->logo)
                                    <img src="{{ $dept->logo }}" alt="{{ $dept->name }}" class="w-16 h-16 object-contain mr-4">
                                @else
                                    <div
                                        class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 text-2xl font-bold mr-4">
                                        {{ substr($dept->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-semibold text-gray-800 group-hover:text-purple-600 transition">{{ $dept->name }}
                                    </h3>
                                    @if($dept->description)
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $dept->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if($faculties->count() == 0 && $offices->count() == 0 && $centers->count() == 0)
            <div class="text-center py-16">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <p class="text-gray-500 mt-4">Chưa có thông tin về các đơn vị.</p>
            </div>
        @endif
    </div>
@endsection