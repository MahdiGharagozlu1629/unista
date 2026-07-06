<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserFollow extends Model
{
    use HasFactory;

    protected $table = 'user_follows';

    protected $fillable = [
        'status',
        'follower_id',
        'following_id',
    ];

    public function followers() : BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function followings() : BelongsTo
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
