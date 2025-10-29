<?php

namespace Sndpbag\Blog\Http\Controllers\Frontend;

use Sndpbag\AdminPanel\Http\Controllers\Controller;
use Sndpbag\Blog\Models\Blog;
use Sndpbag\Blog\Models\BlogCategory;
use Sndpbag\Blog\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{


    /**
     * Display a listing of blogs
     */
    // public function index(Request $request)
    // {
    //     $query = Blog::with(['category', 'author'])
    //         ->where('status', 'published')
    //         ->latest('published_date');

    //     // Filter by category if provided
    //     if ($request->has('category') && $request->category) {
    //         $query->where('category_id', $request->category);
    //     }

    //     // Search functionality
    //     if ($request->has('search') && $request->search) {
    //         $query->where(function($q) use ($request) {
    //             $q->where('title', 'like', '%' . $request->search . '%')
    //               ->orWhere('excerpt', 'like', '%' . $request->search . '%')
    //               ->orWhere('content', 'like', '%' . $request->search . '%');
    //         });
    //     }

    //     // Filter by featured
    //     if ($request->has('featured') && $request->featured) {
    //         $query->where('is_featured', true);
    //     }

    //     $blogs = $query->paginate(9);
    //     $categories = BlogCategory::withCount('blogs')->get();
    //     $featuredBlogs = Blog::where('status', 'published')
    //         ->where('is_featured', true)
    //         ->latest('published_date')
    //         ->take(3)
    //         ->get();

    //     return view('blog::blog.blog', compact('blogs', 'categories', 'featuredBlogs'));
    // }


        public function index(Request $request)
{
    $query = Blog::where('status', 'Published')
        ->with(['category', 'author', 'likes', 'comments'])
        ->latest('published_date');
    
    // Search functionality
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%")
              ->orWhere('tags', 'like', "%{$search}%");
        });
    }
    
    // Category filter
    if ($request->filled('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }
    
    $blogs = $query->paginate(12);
    $categories = BlogCategory::withCount('blogs')->get();
    
    // AJAX Response
    if ($request->ajax() || $request->wantsJson()) {
        $html = '';
        if ($blogs->count() > 0) {
            foreach ($blogs as $blog) {
                $html .= view('blog::partials.blog-card', compact('blog'))->render();
            }
        } else {
            $html = view('blog::partials.no-results')->render();
        }
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'pagination' => $blogs->links()->render(),
            'total' => $blogs->total(),
            'current_page' => $blogs->currentPage(),
            'last_page' => $blogs->lastPage()
        ]);
    }
    
    return view('blog::blog.blog', compact('blogs', 'categories'));
}



    public function category(Request $request, $slug)
    {
        // ক্যাটাগরিটি slug দিয়ে খুঁজুন, শুধু Active স্ট্যাটাসের
        $category = BlogCategory::where('slug', $slug)
            ->where('status', 'Active') // <-- নিশ্চিত করুন স্ট্যাটাস 'Active' (string) নাকি 1 (integer)
            ->withCount('blogs')
            ->firstOrFail(); // না পেলে 404 দেখাবে

        // ওই ক্যাটাগরির Published ব্লগগুলো খুঁজুন
        $query = Blog::with(['category', 'author'])
            ->where('category_id', $category->id)
            ->where('status', 'published') // <-- নিশ্চিত করুন স্ট্যাটাস 'published' (string) নাকি 1 (integer)
            ->latest('published_date');

        // সার্চ functionality যোগ করতে পারেন
        if ($request->has('search') && $request->search) {
             $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $blogs = $query->paginate(9);

        // Sidebar-এর জন্য সব Active ক্যাটাগরি আবার লোড করুন
        $categories = BlogCategory::withCount('blogs')
                        ->where('status', 'Active')
                        ->orderBy('name')
                        ->get();
        
        // category.blade.php অথবা blog.blade.php ভিউ ব্যবহার করুন
        // আপনার কাছে blog::blog.category ভিউ না থাকলে blog::blog.blog ব্যবহার করতে পারেন
        // return view('blog::blog.category', compact('blogs', 'category', 'categories')); 
        return view('blog::blog.blog', compact('blogs', 'category', 'categories')); // <-- blog.blog ভিউ ব্যবহার করা হলো

    }
 

  public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->with([
                'category',
                'author',
                // --- মন্তব্য লোড করার যুক্তি পরিবর্তন ---
                'comments' => function ($query) {
                    $query->where(function ($q) {
                        // সবার জন্য অনুমোদিত মন্তব্য দেখাবে
                        $q->where('status', 'approved'); //

                        // যদি ব্যবহারকারী লগইন করা থাকেন, তাহলে তারই অপেক্ষমাণ মন্তব্য দেখাবে
                        if (Auth::check()) {
                            $q->orWhere(function ($q2) {
                                $q2->where('status', 'pending') //
                                   ->where('user_id', Auth::id());
                            });
                        }
                    })
                    ->whereNull('parent_id') // শুধু মূল মন্তব্য (রিপ্লাই নয়)
                    ->latest(); // নতুন মন্তব্য আগে
                },
                'comments.user', // দৃশ্যমান মন্তব্যের ব্যবহারকারীর তথ্য
                // --- রিপ্লাই লোড করার যুক্তি পরিবর্তন ---
                'comments.replies' => function ($query) {
                     $query->where(function ($q) {
                        // সবার জন্য অনুমোদিত রিপ্লাই দেখাবে
                        $q->where('status', 'approved'); //

                        // যদি ব্যবহারকারী লগইন করা থাকেন, তাহলে তারই অপেক্ষমাণ রিপ্লাই দেখাবে
                        if (Auth::check()) {
                            $q->orWhere(function ($q2) {
                                $q2->where('status', 'pending') //
                                   ->where('user_id', Auth::id());
                            });
                        }
                    })
                    ->oldest(); // রিপ্লাইগুলো পুরোনো থেকে নতুন হিসেবে সাজানো থাকবে
                },
                'comments.replies.user', // দৃশ্যমান রিপ্লাইয়ের ব্যবহারকারীর তথ্য
                'likes'
            ])
            ->firstOrFail();

        // সম্পর্কিত পোস্টের কোড যেমন ছিল তেমনই থাকবে...
        $relatedPosts = Blog::where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->latest('published_date')
            ->take(5)
            ->get();

        return view('blog::blog.blog-details', compact('blog', 'relatedPosts')); //
    }




    // public function show($slug)
    // {
    //     // Get blog with relationships
    //     $blog = Blog::where('slug', $slug)
    //         ->where('status', 'published')
    //         ->with(['category', 'author', 'comments.user', 'comments.replies.user', 'likes'])
    //         ->firstOrFail();

    //     // Get related posts (same category, excluding current post)
    //     $relatedPosts = Blog::where('category_id', $blog->category_id)
    //         ->where('id', '!=', $blog->id)
    //         ->where('status', 'published')
    //         ->latest('published_date')
    //         ->take(5)
    //         ->get();

    //     return view('blog::blog.blog-details', compact('blog', 'relatedPosts'));
    // }

    public function incrementView($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $blog->increment('views');

        return response()->json([
            'success' => true,
            'views' => $blog->views
        ]);
    }

    public function like($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $user = auth()->user();



        $existingLike = $blog->likes()
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            $blog->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes' => $blog->likes()->count()
        ]);
    }

    public function comment(Request $request, $slug)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $blog = Blog::where('slug', $slug)->firstOrFail();

        $blog->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment posted successfully!');
    }

    public function commentReply(Request $request, $slug, $commentId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $blog = Blog::where('slug', $slug)->firstOrFail();
        $parentComment = Comment::findOrFail($commentId);

        $blog->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->content,
            'parent_id' => $commentId,
        ]);

        return redirect()->back()->with('success', 'Reply posted successfully!');
    }
    
}
