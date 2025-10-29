<?php

namespace Sndpbag\Blog\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Sndpbag\Blog\Models\Blog;

class NewBlogPostNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Blog $blog;
    public string $url;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
        // ফ্রন্টএন্ডে ব্লগের URL তৈরি করা
        $this->url = route('frontend.blog.show', $blog->slug);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Post Alert: ' . $this->blog->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            // সঠিক নেমস্পেস ব্যবহার করা হলো
            markdown: 'blog::emails.blog.new-post-notification',
            with: [
                'blog' => $this->blog,
                'url' => $this->url,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}