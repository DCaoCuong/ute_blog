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
        Schema::create('jobs', function (Blueprint $collection) {
            $collection->index('queue');
        });

        Schema::create('job_batches', function (Blueprint $collection) {
            $collection->index('batch_id');
        });

        Schema::create('failed_jobs', function (Blueprint $collection) {
            $collection->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('jobs');
        Schema::drop('job_batches');
        Schema::drop('failed_jobs');
    }
};
