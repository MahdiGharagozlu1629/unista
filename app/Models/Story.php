<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stories';

    protected $fillable = [
        'user_id',
        'media'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mediaItem() : BelongsTo
    {
        return $this->belongsTo(Media::class, 'media', 'id');
    }

    public function getMediaUrlAttribute(): ?string
    {
        if ($this->mediaItem) {
            return asset("storage/story/{$this->mediaItem->name}");
        }
        return null;
    }

    public function getIsVideoAttribute(): bool
    {
        if ($this->mediaItem) {
            return in_array(strtolower((string)$this->mediaItem->type), ['mp4', 'mov', 'webm', 'ogg']);
        }
        return false;
    }
}
