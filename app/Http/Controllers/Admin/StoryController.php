<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::with(['user', 'mediaItem'])
            ->latest()
            ->paginate(15);

        return view('admin.stories.index', compact('stories'));
    }

    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        $story->delete();

        return redirect()->route('admin.stories.index')->with('success', 'استوری با موفقیت حذف شد');
    }

    public function archivedStories()
    {
        $stories = Story::query()
            ->onlyTrashed()
            ->join('media', 'stories.media', '=', 'media.id')
            ->withTrashed()
            ->orderBy('stories.id', 'desc')
            ->paginate(15);

        return view('admin.stories.archived-story', compact('stories'));
    }
}
