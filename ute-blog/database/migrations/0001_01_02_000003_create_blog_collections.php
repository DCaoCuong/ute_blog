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
        Schema::create('posts', function (Blueprint $collection) {
            $collection->index('slug');
            $collection->index('status');
            $collection->index('category_id');
            $collection->index('author_id');
            $collection->index('published_at');
        });

        Schema::create('categories', function (Blueprint $collection) {
            $collection->index('slug');
            $collection->index('parent_id');
        });

        Schema::create('departments', function (Blueprint $collection) {
            $collection->index('slug');
            $collection->index('type');
            $collection->index('parent_id');
        });

        Schema::create('pages', function (Blueprint $collection) {
            $collection->index('slug');
        });

        Schema::create('comments', function (Blueprint $collection) {
            $collection->index('post_id');
            $collection->index('user_id');
            $collection->index('status');
        });

        Schema::create('menus', function (Blueprint $collection) {
            $collection->index('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('posts');
        Schema::drop('categories');
        Schema::drop('departments');
        Schema::drop('pages');
        Schema::drop('comments');
        Schema::drop('menus');
    }
};
