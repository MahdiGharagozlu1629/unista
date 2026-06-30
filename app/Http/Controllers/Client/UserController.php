<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        return view('Client::profile', compact('user'));
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

        return view('Client::user.index', compact('user'));
    }
}
