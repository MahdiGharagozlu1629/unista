<?php

namespace App\Http\Controllers;

use App\Models\Media;
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

    public function search()
    {

    }
}
