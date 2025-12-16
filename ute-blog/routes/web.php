<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - UTE Blog
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

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

// Authentication Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/register/success', [AuthController::class, 'registerSuccess'])->name('register.success');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::post('users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
});
