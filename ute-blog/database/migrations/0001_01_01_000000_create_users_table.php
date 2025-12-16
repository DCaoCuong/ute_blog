<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration {
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $collection) {
            $collection->index('email');
            $collection->index('user_code');
        });

        Schema::create('password_reset_tokens', function (Blueprint $collection) {
            $collection->index('email');
        });

        Schema::create('sessions', function (Blueprint $collection) {
            $collection->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('users');
        Schema::drop('password_reset_tokens');
        Schema::drop('sessions');
    }
};
