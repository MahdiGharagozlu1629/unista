<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = [
        'user_id',
        'have_comment',
        'content',
        'media',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes() : HasMany
    {
        return $this->hasMany(PostAction::class)->where('type', PostAction::LIKE);
    }

    public function saves() : HasMany
    {
        return $this->hasMany(PostAction::class)->where('type', PostAction::SAVE);
    }
}
