<?php

namespace Sndpbag\Blog\Http\Controllers;

 
use Illuminate\Http\Request;
use Sndpbag\AdminPanel\Http\Controllers\Controller; // AdminPanel-এর বেস কন্ট্রোলার ব্যবহার করুন
use Sndpbag\Blog\Models\Comment;
 
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{ 

   public function __construct()
    {
        // এখানে কমেন্ট ম্যানেজমেন্টের জন্য পারমিশন যোগ করতে পারেন
        // $this->middleware('permission:comments.view')->only('index');
        // $this->middleware('permission:comments.edit')->only(['approve', 'reject']);
        // $this->middleware('permission:comments.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'blog']) // ব্যবহারকারী এবং ব্লগ পোস্টের তথ্য লোড করুন
                   ->latest(); // সাম্প্রতিক কমেন্ট আগে দেখান

        // স্ট্যাটাস অনুযায়ী ফিল্টার করুন
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        } else {
            // ডিফল্টভাবে পেন্ডিং কমেন্ট দেখান
             $query->where('status', 'pending');
        }


        // সার্চ করুন (কমেন্টের内容 বা ব্যবহারকারীর নাম দিয়ে)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('body', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('blog', function($blogQuery) use ($search) {
                    $blogQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        $comments = $query->paginate(15); // প্রতি পৃষ্ঠায় ১৫টি কমেন্ট দেখান

        return view('blog::dashboard.comments.index', compact('comments'));
    }

    /**
     * Approve the specified comment.
     */
    public function approve(Comment $comment)
    {
        try {
            $comment->update(['status' => 'approved']);
            return redirect()->back()->with('success', 'Comment approved successfully!');
        } catch (\Exception $e) {
            Log::error("Error approving comment: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to approve comment.');
        }
    }

    /**
     * Reject the specified comment.
     */
    public function reject(Comment $comment)
    {
         try {
            $comment->update(['status' => 'rejected']);
            return redirect()->back()->with('success', 'Comment rejected successfully!');
        } catch (\Exception $e) {
            Log::error("Error rejecting comment: " . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to reject comment.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();
            return redirect()->route('comments.index')->with('success', 'Comment deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting comment: " . $e->getMessage());
            return redirect()->route('comments.index')->with('error', 'Failed to delete comment.');
        }
    }
  
}
