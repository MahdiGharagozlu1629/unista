<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, softDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'family',
        'phone',
        'national_code',
        'student_code',
        'profile_id'
    ];

    protected $hidden = [
        'password'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function following() : BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_follows',
            'follower_id',
            'following_id')
            ->withTimestamps();
    }

    public function follower() : BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'user_follows',
            'following_id',
            'follower_id')
            ->withTimestamps();
    }

    public function stories() : HasMany
    {
        return $this->hasMany(Story::class);
    }

    public function conversations()
    {
        return Conversation::query()
            ->where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id)
            ->orderBy('last_message_at', 'desc');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'profile_id');
    }

    public function profileMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'profile_id');
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->profile && $this->profile->name) {
            $folder = $this->profile->path ?: 'profile';
            return asset("storage/{$folder}/{$this->profile->name}");
        }
        return asset('img/profile.jpg');
    }
}
