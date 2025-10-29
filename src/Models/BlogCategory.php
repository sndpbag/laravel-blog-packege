<?php

namespace Sndpbag\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sndpbag\Blog\Models\Blog;

class BlogCategory extends Model
{

        use   SoftDeletes;


        protected $fillable = ['name', 'slug', 'status'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id');
       
    }
}
