<?php

namespace Sndpbag\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Sndpbag\AdminPanel\Models\User;
 

class BlogLike extends Model
{
            protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];
    
     /**
     * Get the member that gave the like.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the owning likeable model (e.g., Blog or Comment).
     */
    public function likeable(): MorphTo
    {
        // 'likeable' এখানে মাইগ্রেশনে ব্যবহৃত morphs() মেথডের নাম।
        return $this->morphTo();
    }
}
