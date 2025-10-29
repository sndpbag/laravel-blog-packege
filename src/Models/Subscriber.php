<?php

namespace Sndpbag\Blog\Models; // <-- প্যাকেজের namespace

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// আপনার User মডেলের সঠিক namespace ব্যবহার করুন
use Sndpbag\AdminPanel\Models\User; // <-- AdminPanel প্যাকেজের User মডেল

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'verification_token',
        'email_verified_at',
        'subscribed_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscribed_at' => 'datetime',
    ];

    // User মডেলের সাথে রিলেশন
    public function user()
    {
        // User মডেলের ক্লাস এখানে দিন
        return $this->belongsTo(User::class);
    }
}