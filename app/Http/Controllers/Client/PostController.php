<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        return view('Client::post.create');
    }

    public function store(Request $request)
    {
        Post::create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
            'have_comment' => $request->have_comment,
            'media' => json_encode($request->media),
        ]);

        return redirect()->route("index");
    }
}
