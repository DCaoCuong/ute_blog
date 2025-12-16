<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Đào tạo', 'slug' => 'dao-tao'],
            ['name' => 'Khoa học & Công nghệ', 'slug' => 'khoa-hoc-cong-nghe'],
            ['name' => 'Sinh viên', 'slug' => 'sinh-vien'],
            ['name' => 'Tuyển sinh', 'slug' => 'tuyen-sinh'],
            ['name' => 'Hợp tác Quốc tế', 'slug' => 'hop-tac-quoc-te'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
        $this->command->info('Created categories');

        // Create Departments
        $departments = [
            ['name' => 'Khoa Công nghệ số', 'slug' => 'khoa-cns', 'type' => 'faculty', 'description' => 'Đào tạo nguồn nhân lực CNTT chất lượng cao', 'contact_email' => 'cntt@ute.udn.vn', 'order' => 1],
            ['name' => 'Khoa Cơ khí', 'slug' => 'khoa-co-khi', 'type' => 'faculty', 'description' => 'Đào tạo kỹ sư cơ khí', 'contact_email' => 'cokhi@ute.udn.vn', 'order' => 2],
            ['name' => 'Khoa Điện - Điện tử', 'slug' => 'khoa-dien', 'type' => 'faculty', 'description' => 'Đào tạo kỹ sư điện, điện tử', 'contact_email' => 'dien@ute.udn.vn', 'order' => 3],
            ['name' => 'Khoa Xây dựng', 'slug' => 'khoa-xay-dung', 'type' => 'faculty', 'description' => 'Đào tạo kỹ sư xây dựng', 'contact_email' => 'xaydung@ute.udn.vn', 'order' => 4],
            ['name' => 'Khoa Hóa môi', 'slug' => 'khoa-hoa-moi', 'type' => 'faculty', 'description' => 'Đào tạo kỹ sư hóa học', 'contact_email' => 'hoamoitruong@ute.udn.vn', 'order' => 5],
            ['name' => 'Khoa Sư phạm công nghiệp', 'slug' => 'khoa-su-pham-cong-nghiep', 'type' => 'faculty', 'description' => 'Đào tạo kỹ sư hóa học', 'contact_email' => 'spcn@ute.udn.vn', 'order' => 6],
            ['name' => 'Phòng Đào tạo', 'slug' => 'phong-dao-tao', 'type' => 'office', 'description' => 'Quản lý công tác đào tạo', 'contact_email' => 'daotao@ute.udn.vn', 'order' => 1],
            ['name' => 'Phòng Công tác Sinh viên', 'slug' => 'phong-ctsv', 'type' => 'office', 'description' => 'Hỗ trợ sinh viên', 'contact_email' => 'ctsv@ute.udn.vn', 'order' => 2],
            ['name' => 'Thư viện', 'slug' => 'thu-vien', 'type' => 'center', 'description' => 'Tra cứu tài liệu học tập', 'contact_email' => 'thuvien@ute.udn.vn', 'order' => 1],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(['slug' => $dept['slug']], $dept);
        }
        $this->command->info('Created departments');

        // Create Sample News
        $newsData = [
            ['title' => 'Lễ khai giảng năm học 2024-2025', 'type' => 'news', 'is_featured' => true],
            ['title' => 'Hội thảo Khoa học Quốc gia về Công nghệ 4.0', 'type' => 'news', 'is_featured' => true],
            ['title' => 'Sinh viên UTE đạt giải Nhất cuộc thi Startup', 'type' => 'news', 'is_featured' => false],
            ['title' => 'Thông báo lịch thi kết thúc học kỳ I', 'type' => 'news', 'is_featured' => false],
            ['title' => 'Ký kết hợp tác với doanh nghiệp CNTT', 'type' => 'news', 'is_featured' => false],
            ['title' => 'Tuyển sinh đại học chính quy năm 2025', 'type' => 'news', 'is_featured' => true],
        ];

        foreach ($newsData as $index => $news) {
            Post::updateOrCreate(
                ['slug' => Str::slug($news['title'])],
                [
                    'title' => $news['title'],
                    'slug' => Str::slug($news['title']),
                    'content' => '<p>Nội dung chi tiết của bài viết "' . $news['title'] . '". Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
                    'excerpt' => 'Tóm tắt ngắn gọn về ' . strtolower($news['title']) . '. Đây là nội dung mẫu để demo giao diện.',
                    'type' => $news['type'],
                    'status' => 'published',
                    'is_featured' => $news['is_featured'],
                    'is_pinned' => $index === 0,
                    'views_count' => rand(50, 500),
                    'published_at' => now()->subDays(rand(1, 30)),
                ]
            );
        }
        $this->command->info('Created sample news');

        // Create Sample Events
        $eventsData = [
            ['title' => 'Hội thảo Trí tuệ nhân tạo trong giáo dục', 'days' => 7, 'location' => 'Hội trường khu A - Cơ sở 2'],
            ['title' => 'Ngày hội việc làm UTE 2025', 'days' => 14, 'location' => 'Sảnh khu A'],
            ['title' => 'Workshop: Kỹ năng phỏng vấn', 'days' => 21, 'location' => 'Phòng họp khu A'],
            ['title' => 'Cuộc thi Lập trình ACM', 'days' => 30, 'location' => 'Phòng máy tính 1 - Khu B'],
        ];

        foreach ($eventsData as $event) {
            Post::updateOrCreate(
                ['slug' => Str::slug($event['title'])],
                [
                    'title' => $event['title'],
                    'slug' => Str::slug($event['title']),
                    'content' => '<p>Chi tiết về sự kiện "' . $event['title'] . '". Mời quý vị và các bạn tham gia.</p>',
                    'excerpt' => 'Sự kiện ' . $event['title'] . ' sẽ được tổ chức tại ' . $event['location'],
                    'type' => 'event',
                    'status' => 'published',
                    'event_date' => now()->addDays($event['days'])->setTime(8, 0),
                    'event_location' => $event['location'],
                    'views_count' => rand(20, 200),
                    'published_at' => now(),
                ]
            );
        }
        $this->command->info('Created sample events');

        $this->command->info(' Sample data created successfully!');
    }
}
