<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostAction extends Model
{
    use HasFactory;

    const LIKE = 1;
    const SAVE = 2;

    protected $table = 'post_actions';

    protected $fillable = [
        'post_id',
        'user_id',
        'type',
    ];

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
