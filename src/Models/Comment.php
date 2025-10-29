<?php

namespace Sndpbag\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sndpbag\AdminPanel\Models\User;

class Comment extends Model
{
         protected $fillable = [
        'blog_id',
        'user_id',
        'body',
        'parent_id',
        'status', // 'status' কলামটিও যোগ করতে হবে।
    ];
        /**
     * Get the blog that the comment belongs to.
     */
    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }



    /**
     * Get the member that wrote the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment (for replies).
     */
    public function parent(): BelongsTo
    {
        // একটি কমেন্টের একটি প্যারেন্ট কমেন্ট থাকতে পারে।
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the replies for the comment.
     */
    public function replies(): HasMany
    {
        // একটি কমেন্টের অনেক রিপ্লাই থাকতে পারে।
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Get the likes for the comment.
     */
    public function likes(): MorphMany
    {
        // একটি কমেন্টে অনেক লাইক থাকতে পারে।
        return $this->morphMany(BlogLike::class, 'likeable');
    }
}
