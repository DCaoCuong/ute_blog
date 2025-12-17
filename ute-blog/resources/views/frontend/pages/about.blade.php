@extends('layouts.app')

@section('title', 'Giới thiệu')

@section('content')
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold">Giới thiệu</h1>
            <p class="text-blue-100 mt-4 max-w-2xl mx-auto">
                Trường Đại học Sư phạm Kỹ thuật - Đại học Đà Nẵng
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <!-- History Section -->
        <section class="mb-16">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Lịch sử hình thành</h2>
                <div class="prose prose-lg max-w-none text-gray-600">
                    <p>
                        Trường Đại học Sư phạm Kỹ thuật (UTE) là thành viên của Đại học Đà Nẵng,
                        được thành lập với sứ mệnh đào tạo nguồn nhân lực chất lượng cao trong lĩnh vực
                        kỹ thuật và công nghệ phục vụ sự nghiệp công nghiệp hóa, hiện đại hóa đất nước.
                    </p>
                    <p class="mt-4">
                        Qua nhiều năm phát triển, trường đã xây dựng được đội ngũ giảng viên có trình độ cao,
                        cơ sở vật chất hiện đại và các chương trình đào tạo đáp ứng nhu cầu xã hội.
                    </p>
                </div>
            </div>
        </section>

        <!-- Vision & Mission -->
        <section class="bg-gray-50 py-12 -mx-4 px-4 mb-16">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center text-3xl mb-4">
                            🎯
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Tầm nhìn</h3>
                        <p class="text-gray-600">
                            Trở thành trường đại học sư phạm kỹ thuật hàng đầu khu vực,
                            có uy tín trong đào tạo và nghiên cứu khoa học.
                        </p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-8">
                        <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center text-3xl mb-4">
                            🚀
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Sứ mệnh</h3>
                        <p class="text-gray-600">
                            Đào tạo nguồn nhân lực chất lượng cao, nghiên cứu và chuyển giao công nghệ,
                            phục vụ phát triển kinh tế - xã hội.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Core Values -->
        <section class="mb-16">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Giá trị cốt lõi</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div
                            class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            📚
                        </div>
                        <h4 class="font-semibold text-gray-800">Chất lượng</h4>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            💡
                        </div>
                        <h4 class="font-semibold text-gray-800">Sáng tạo</h4>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            🤝
                        </div>
                        <h4 class="font-semibold text-gray-800">Hợp tác</h4>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-20 h-20 bg-orange-600 rounded-full flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            🌟
                        </div>
                        <h4 class="font-semibold text-gray-800">Phát triển</h4>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection