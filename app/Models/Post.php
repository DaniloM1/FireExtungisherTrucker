<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'thumbnail', 'body', 'user_id', 'active', 'published_at', 'meta_title', 'meta_description'];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getThumbnailUrlAttribute(): string
    {
        // Pretpostavljamo da je u bazi spremljen relativni path unutar storage disk-a (npr. "thumbnails/ime.jpg")
        return Storage::url($this->thumbnail);
    }
    // U app/Models/Post.php
    public function getRouteKeyName()
    {
        return 'slug';
    }


}
