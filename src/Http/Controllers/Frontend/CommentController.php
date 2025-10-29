<?php

namespace Sndpbag\Blog\Http\Controllers\Frontend;

use Sndpbag\AdminPanel\Http\Controllers\Controller;
use Sndpbag\Blog\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //  public function like(Comment $comment)
    // {
    //     $user = auth()->user();
        
    //     $existingLike = $comment->likes()
    //         ->where('user_id', $user->id)
    //         ->first();
        
    //     if ($existingLike) {
    //         $existingLike->delete();
    //         $liked = false;
    //     } else {
    //         $comment->likes()->create(['user_id' => $user->id]);
    //         $liked = true;
    //     }
        
    //     return response()->json([
    //         'success' => true,
    //         'liked' => $liked,
    //         'likes' => $comment->likes()->count()
    //     ]);
    // }

    public function like(Comment $comment) // <-- কমেন্ট মডেল এখানে ঠিকমতো আসছে কিনা দেখতে হবে
    {
        $user = auth()->user(); // <-- লগইন করা ইউজার পাওয়া যাচ্ছে কিনা দেখতে হবে

        // লগ যোগ করা হলো ডিবাগিং এর জন্য
        \Log::info('Comment Like function called', ['comment_id' => $comment->id, 'user_id' => $user?->id]);

        // আগের লাইক খুঁজে বের করা
        $existingLike = $comment->likes() // <-- likes() রিলেশন কাজ করছে কিনা দেখতে হবে
            ->where('user_id', $user->id) // <-- user_id ঠিকমতো পাওয়া যাচ্ছে কিনা
            ->first();

        \Log::info('Existing like check', ['existingLike' => $existingLike]);

        try { // <-- ডাটাবেস অপারেশনের জন্য try-catch যোগ করা ভালো
            if ($existingLike) {
                // লাইক থাকলে ডিলিট করা
                $existingLike->delete();
                \Log::info('Comment Like removed', ['comment_id' => $comment->id, 'user_id' => $user->id]);
                $liked = false;
            } else {
                // লাইক না থাকলে তৈরি করা
                $comment->likes()->create(['user_id' => $user->id]); // <-- এখানে create ফেইল করছে কিনা দেখতে হবে
                 \Log::info('Comment Like added', ['comment_id' => $comment->id, 'user_id' => $user->id]);
                $liked = true;
            }

            // সফল হলে JSON রেসপন্স পাঠানো
            $likeCount = $comment->likes()->count();
            \Log::info('Returning success response', ['liked' => $liked, 'likes' => $likeCount]);

            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes' => $likeCount // <-- লাইক সংখ্যা সঠিকভাবে গণনা হচ্ছে কিনা
            ]);

        } catch (\Exception $e) {
            // যদি কোনো ইরর হয়, তাহলে লগ করা এবং ইরর রেসপন্স পাঠানো
            \Log::error('Error processing comment like:', [
                'comment_id' => $comment->id,
                'user_id' => $user?->id,
                'error' => $e->getMessage(),
                 'trace' => $e->getTraceAsString() // <-- বিস্তারিত ট্রেস লগ করা
            ]);

            // জাভাস্ক্রিপ্টকে JSON ফরম্যাটে ইরর মেসেজ পাঠানো
            return response()->json([
                'success' => false,
                 'message' => 'Could not process the like. Please try again later.'
                // 'error_details' => $e->getMessage() // ডেভেলপমেন্টের সময় এটি দেখতে পারেন
            ], 500); // <-- 500 স্ট্যাটাস কোড পাঠানো
        }
    }
    
    public function destroy(Comment $comment)
    {
        // Only comment owner can delete
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['success' => false], 403);
        }
        
        $comment->delete();
        
        return response()->json(['success' => true]);
    }
}
