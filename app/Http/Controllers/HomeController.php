<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Enums\FollowStatusEnum;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $followings = $user
            ->following()
            ->where('status', FollowStatusEnum::Accept->value)
            ->with('posts')
            ->get();

        $posts = [];
        foreach ($followings as $following) {
            $posts = $following->posts;

            foreach ($posts as $post) {
                $mediaIds = json_decode($post->media, true);
                $media = Media::query()
                    ->whereIn('id', $mediaIds)
                    ->select('media.name')
                    ->get();

                $post->media = $media;
            }

        }

        return view('Client::index', compact('posts'));
    }

    public function search(Request $request)
    {
        $query = trim((string)$request->input('q', ''));
        $currentUserId = auth('client')->id() ?? auth()->id();

        $ignoreIds = [$currentUserId, 1];
        $users = null;
        $posts = null;

        if (!empty($query)) {
            $users = User::query()
                ->when($currentUserId, fn($q) => $q->whereNotIn('id', $ignoreIds))
                ->where(function ($q) use ($query) {
                    $q->where('username', 'like', "%{$query}%")
                        ->orWhere('name', 'like', "%{$query}%")
                        ->orWhere('family', 'like', "%{$query}%");
                })
                ->take(30)
                ->get();

            $posts = Post::query()
                ->where('content', 'like', "%{$query}%")
                ->with('user')
                ->latest()
                ->take(30)
                ->get();
        } else {
            // Suggested accounts to discover
            $users = User::query()
                ->when($currentUserId, fn($q) => $q->whereNotIn('id', $ignoreIds))
                ->latest()
                ->take(8)
                ->get();

            // Explore feed posts
            $posts = Post::query()
                ->with('user')
                ->latest()
                ->take(24)
                ->get();
        }

        foreach ($posts as $post) {
            $mediaIds = json_decode($post->media, true);
            if (!empty($mediaIds)) {
                $post->media_item = Media::query()
                    ->whereIn('id', $mediaIds)
                    ->select('media.name')
                    ->first();
                $post->media_count = count($mediaIds);
            }
        }

        return view('Client::search', compact('users', 'posts', 'query'));
    }
}
