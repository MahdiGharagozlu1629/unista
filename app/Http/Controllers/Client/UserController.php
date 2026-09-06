<?php

namespace App\Http\Controllers\Client;

use App\Enums\FollowStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $user['posts'] = $user->posts;

        foreach ($user->posts as $post) {
            $mediaIds = json_decode($post->media, true);
            $media = Media::query()
                ->whereIn('id' , $mediaIds)
                ->select('media.name')
                ->first();

            $post->media = $media;
        }

        $hasActiveStory = $user->stories()->where('created_at', '>=', now()->subDay())->exists();

        return view('Client::profile', compact('user', 'hasActiveStory'));
    }

    public function show($id)
    {
        $user = User::query()
            ->with('posts')
            ->findOrFail($id);

        foreach ($user->posts as $post) {
            $mediaIds = json_decode($post->media, true);
            $media = Media::query()
                ->whereIn('id' , $mediaIds)
                ->select('media.name')
                ->first();

            $post->media = $media;
        }

        $currentUser = Auth::user();

        $hasFollowing = $currentUser->following()->where('following_id' , $user->id)->exists();
        $hasActiveStory = $user->stories()->where('created_at', '>=', now()->subDay())->exists();

        return view('Client::user.index', compact('user' , 'hasFollowing', 'hasActiveStory'));
    }

    public function follow(Request $request)
    {
        $followerId = Auth::id();
        $followingId = $request->following_id;

        /**
         * @var User $user
         */

        $user = User::query()
            ->findOrFail($followerId);

        $user->following()->attach($followingId);

        return redirect()->back();
    }

    public function unfollow(Request $request)
    {
        $followerId = Auth::id();
        $followingId = $request->following_id;

        /**
         * @var User $user
         */

        $user = User::query()
            ->findOrFail($followerId);

        $user->following()->detach($followingId);

        return redirect()->back();
    }

    public function followRequests()
    {
        $user = Auth::user();

        $requests = UserFollow::query()
            ->where('user_follows.following_id' , $user->id)
            ->where('status' , FollowStatusEnum::Pending->value)
            ->with('followers')
            ->get();

        return view('Client::follow-requests', compact('user', 'requests'));
    }

    public function acceptFollow(Request $request)
    {
        $followRequest = UserFollow::query()
            ->where('user_follows.follower_id' , $request->follower_id)
            ->where('user_follows.following_id' , $request->user_id)
            ->first();

        $followRequest->update([
            'status' => FollowStatusEnum::Accept->value
        ]);

        return response()->json([
            'success' => true
        ]);

    }
}
