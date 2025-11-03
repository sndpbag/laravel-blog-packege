<?php

namespace Sndpbag\Blog\Http\Controllers;


use Sndpbag\Blog\Models\Blog;
use Sndpbag\Blog\Models\BlogCategory;
use Sndpbag\AdminPanel\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Sndpbag\Blog\Models\Subscriber;
use Sndpbag\Blog\Mail\NewBlogPostNotification;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Blog::with(['category', 'author'])->withCount('likes');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Get paginated blogs
        $blogs = $query->latest('published_date')
            ->latest('created_at')
            ->paginate(10);

        // Get categories for filter dropdown
        $categories = BlogCategory::all();

        // Statistics
        $totalPosts = Blog::count();
        $publishedPosts = Blog::where('status', 1)->count();
        $draftPosts = Blog::where('status', 0)->count();
        $totalCategories = BlogCategory::count();

        return view('blog::dashboard.blogs.index', compact(
            'blogs',
            'categories',
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'totalCategories'
        ));
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::where('status', 1)->get();
        $members = User::where('status', 1)->get();

        return view('blog::dashboard.blogs.create', compact('categories', 'members'));
    }

 

    public function store(Request $request): RedirectResponse
    {


        // ধাপ ১: ফর্ম থেকে আসা সমস্ত ডেটা ভ্যালিডেট করা
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'published_date' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:blog_categories,id', // টেবিলের নাম blog_categories নিশ্চিত করুন
            'member_id' => 'nullable|exists:users,id', // ঐচ্ছিক মেম্বার
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'likes' => 'nullable|integer|min:0',
            'tags' => 'nullable|string',
            // 'status' এবং 'action' আলাদাভাবে হ্যান্ডেল করা হবে
            'word_count' => 'nullable|integer',
            'reading_time' => 'nullable|integer',
        ]);

        try {
            // ধাপ ২: স্ট্যাটাস নির্ধারণ করা (Publish নাকি Draft)
            // এটি ফর্মে ক্লিক করা বাটনের উপর নির্ভর করবে
            // $validated['status'] = $request->input('action') === 'publish';
            // $validated['status'] = $request->input('action') === 'publish' ? 'published' : 'draft';


            if ($request->input('action') === 'draft') {
                $validated['status'] = 'draft';
            } else {
                // যদি 'action' হয় 'publish' বা যদি এন্টার কি (Enter Key) দ্বারা সাবমিট হয়, তবে ডিফল্টভাবে publish হবে
                $validated['status'] = 'published';
            }


            // 'is_featured' চেকবক্সের ভ্যালু ঠিক করা (0 অথবা 1)
            $validated['is_featured'] = $request->has('is_featured');

            // ধাপ ৩: ফিচার্ড ইমেজ আপলোড এবং পাথ সংরক্ষণ
            if ($request->hasFile('image')) {
                // ছবিটি storage/app/public/blog_images ফোল্ডারে সেভ হবে
                $path = $request->file('image')->store('blog_images', 'public');
                $validated['image'] = $path;
            }

            // ধাপ ৪: লেখক নির্ধারণ করা (Polymorphic Relationship)
            // যদি 'member_id' সিলেক্ট করা হয়, তাহলে সেই মেম্বারই লেখক
            if ($request->filled('member_id')) {
                $validated['author_id'] = $request->input('member_id');
            } else {
                // অন্যথায়, যে অ্যাডমিন লগইন করে আছেন, তিনি লেখক
                $validated['author_id'] = auth()->id();
            }
            $validated['author_type'] = User::class; // লেখকের মডেল


            // ধাপ ৫: SEO এবং অন্যান্য ফিল্ডের জন্য ডিফল্ট ভ্যালু সেট করা
            if (empty($validated['meta_title'])) {
                $validated['meta_title'] = $validated['title'];
            }
            if (empty($validated['meta_description'])) {
                $validated['meta_description'] = Str::limit(strip_tags($validated['excerpt'] ?? ''), 160);
            }
            if ($validated['status'] && empty($validated['published_date'])) {
                $validated['published_date'] = now();
            }
            if (empty($validated['reading_time'])) {
                $wordCount = $validated['word_count'] ?? str_word_count(strip_tags($validated['content']));
                $validated['reading_time'] = max(1, ceil($wordCount / 200));
            }


            // ধাপ ৬: ডেটাবেসে নতুন ব্লগ পোস্ট তৈরি করা
            $blog = Blog::create($validated);


            // ✅ নতুন লজিক শুরু: যদি পোস্টটি Published হয়, তবে সাবস্ক্রাইবারদের ইমেল পাঠান
            if ($validated['status'] === 'published') {

                // শুধু ভেরিফাইড সাবস্ক্রাইবারদের ইমেল পাঠানো হবে
                $subscribers = Subscriber::whereNotNull('email_verified_at')->get();

                // প্রতিটি সাবস্ক্রাইবারের কাছে ইমেল পাঠানো
                foreach ($subscribers as $subscriber) {
                    // Mail::to(সাবস্ক্রাইবারের ইমেল) ব্যবহার করে Queued ইমেল পাঠানো
                    Mail::to($subscriber->email)
                        ->queue(new NewBlogPostNotification($blog));
                }
            }




            // ধাপ ৭: সফল বার্তা সহ ব্লগ লিস্ট পেজে রিডাইরেক্ট করা
            return redirect()->route('blog.index')
                ->with('success', 'Blog post created successfully!');
        } catch (\Exception $e) {

            Log::error('Blog creation failed: ' . $e->getMessage());
            // যদি কোনো এরর হয়, তাহলে আপলোড করা ছবিটি ডিলিট করে দেওয়া হবে
            if (isset($validated['image']) && Storage::disk('public')->exists($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }

            // এরর বার্তা সহ আগের পেজে ফেরত পাঠানো
            return back()
                ->withInput()
                ->with('error', 'Failed to create blog post: ' . $e->getMessage());
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        // Eager load relationships to optimize queries
        $blog->load(['category', 'author', 'comments.user', 'likes']);

        // Get recent posts excluding current blog
        $recentPosts = Blog::where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->latest('published_date')
            ->take(5)
            ->get();

        // Return view with blog data
        return view('blog::dashboard.blogs.show', compact('blog', 'recentPosts'));
    }

    // Additional required methods for show.blade.php functionality

    /**
     * Increment blog view count
     */
    public function incrementView(Blog $blog)
    {
        $blog->increment('views');

        return response()->json([
            'success' => true,
            'views' => $blog->views
        ]);
    }

    /**
     * Toggle like on blog post
     */
    // public function like(Blog $blog)
    // {
    //     $user = auth()->user();

    //     // Check if user already liked this blog
    //     $existingLike = $blog->likes()
    //         ->where('user_id', $user->id)
    //         ->first();

    //     if ($existingLike) {
    //         // Unlike - remove the like
    //         $existingLike->delete();
    //         $liked = false;
    //     } else {
    //         // Like - create new like
    //         $blog->likes()->create([
    //             'user_id' => $user->id,
    //         ]);
    //         $liked = true;
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'liked' => $liked,
    //         'likes' => $blog->likes()->count()
    //     ]);
    // }

    public function like(Blog $blog)
    {
        $user = auth()->user();
        \Log::info('Like function called', ['user_id' => $user?->id, 'blog_id' => $blog->id]);

        // Check if user already liked this blog
        $existingLike = $blog->likes()
            ->where('user_id', $user->id)
            ->first();

        \Log::info('Existing like check', ['existingLike' => $existingLike]);

        if ($existingLike) {
            // Unlike - remove the like
            $existingLike->delete();
            \Log::info('Like removed', ['user_id' => $user->id]);
            $liked = false;
        } else {
            // Like - create new like
            $blog->likes()->create([
                'user_id' => $user->id,
            ]);
            \Log::info('Like added', ['user_id' => $user->id]);
            $liked = true;
        }

        $totalLikes = $blog->likes()->count();
        \Log::info('Total likes after action', ['likes' => $totalLikes]);

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes' => $totalLikes,
        ]);
    }


    /**
     * Store a comment on blog post
     */
    // public function comment(Request $request, Blog $blog)
    // {
    //     $request->validate([
    //         'body' => 'required|string|max:1000',
    //     ]);

    //     $comment = $blog->comments()->create([
    //         'user_id' => auth()->id(),
    //         'body' => $request->content,
    //     ]);

    //     return redirect()->back()->with('success', 'Comment posted successfully!');
    // }

    public function comment(Request $request, Blog $blog)
    {
        // ✅ Validation
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // 📝 Log input data
        Log::info('Comment Request Data:', $request->all());
        Log::info('Authenticated User ID:', ['user_id' => auth()->id()]);
        Log::info('Blog ID:', ['blog_id' => $blog->id]);

        // ✅ Create comment
        $comment = $blog->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->content, // এখানে ঠিক করে body রাখা হলো
        ]);

        // 📝 Log created comment
        Log::info('Comment Created:', $comment->toArray());

        return redirect()->back()->with('success', 'Comment posted successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog): View
    {
        $categories = BlogCategory::where('status', 1)->get();
        $members = User::where('status', 1)->get();
        return view('blog::dashboard.blogs.edit', compact('blog', 'categories', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Blog $blog): RedirectResponse
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'slug' => ['required', 'string', 'max:255', Rule::unique('blogs')->ignore($blog->id)],
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Nullable on update
    //         'published_date' => 'nullable|date',
    //         'is_featured' => 'nullable|boolean',
    //         'excerpt' => 'nullable|string|max:500',
    //         'content' => 'required|string',
    //         'category_id' => 'nullable|exists:blog_categories,id',
    //         'member_id' => 'nullable|exists:users,id',
    //         'meta_title' => 'nullable|string|max:60',
    //         'meta_description' => 'nullable|string|max:160',
    //         'tags' => 'nullable|string',
    //     ]);

    //     try {
    //         $validated['status'] = $request->input('action') === 'publish' ? 'published' : 'draft';
    //         $validated['is_featured'] = $request->has('is_featured');

    //         if ($request->hasFile('image')) {
    //             // Delete old image
    //             if ($blog->image && Storage::disk('public')->exists($blog->image)) {
    //                 Storage::disk('public')->delete($blog->image);
    //             }
    //             // Store new image
    //             $path = $request->file('image')->store('blog_images', 'public');
    //             $validated['image'] = $path;
    //         }

    //         $validated['author_id'] = $request->filled('member_id') ? $request->input('member_id') : auth()->id();
    //         $validated['author_type'] = User::class; // delete
    //         if (empty($validated['meta_title'])) {
    //             $validated['meta_title'] = $validated['title'];
    //         }
    //         if (empty($validated['meta_description'])) {
    //             $validated['meta_description'] = Str::limit(strip_tags($validated['excerpt'] ?? ''), 160);
    //         }

    //         $blog->update($validated);

    //         return redirect()->route('blog.index')->with('success', 'Blog post updated successfully!');
    //     } catch (\Exception $e) {
    //         Log::error('Blog update failed: ' . $e->getMessage());
    //         return back()->withInput()->with('error', 'Failed to update blog post: ' . $e->getMessage());
    //     }
    // }


    public function update(Request $request, Blog $blog): RedirectResponse
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'slug' => ['required', 'string', 'max:255', Rule::unique('blogs')->ignore($blog->id)],
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        'published_date' => 'nullable|date',
        'is_featured' => 'nullable|boolean',
        'excerpt' => 'nullable|string|max:500',
        'content' => 'required|string',
        'category_id' => 'nullable|exists:blog_categories,id',
        'member_id' => 'nullable|exists:users,id',
        'meta_title' => 'nullable|string|max:60',
        'meta_description' => 'nullable|string|max:160',
        'tags' => 'nullable|string',
        'word_count' => 'nullable|integer',
        'reading_time' => 'nullable|integer',
    ], [
        'title.required' => 'Blog title is required',
        'title.max' => 'Blog title cannot exceed 255 characters',
        'slug.required' => 'URL slug is required',
        'slug.unique' => 'This slug is already taken',
        'image.image' => 'File must be an image',
        'image.mimes' => 'Image must be jpeg, png, jpg, gif, or webp',
        'image.max' => 'Image size cannot exceed 5MB',
        'excerpt.max' => 'Excerpt cannot exceed 500 characters',
        'content.required' => 'Blog content is required',
        'category_id.exists' => 'Selected category does not exist',
        'member_id.exists' => 'Selected member does not exist',
        'meta_title.max' => 'Meta title cannot exceed 60 characters',
        'meta_description.max' => 'Meta description cannot exceed 160 characters',
    ]);

    try {
        // Determine status
        if ($request->input('action') === 'draft') {
            $validated['status'] = 'draft';
        } else {
            $validated['status'] = 'published';
        }
        
        $validated['is_featured'] = $request->has('is_featured');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            // Store new image
            $path = $request->file('image')->store('blog_images', 'public');
            $validated['image'] = $path;
        }

        // Set author
        $validated['author_id'] = $request->filled('member_id') ? 
            $request->input('member_id') : 
            auth()->id();
        
        $validated['author_type'] = config('admin-panel.user_model', \Sndpbag\AdminPanel\Models\User::class);

        // SEO defaults
        if (empty($validated['meta_title'])) {
            $validated['meta_title'] = $validated['title'];
        }
        if (empty($validated['meta_description'])) {
            $validated['meta_description'] = Str::limit(strip_tags($validated['excerpt'] ?? ''), 160);
        }

        // Update published date if status changed to published
        if ($validated['status'] === 'published' && $blog->status !== 'published' && empty($validated['published_date'])) {
            $validated['published_date'] = now();
        }

        // Calculate reading time if not provided
        if (empty($validated['reading_time'])) {
            $wordCount = $validated['word_count'] ?? str_word_count(strip_tags($validated['content']));
            $validated['reading_time'] = max(1, ceil($wordCount / 200));
        }

        $blog->update($validated);

        return redirect()->route('blog.index')
            ->with('success', 'Blog post updated successfully!');
            
    } catch (\Exception $e) {
        Log::error('Blog update failed: ' . $e->getMessage());
        
        // If a new image was uploaded but update failed, delete it
        if (isset($validated['image']) && $validated['image'] !== $blog->image && Storage::disk('public')->exists($validated['image'])) {
            Storage::disk('public')->delete($validated['image']);
        }
        
        return back()
            ->withInput()
            ->with('error', 'Failed to update blog post: ' . $e->getMessage());
    }
}



    /**
     * Toggle the status of the specified blog.
     */
    public function toggleStatus(Blog $blog)
    {
        try {
            // বর্তমান স্ট্যাটাস চেক করা
            $oldStatus = $blog->status;
            $newStatus = $oldStatus === 'published' ? 'draft' : 'published';

            // স্ট্যাটাস আপডেট করা
            $blog->update(['status' => $newStatus]);

            // সফল লগ রাখা
            Log::info('Blog status toggled successfully', [
                'blog_id' => $blog->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'updated_by' => auth()->id() ?? 'system'
            ]);

            // সফল রেসপন্স পাঠানো
            return response()->json([
                'success' => true,
                'message' => 'Blog status updated to ' . ucfirst($newStatus) . ' successfully!',
                'new_status' => $newStatus
            ]);
        } catch (\Exception $e) {
            // যদি কোনো Error হয়, সেটা লগ করা
            Log::error('Failed to toggle blog status', [
                'blog_id' => $blog->id ?? null,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'updated_by' => auth()->id() ?? 'system'
            ]);

            // Error response পাঠানো
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating blog status!'
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        try {

            $blog->delete();
            return redirect()->route('blog.index')->with('success', 'Blog post deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Blog deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete blog post.');
        }
    }

    /**
     * Upload image from Rich Text Editor.
     */
    // public function uploadContentImage(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
    //     ]);

    //     if ($request->hasFile('image')) {
    //         $path = $request->file('image')->store('blog_content_images', 'public');

    //         // Generate a full URL for the image
    //         $url = asset('storage/' . $path);

    //         return response()->json(['url' => $url]);
    //     }

    //     return response()->json(['error' => 'Image upload failed.'], 400);
    // }


 public function uploadContentImage(Request $request)
{
    $request->validate([
        'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
    ]);

    try {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('blog_content_images', $filename, 'public');
            $url = asset('storage/' . $path);
            
            return response()->json([
                'url' => $url
            ]);
        }
        
        return response()->json(['error' => ['message' => 'No file uploaded']], 400);
    } catch (\Exception $e) {
        Log::error('Image upload failed: ' . $e->getMessage());
        return response()->json(['error' => ['message' => $e->getMessage()]], 500);
    }
}



    public function trashed(Request $request): View
    {
        $blogs = Blog::onlyTrashed()
            ->with(['category', 'author'])
            ->latest('deleted_at')
            ->paginate(10);

        return view('blog::dashboard.blogs.trashed', compact('blogs'));
    }

    /**
     * Restore the specified soft-deleted blog post.
     */
    public function restore($id): RedirectResponse
    {
        $blog = Blog::withTrashed()->findOrFail($id);
        $blog->restore();

        return redirect()->route('blog.trashed')->with('success', 'Blog post restored successfully!');
    }

    /**
     * Permanently delete the specified blog post.
     */
    public function forceDelete($id): RedirectResponse
    {
        $blog = Blog::withTrashed()->findOrFail($id);
        // ইমেজ সহ পার্মানেন্ট ডিলিট করা হচ্ছে
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->forceDelete();

        return redirect()->route('blog.trashed')->with('success', 'Blog post permanently deleted!');
    }
}
