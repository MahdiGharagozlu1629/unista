<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Media;
use App\Models\Story;
use App\Models\PostAction;
use Illuminate\Http\Request;
use App\Enums\FollowStatusEnum;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('client')->user() ?? auth()->user();

        // 1. Followings
        $followings = $user
            ->following()
            ->where('status', FollowStatusEnum::Accept->value)
            ->with('posts')
            ->get();

        $followingIds = $followings->pluck('id')->toArray();

        // 2. Active Stories (created in the last 24 hours)
        // A. Current user's stories
        $myStories = Story::query()
            ->where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDay())
            ->with('mediaItem')
            ->orderBy('created_at', 'asc')
            ->get();

        // B. Followings active stories
        $otherStories = Story::query()
            ->where('created_at', '>=', now()->subDay())
            ->where('user_id', '!=', $user->id)
            ->whereIn('user_id', $followingIds)
            ->with(['user', 'mediaItem'])
            ->orderBy('created_at', 'asc')
            ->get();

        // If followings don't have stories yet, include other active public stories for discovery/testing
        if ($otherStories->isEmpty()) {
            $otherStories = Story::query()
                ->where('created_at', '>=', now()->subDay())
                ->where('user_id', '!=', $user->id)
                ->with(['user', 'mediaItem'])
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // Group other users' stories by user_id
        $groupedStories = $otherStories->groupBy('user_id');

        // Build structured array for JS Story Viewer
        $storyGroups = [];

        // My stories first if any
        if ($myStories->isNotEmpty()) {
            $storyGroups[] = [
                'user_id' => $user->id,
                'username' => $user->username,
                'fullname' => trim($user->name . ' ' . $user->family),
                'avatar' => asset('img/profile.jpg'),
                'is_me' => true,
                'profile_url' => route('profile'),
                'stories' => $myStories->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'media_url' => $s->media_url,
                        'is_video' => $s->is_video,
                        'created_at_human' => $s->created_at->diffForHumans(),
                        'created_at' => $s->created_at->toISOString(),
                        'delete_url' => route('story.destroy', ['id' => $s->id]),
                    ];
                })->values()->toArray(),
            ];
        }

        // Other users' stories
        foreach ($groupedStories as $storyUserId => $stories) {
            $storyUser = $stories->first()->user;
            if (!$storyUser) continue;

            $storyGroups[] = [
                'user_id' => $storyUser->id,
                'username' => $storyUser->username,
                'fullname' => trim($storyUser->name . ' ' . $storyUser->family),
                'avatar' => asset('img/profile.jpg'),
                'is_me' => false,
                'profile_url' => route('users.show', ['id' => $storyUser->id]),
                'stories' => $stories->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'media_url' => $s->media_url,
                        'is_video' => $s->is_video,
                        'created_at_human' => $s->created_at->diffForHumans(),
                        'created_at' => $s->created_at->toISOString(),
                        'delete_url' => null,
                    ];
                })->values()->toArray(),
            ];
        }

        // 3. Posts
        $posts = Post::query()
            ->whereIn('user_id', $followingIds)
            ->with(['user', 'comments', 'likes', 'saves'])
            ->latest()
            ->get();

        if ($posts->isEmpty()) {
            $posts = Post::with(['user', 'comments', 'likes', 'saves'])->latest()->take(20)->get();
        }

        foreach ($posts as $post) {
            $post->liked = $user->id ? $post->likes->contains('user_id', $user->id) : false;
            $post->saved = $user->id ? $post->saves->contains('user_id', $user->id) : false;

            $mediaIds = json_decode($post->media, true);
            if (!empty($mediaIds)) {
                $post->media = Media::query()
                    ->whereIn('id', $mediaIds)
                    ->select('media.name')
                    ->get();
            } else {
                $post->media = collect();
            }
        }

        $openStoryUserId = $request->query('open_story') ?? null;

        return view('Client::index', compact('posts', 'myStories', 'groupedStories', 'storyGroups', 'openStoryUserId'));
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
