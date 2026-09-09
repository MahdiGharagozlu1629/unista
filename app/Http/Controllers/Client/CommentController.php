<?php

namespace App\Http\Controllers\Client;

use App\Models\Post;
use App\Models\Media;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function postComments($postId)
    {
        $currentUserId = Auth::guard('client')->id() ?? Auth::id();

        $post = Post::query()
            ->where('id', $postId)
            ->with(['user', 'likes', 'saves', 'comments' => function ($q) {
                $q->latest();
            }, 'comments.user'])
            ->firstOrFail();

        $post->liked = $currentUserId ? $post->likes->contains('user_id', $currentUserId) : false;
        $post->saved = $currentUserId ? $post->saves->contains('user_id', $currentUserId) : false;

        $mediaIds = json_decode($post->media, true);

        if (!empty($mediaIds)) {
            $post->media = Media::query()
                ->whereIn('id', $mediaIds)
                ->get();
        } else {
            $post->media = collect();
        }

        return view('Client::comment.index', compact('post'));
    }

    public function store(Request $request, $postId)
    {
        $request->validate([
            'text' => 'required|string|max:1000'
        ]);

        $post = Post::findOrFail($postId);

        if (!$post->have_comment) {
            return redirect()->back()->with('error', 'ثبت نظر برای این پست غیرفعال است.');
        }

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'text' => $request->text,
        ]);

        return redirect()->back()->with('success', 'نظر شما با موفقیت ثبت شد.');
    }

    public function destroy($id)
    {
        $comment = Comment::with('post')->findOrFail($id);

        if ($comment->user_id == Auth::id() || ($comment->post && $comment->post->user_id == Auth::id())) {
            $comment->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'دسترسی غیرمجاز'], 403);
    }
}
