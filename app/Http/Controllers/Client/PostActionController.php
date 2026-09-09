<?php

namespace App\Http\Controllers\Client;

use App\Models\Post;
use App\Models\PostAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PostActionController extends Controller
{
    public function like(Request $request)
    {
        $postId = $request->post_id ?? $request->postId;
        $userId = Auth::guard('client')->id() ?? Auth::id();

        if (!$postId || !$userId) {
            return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
        }

        $likeExists = PostAction::query()
            ->where('post_id', $postId)
            ->where('user_id', $userId)
            ->where('type', PostAction::LIKE)
            ->exists();

        if (!$likeExists) {
            Post::findOrFail($postId);

            PostAction::create([
                'post_id' => $postId,
                'user_id' => $userId,
                'type' => PostAction::LIKE,
            ]);
        }

        return response()->json([
            'message' => 'Liked',
            'success' => true,
        ]);
    }

    public function save(Request $request)
    {
        $postId = $request->post_id ?? $request->postId;
        $userId = Auth::guard('client')->id() ?? Auth::id();

        if (!$postId || !$userId) {
            return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
        }

        $saveExists = PostAction::query()
            ->where('post_id', $postId)
            ->where('user_id', $userId)
            ->where('type', PostAction::SAVE)
            ->exists();

        if (!$saveExists) {
            Post::findOrFail($postId);

            PostAction::create([
                'post_id' => $postId,
                'user_id' => $userId,
                'type' => PostAction::SAVE,
            ]);
        }

        return response()->json([
            'message' => 'Saved',
            'success' => true,
        ]);
    }

    public function dislike(Request $request)
    {
        $postId = $request->post_id ?? $request->postId;
        $userId = Auth::guard('client')->id() ?? Auth::id();

        if (!$postId || !$userId) {
            return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
        }

        PostAction::query()
            ->where('post_id', $postId)
            ->where('user_id', $userId)
            ->where('type', PostAction::LIKE)
            ->delete();

        return response()->json([
            'message' => 'Disliked',
            'success' => true,
        ]);
    }

    public function removeSave(Request $request)
    {
        $postId = $request->post_id ?? $request->postId;
        $userId = Auth::guard('client')->id() ?? Auth::id();

        if (!$postId || !$userId) {
            return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
        }

        PostAction::query()
            ->where('post_id', $postId)
            ->where('user_id', $userId)
            ->where('type', PostAction::SAVE)
            ->delete();

        return response()->json([
            'message' => 'Unsaved',
            'success' => true,
        ]);
    }
}
