<?php

namespace Sndpbag\Blog\Mail; // <-- প্যাকেজের namespace

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Sndpbag\Blog\Models\Subscriber; // <-- প্যাকেজের Subscriber মডেল

class VerifySubscriptionEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Subscriber $subscriber;
    public string $verificationUrl;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
        // namespace অনুযায়ী রুটের নাম ঠিক রাখুন (ধাপ ৪ দেখুন)
        $this->verificationUrl = route('blog.newsletter.verify', ['token' => $subscriber->verification_token]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email for Our Newsletter',
        );
    }

    public function content(): Content
    {
        // প্যাকেজের ভিউ ব্যবহার করার জন্য namespace সহ পাথ দিতে হবে
        return new Content(
            markdown: 'blog::emails.newsletter.verify', // <-- 'blog::' prefix ব্যবহার করুন
            with: [
                'url' => $this->verificationUrl,
                'email' => $this->subscriber->email,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}