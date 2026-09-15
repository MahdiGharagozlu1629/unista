<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::with(['userOne', 'userTwo'])
            ->withCount('messages')
            ->orderByRaw('COALESCE(last_message_at, updated_at) DESC')
            ->paginate(15);

        return view('admin.chats.index', compact('conversations'));
    }

    public function show($id)
    {
        $conversation = Conversation::with(['userOne', 'userTwo'])->findOrFail($id);
        $messages = Message::where('conversation_id', $conversation->id)
            ->with(['sender', 'receiver'])
            ->oldest()
            ->get();

        return view('admin.chats.show', compact('conversation', 'messages'));
    }

    public function destroy($id)
    {
        $conversation = Conversation::findOrFail($id);

        Message::where('conversation_id', $conversation->id)->delete();
        $conversation->delete();

        return redirect()->route('admin.chats.index')->with('success', 'گفت‌وگو و تمام پیام‌های آن با موفقیت حذف شدند');
    }

    public function destroyMessage($id)
    {
        $message = Message::findOrFail($id);
        $conversationId = $message->conversation_id;
        $message->delete();

        // Update conversation last message if needed
        $lastMsg = Message::where('conversation_id', $conversationId)->latest()->first();
        $conversation = Conversation::find($conversationId);
        if ($conversation) {
            $conversation->last_message = $lastMsg ? $lastMsg->body : null;
            $conversation->last_message_at = $lastMsg ? $lastMsg->created_at : null;
            $conversation->save();
        }

        return redirect()->back()->with('success', 'پیام با موفقیت حذف شد');
    }
}
