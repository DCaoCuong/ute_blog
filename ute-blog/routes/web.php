<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\DepartmentController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - UTE Blog
|--------------------------------------------------------------------------
*/

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

// Test MongoDB connection
Route::get('/test_database', function () {
    try {
        $connection = DB::connection('mongodb');
        $msg = "Kết nối MongoDB thành công! Database: " . $connection->getDatabaseName();
        return $msg;
    } catch (\Exception $e) {
        return "Lỗi kết nối: " . $e->getMessage();
    }
});

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
});

// ===== ADMIN ROUTES =====

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::post('users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
});