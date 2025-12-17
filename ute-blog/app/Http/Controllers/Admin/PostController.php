<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of posts
     */
    public function index(Request $request)
    {
        $query = Post::query()->with(['category', 'author']);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = Category::orderBy('name')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new post
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.posts.create', compact('categories', 'departments'));
    }

    /**
     * Store a newly created post
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug',
            'type' => 'required|in:news,event',
            'status' => 'required|in:draft,published',
            'category_id' => 'nullable|string',
            'department_id' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|string',
            'images' => 'nullable|string',
            'event_date' => 'nullable|date',
            'event_location' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
        ]);

        $data = $request->all();
        $data['author_id'] = auth()->id();

        // Handle checkbox fields (not sent when unchecked)
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_pinned'] = $request->boolean('is_pinned');

        // Decode images JSON string to array
        if ($request->filled('images')) {
            $data['images'] = json_decode($request->images, true);
        }

        if ($request->status === 'published' && !$request->filled('published_at')) {
            $data['published_at'] = now();
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Tạo bài viết thành công!');
    }

    /**
     * Show the form for editing a post
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories', 'departments'));
    }

    /**
     * Update the specified post
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:posts,slug,' . $id . ',_id',
            'type' => 'required|in:news,event',
            'status' => 'required|in:draft,published',
            'category_id' => 'nullable|string',
            'department_id' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|string',
            'images' => 'nullable|string',
            'event_date' => 'nullable|date',
            'event_location' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
        ]);

        $data = $request->all();

        // Handle checkbox fields (not sent when unchecked)
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_pinned'] = $request->boolean('is_pinned');

        // Decode images JSON string to array
        if ($request->filled('images')) {
            $data['images'] = json_decode($request->images, true);
        }

        // Update published_at when changing from draft to published
        if ($request->status === 'published' && $post->status === 'draft') {
            $data['published_at'] = now();
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Cập nhật bài viết thành công!');
    }

    /**
     * Remove the specified post
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Xóa bài viết thành công!');
    }

    /**
     * Quick publish a draft post
     */
    public function publish(string $id)
    {
        $post = Post::findOrFail($id);

        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', "Đã xuất bản bài viết: {$post->title}");
    }

    /**
     * Quick unpublish a post
     */
    public function unpublish(string $id)
    {
        $post = Post::findOrFail($id);

        $post->update(['status' => 'draft']);

        return back()->with('success', "Đã chuyển bài viết về nháp: {$post->title}");
    }
}
