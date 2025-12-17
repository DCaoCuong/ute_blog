<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, string $postId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post = Post::findOrFail($postId);

        // Create comment
        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->content = $request->input('content');

        // Auto-approve for now, or use pending if moderation is required
        $comment->status = Comment::STATUS_APPROVED;

        $comment->save();

        // Notify Node.js server
        try {
            \Illuminate\Support\Facades\Http::post('http://localhost:3000/api/comments/notify', [
                'id' => $comment->id,
                'post_id' => $comment->post_id,
                'user_name' => $comment->user->name,
                'user_avatar' => $comment->user->profile_photo_url ?? null, // Taking a guess at avatar, or just use name
                'content' => $comment->content,
                'created_at' => $comment->created_at->format('d M Y, h:i A'),
            ]);
        } catch (\Exception $e) {
            // Log error or ignore if socket server is down
            // \Log::error('Socket server error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Bình luận của bạn đã được gửi thành công!');
    }
    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::findOrFail($id);

        // Authorization check: User must own the comment
        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa bình luận này.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->back()->with('success', 'Bình luận đã được cập nhật!');
    }
}
