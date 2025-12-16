<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Department;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Featured posts (pinned or featured)
        $featuredPosts = Post::published()
            ->where(function ($q) {
                $q->where('is_featured', true)
                    ->orWhere('is_pinned', true);
            })
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Latest news
        $latestNews = Post::published()
            ->where('type', Post::TYPE_NEWS)
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        // Upcoming events
        $upcomingEvents = Post::published()
            ->where('type', Post::TYPE_EVENT)
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(4)
            ->get();

        // Departments for quick links
        $departments = Department::orderBy('order', 'asc')
            ->take(8)
            ->get();

        return view('frontend.home', compact(
            'featuredPosts',
            'latestNews',
            'upcomingEvents',
            'departments'
        ));
    }
}
