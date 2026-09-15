<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with(['user', 'comments.user', 'likes.user'])->findOrFail($id);

        return view('admin.posts.show', compact('post'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Delete associated comments and actions
        $post->comments()->delete();
        $post->likes()->delete();
        $post->saves()->delete();
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'پست با موفقیت حذف شد');
    }
}
