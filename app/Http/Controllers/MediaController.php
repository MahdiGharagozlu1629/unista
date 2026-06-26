<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function create(Request $request)
    {
        $file = $request->file('file');

        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("public/posts", $filename);
        $media = Media::create([
            'user_id' => auth()->id(),
            'name' => $filename,
            'type' => $file->getClientOriginalExtension(),
            'path' => 'posts'
        ]);

        return response()->json($media->id);

    }
}
