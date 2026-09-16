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
            'user_id' => auth()->guard('client')->id(),
            'name' => $filename,
            'type' => $file->getClientOriginalExtension(),
            'path' => 'posts'
        ]);

        return response()->json($media->id);

    }

    public function story(Request $request)
    {
        $file = $request->file('file');

        $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("public/story", $filename);
        $media = Media::create([
            'user_id' => auth()->guard('client')->id(),
            'name' => $filename,
            'type' => $file->getClientOriginalExtension(),
            'path' => 'story'
        ]);

        return response()->json($media->id);

    }

    public function profile(Request $request)
    {
        $file = $request->file('file') ?? $request->file('profile_image');
        if (!$file) {
            return response()->json(['error' => 'فایلی ارسال نشده است'], 400);
        }

        $userId = auth()->guard('client')->id();
        $filename = Str::random(12) . '.' . $file->getClientOriginalExtension();
        $file->storeAs("public/profile", $filename);

        $media = Media::create([
            'user_id' => $userId,
            'name' => $filename,
            'type' => $file->getClientOriginalExtension(),
            'path' => 'profile'
        ]);

        $user = auth()->guard('client')->user();
        if ($user) {
            $user->update(['profile_id' => $media->id]);
        }

        return response()->json([
            'id' => $media->id,
            'url' => asset("storage/profile/{$filename}"),
            'message' => 'عکس پروفایل با موفقیت بروزرسانی شد'
        ]);
    }
}
