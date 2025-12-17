<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Department;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Global search across posts and departments
     */
    public function index(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'all'); // all, posts, departments

        if (empty($query)) {
            return view('frontend.search', [
                'query' => '',
                'posts' => collect(),
                'departments' => collect(),
                'type' => $type,
            ]);
        }

        $results = [
            'posts' => collect(),
            'departments' => collect(),
        ];

        // Search in Posts
        if ($type === 'all' || $type === 'posts') {
            $results['posts'] = Post::published()
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                        ->orWhere('excerpt', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
                })
                ->orderBy('published_at', 'desc')
                ->limit(20)
                ->get();
        }

        // Search in Departments
        if ($type === 'all' || $type === 'departments') {
            $results['departments'] = Department::where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%");
            })
                ->orderBy('order', 'asc')
                ->limit(10)
                ->get();
        }

        return view('frontend.search', [
            'query' => $query,
            'posts' => $results['posts'],
            'departments' => $results['departments'],
            'type' => $type,
        ]);
    }

    /**
     * Autocomplete suggestions for search
     */
    public function autocomplete(Request $request)
    {
        $query = $request->input('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = [];

        // Get post titles
        $posts = Post::published()
            ->where('title', 'like', "%{$query}%")
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get(['title', 'slug', 'type']);

        foreach ($posts as $post) {
            $suggestions[] = [
                'title' => $post->title,
                'url' => route('post.show', $post->slug),
                'type' => $post->type === 'event' ? 'Sự kiện' : 'Tin tức',
            ];
        }

        // Get department names
        $departments = Department::where('name', 'like', "%{$query}%")
            ->orderBy('order', 'asc')
            ->limit(3)
            ->get(['name', 'slug']);

        foreach ($departments as $dept) {
            $suggestions[] = [
                'title' => $dept->name,
                'url' => route('department.show', $dept->slug),
                'type' => 'Đơn vị',
            ];
        }

        return response()->json($suggestions);
    }
}
