<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display the chat index with conversations and optional active thread.
     */
    public function index(Request $request, $conversationId = null)
    {
        $currentUserId = Auth::guard('client')->id() ?? Auth::id();

        // If user_id is requested via query param, get or create conversation with that user
        if ($request->has('user_id')) {
            $targetUserId = (int)$request->get('user_id');
            if ($targetUserId !== (int)$currentUserId) {
                User::findOrFail($targetUserId);
                $conv = Conversation::getOrCreateBetween($currentUserId, $targetUserId);
                return redirect()->route('chat.show', ['conversationId' => $conv->id]);
            }
        }

        // Fetch all conversations for current user
        $conversations = Conversation::query()
            ->where('user_one_id', $currentUserId)
            ->orWhere('user_two_id', $currentUserId)
            ->with(['userOne', 'userTwo', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        foreach ($conversations as $conversation) {
            $conversation->other_user = $conversation->getOtherUser($currentUserId);
            $conversation->unread_count = $conversation->unreadCountFor($currentUserId);
        }

        $activeConversation = null;
        $messages = collect();

        if ($conversationId) {
            $activeConversation = $conversations->firstWhere('id', (int)$conversationId);

            if (!$activeConversation) {
                $activeConversation = Conversation::where('id', $conversationId)
                    ->where(function ($q) use ($currentUserId) {
                        $q->where('user_one_id', $currentUserId)
                          ->orWhere('user_two_id', $currentUserId);
                    })
                    ->with(['userOne', 'userTwo'])
                    ->firstOrFail();

                $activeConversation->other_user = $activeConversation->getOtherUser($currentUserId);
                $activeConversation->unread_count = $activeConversation->unreadCountFor($currentUserId);
            }

            // Load messages
            $messages = Message::where('conversation_id', $activeConversation->id)
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->take(100)
                ->get();

            // Mark unread messages as read
            Message::where('conversation_id', $activeConversation->id)
                ->where('receiver_id', $currentUserId)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            $activeConversation->unread_count = 0;
        }

        $currentUser = Auth::guard('client')->user() ?? Auth::user();

        return view('Client::chat.index', compact(
            'conversations',
            'activeConversation',
            'messages',
            'currentUserId',
            'currentUser'
        ));
    }

    /**
     * Start chat with a specific user.
     */
    public function startChat($userId)
    {
        $currentUserId = Auth::guard('client')->id() ?? Auth::id();

        if ((int)$userId === (int)$currentUserId) {
            return redirect()->route('chat.index');
        }

        User::findOrFail($userId);
        $conversation = Conversation::getOrCreateBetween($currentUserId, $userId);

        return redirect()->route('chat.show', ['conversationId' => $conversation->id]);
    }

    /**
     * Fetch messages JSON for a conversation.
     */
    public function fetchMessages($conversationId)
    {
        $currentUserId = Auth::guard('client')->id() ?? Auth::id();

        $conversation = Conversation::where('id', $conversationId)
            ->where(function ($q) use ($currentUserId) {
                $q->where('user_one_id', $currentUserId)
                  ->orWhere('user_two_id', $currentUserId);
            })
            ->firstOrFail();

        $messages = Message::where('conversation_id', $conversation->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->take(100)
            ->get();

        // Mark as read
        Message::where('conversation_id', $conversation->id)
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'conversation_id' => $msg->conversation_id,
                    'sender_id' => $msg->sender_id,
                    'receiver_id' => $msg->receiver_id,
                    'body' => $msg->body,
                    'is_read' => $msg->is_read,
                    'time_formatted' => $msg->time_formatted,
                    'time_human' => $msg->time_human,
                    'created_at' => $msg->created_at->toISOString(),
                    'sender_username' => $msg->sender->username ?? '',
                    'sender_avatar' => $msg->sender->avatar_url ?? asset('img/profile.jpg'),
                ];
            })
        ]);
    }

    /**
     * Send a new message via AJAX.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:3000',
            'conversation_id' => 'nullable|integer',
            'receiver_id' => 'nullable|integer',
        ]);

        $currentUserId = Auth::guard('client')->id() ?? Auth::id();
        $receiverId = $request->receiver_id;
        $conversationId = $request->conversation_id;

        if ($conversationId) {
            $conversation = Conversation::where('id', $conversationId)
                ->where(function ($q) use ($currentUserId) {
                    $q->where('user_one_id', $currentUserId)
                      ->orWhere('user_two_id', $currentUserId);
                })
                ->firstOrFail();

            $receiverId = ($conversation->user_one_id == $currentUserId)
                ? $conversation->user_two_id
                : $conversation->user_one_id;
        } elseif ($receiverId) {
            if ((int)$receiverId === (int)$currentUserId) {
                return response()->json(['success' => false, 'message' => 'ارسال پیام به خود امکان‌پذیر نیست.'], 422);
            }
            User::findOrFail($receiverId);
            $conversation = Conversation::getOrCreateBetween($currentUserId, $receiverId);
        } else {
            return response()->json(['success' => false, 'message' => 'مخاطب یا مکالمه نامعتبر است.'], 422);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $currentUserId,
            'receiver_id' => $receiverId,
            'body' => $request->body,
            'is_read' => false,
        ]);

        // Update conversation last message & time
        $conversation->update([
            'last_message' => mb_substr($request->body, 0, 120),
            'last_message_at' => now(),
        ]);

        $message->load('sender');

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'conversation_id' => $conversation->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'body' => $message->body,
                'is_read' => false,
                'time_formatted' => $message->time_formatted,
                'time_human' => $message->time_human,
                'created_at' => $message->created_at->toISOString(),
                'sender_username' => $message->sender->username ?? '',
                'sender_avatar' => $message->sender->avatar_url ?? asset('img/profile.jpg'),
            ]
        ]);
    }

    /**
     * Mark conversation messages as read.
     */
    public function markAsRead($conversationId)
    {
        $currentUserId = Auth::guard('client')->id() ?? Auth::id();

        Message::where('conversation_id', $conversationId)
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
