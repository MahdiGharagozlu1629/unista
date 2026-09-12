<?php

namespace App\Http\Controllers\Client;

use App\Models\Story;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function create()
    {
        return view('Client::story.create');
    }

    public function store(Request $request)
    {
        $media = $request->media ?? [];

        if (empty($media)) {
            return redirect()->back()->with('error', 'لطفاً حداقل یک عکس یا ویدیو برای استوری انتخاب کنید.');
        }

        $data = [];
        foreach ($media as $file) {
            $data[] = [
                'user_id' => Auth::guard('client')->id(),
                'media' => $file,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        Story::insert($data);

        return redirect()->route('index')->with('success', 'استوری با موفقیت ثبت شد.');
    }

    public function show($userId = null)
    {
        $targetUserId = $userId ?: Auth::guard('client')->id();
        return redirect()->route('index', ['open_story' => $targetUserId]);
    }

    public function destroy($id)
    {
        $story = Story::where('id', $id)
            ->where('user_id', Auth::guard('client')->id())
            ->first();

        if ($story) {
            $story->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'استوری یافت نشد'], 404);
    }
}
