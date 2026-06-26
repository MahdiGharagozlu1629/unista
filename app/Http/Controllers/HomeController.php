<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->where('user_id', '!=', auth()->id())
            ->with('user')
            ->get();

        foreach ($posts as $post) {
            $mediaIds = json_decode($post->media, true);
            $media = Media::query()
                ->whereIn('id' , $mediaIds)
                ->select('media.name')
                ->get();

            $post->media = $media;
        }

        return view('Client::index' , compact('posts'));
    }
}
