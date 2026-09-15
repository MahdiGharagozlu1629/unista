<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversations';

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'last_message',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'conversation_id')->latestOfMany();
    }

    /**
     * Get or create a conversation between two users canonically.
     */
    public static function getOrCreateBetween($userId1, $userId2): self
    {
        $minId = min($userId1, $userId2);
        $maxId = max($userId1, $userId2);

        return self::firstOrCreate(
            ['user_one_id' => $minId, 'user_two_id' => $maxId],
            ['last_message_at' => now()]
        );
    }

    /**
     * Get the other user in the conversation.
     */
    public function getOtherUser($currentUserId)
    {
        if ($this->user_one_id == $currentUserId) {
            return $this->userTwo;
        }
        return $this->userOne;
    }

    /**
     * Get unread messages count for a specific user.
     */
    public function unreadCountFor($currentUserId): int
    {
        return $this->messages()
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->count();
    }
}
