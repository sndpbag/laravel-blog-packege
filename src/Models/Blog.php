<?php

 
namespace Sndpbag\Blog\Models;

use Sndpbag\Blog\Models\BlogCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sndpbag\AdminPanel\Models\User;
use Sndpbag\Blog\Models\BlogLike;

class Blog extends Model
{
        protected $fillable = [
    'title',
    'slug',
    'image',
    'published_date',
    'is_featured',
    'excerpt',
    'content',
    'category_id',
    'member_id',
    'author_type',
    'author_id',
    'meta_title',
    'meta_description',
    'likes',
    'views',
    'tags',
    'status',
    'word_count',
    'reading_time'
];


protected $casts = [
    'published_date' => 'date',  
];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function user()
{
    return $this->belongsTo(user::class, 'user_id');
}

 public function author()
    {
        return $this->morphTo();
    }


 
    public function comments(): HasMany
    {
        //  this blog many comment
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the likes for the blog post.
     */
    public function likes(): MorphMany
    {
        //  many like a blog
        return $this->morphMany(BlogLike::class, 'likeable');
    }
}
