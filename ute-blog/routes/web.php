<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\DepartmentController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// ===== PUBLIC ROUTES =====

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// News
Route::get('/tin-tuc', [PostController::class, 'news'])->name('news');

// Events
Route::get('/su-kien', [PostController::class, 'events'])->name('events');

// Single Post
Route::get('/bai-viet/{slug}', [PostController::class, 'show'])->name('post.show');

// Departments
Route::get('/don-vi', [DepartmentController::class, 'index'])->name('departments');
Route::get('/don-vi/{slug}', [DepartmentController::class, 'show'])->name('department.show');

// Search
Route::get('/tim-kiem', [SearchController::class, 'index'])->name('search');
Route::get('/api/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

// Static Pages (placeholder)
Route::get('/gioi-thieu', function () {
    return view('frontend.pages.about');
})->name('page.about');

// // Test MongoDB connection
// Route::get('/test_database', function () {
//     try {
//         $connection = DB::connection('mongodb');
//         $msg = "Kết nối MongoDB thành công! Database: " . $connection->getDatabaseName();
//         return $msg;
//     } catch (\Exception $e) {
//         return "Lỗi kết nối: " . $e->getMessage();
//     }
// });

// ===== AUTHENTICATION ROUTES =====

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/register/success', [AuthController::class, 'registerSuccess'])->name('register.success');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Comments
    Route::post('/bai-viet/{post}/comment', [\App\Http\Controllers\Frontend\CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [\App\Http\Controllers\Frontend\CommentController::class, 'update'])->name('comments.update');
});

// ===== SHARED ADMIN ROUTES (Both Admin & Content Manager) =====

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    // Dashboard - accessible by both Admin and Content Manager
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});

// ===== ADMIN ROUTES (Admin Only - User & Department Management) =====

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // User Management (Admin Only)
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::post('users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');
    Route::post('users/bulk-approve', [AdminUserController::class, 'bulkApprove'])->name('users.bulkApprove');

    // Department Management (Admin Only)
    Route::resource('departments', AdminDepartmentController::class);
});

// ===== CONTENT MANAGER ROUTES (Content Manager ONLY - Posts & Events) =====

Route::prefix('admin')->middleware(['auth', 'content_manager'])->name('admin.')->group(function () {
    // Post Management (News & Events) - Content Manager ONLY
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::post('posts/{post}/publish', [\App\Http\Controllers\Admin\PostController::class, 'publish'])->name('posts.publish');
    Route::post('posts/{post}/unpublish', [\App\Http\Controllers\Admin\PostController::class, 'unpublish'])->name('posts.unpublish');

    // Image Upload for Posts
    Route::post('images/upload', [\App\Http\Controllers\Admin\ImageUploadController::class, 'upload'])->name('images.upload');
    Route::delete('images/delete', [\App\Http\Controllers\Admin\ImageUploadController::class, 'delete'])->name('images.delete');

    // Category Management - Content Manager ONLY
    // Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
});