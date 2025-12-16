<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Create default admin user for testing
     */
    public function run(): void
    {
        // Create Admin user
        User::updateOrCreate(
            ['email' => 'admin@ute.udn.vn'],
            [
                'user_code' => 'ADMIN001',
                'name' => 'Administrator',
                'password' => 'Admin@123',
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
            ]
        );

        // Create Content Manager user
        User::updateOrCreate(
            ['email' => 'cm@ute.udn.vn'],
            [
                'user_code' => 'CM001',
                'name' => 'Content Manager',
                'password' => 'Cm@12345',
                'role' => User::ROLE_CONTENT_MANAGER,
                'status' => User::STATUS_ACTIVE,
            ]
        );

        // Create sample pending user
        User::updateOrCreate(
            ['email' => 'sv001@ute.udn.vn'],
            [
                'user_code' => 'SV001',
                'name' => 'Nguyễn Văn A',
                'password' => 'Student@123',
                'role' => User::ROLE_MEMBER,
                'status' => User::STATUS_PENDING,
            ]
        );

        $this->command->info('✅ Created admin users:');
        $this->command->info('   📧 admin@ute.udn.vn / Admin@123');
        $this->command->info('   📧 cm@ute.udn.vn / Cm@12345');
        $this->command->info('   📧 sv001@ute.udn.vn / Student@123');
    }
}
