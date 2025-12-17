<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display listing of news posts
     */
    public function news(Request $request)
    {
        $query = Post::published()->where('type', Post::TYPE_NEWS);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('frontend.posts.news', compact('posts', 'categories'));
    }

    /**
     * Display listing of events
     */
    public function events(Request $request)
    {
        $query = Post::published()->where('type', Post::TYPE_EVENT);

        // Filter: upcoming or past
        if ($request->filter === 'past') {
            $query->where('event_date', '<', now());
        } else {
            $query->where('event_date', '>=', now());
        }

        $posts = $query->orderBy('event_date', 'asc')->paginate(12);

        return view('frontend.posts.events', compact('posts'));
    }

    /**
     * Display single post detail
     */
    public function show(string $slug)
    {
        $post = Post::published()->where('slug', $slug)
            ->with([
                'comments' => function ($query) {
                    $query->approved()->orderBy('created_at', 'desc');
                },
                'comments.user'
            ])
            ->firstOrFail();

        // Increment view count
        $post->incrementViews();

        // Related posts
        $relatedPosts = Post::published()
            ->where('_id', '!=', $post->_id)
            ->where('type', $post->type)
            ->when($post->category_id, function ($q) use ($post) {
                $q->where('category_id', $post->category_id);
            })
            ->orderBy('published_at', 'desc')
            ->take(4)
            ->get();

        return view('frontend.posts.show', compact('post', 'relatedPosts'));
    }
}
