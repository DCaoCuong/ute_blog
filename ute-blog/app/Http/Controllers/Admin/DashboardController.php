<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'pending_users' => User::where('status', User::STATUS_PENDING)->count(),
            'active_users' => User::where('status', User::STATUS_ACTIVE)->count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', Post::STATUS_PUBLISHED)->count(),
        ];

        $pendingUsers = User::where('status', User::STATUS_PENDING)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingUsers'));
    }
}
