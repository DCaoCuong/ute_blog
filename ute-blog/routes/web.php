<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/test_db', function () {
    try {
        // Thử ping đến database
        $connection = DB::connection('mongodb');
        $msg = "Kết nối MongoDB thành công! Database: " . $connection->getDatabaseName();
        return $msg;
    } catch (\Exception $e) {
        return "Lỗi kết nối: " . $e->getMessage();
    }
});
