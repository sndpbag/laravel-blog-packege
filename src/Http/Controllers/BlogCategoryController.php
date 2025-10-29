<?php

namespace Sndpbag\Blog\Http\Controllers;

use Sndpbag\Blog\Models\Blog;
use Illuminate\Support\Str;

use Sndpbag\Blog\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{ 
    /**
     * Display a listing of the blog categories.
     */
     public function index(Request $request)
    {
        $query = BlogCategory::withCount('blogs');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $categories = $query->latest()->paginate(10);
        
        return view('blog::dashboard.blog-categories.index', compact('categories'));
    }


     /**
     * Toggle category status (Active/Inactive)
     */
    public function toggleStatus(BlogCategory $blogCategory)
    {
        $blogCategory->update([
            'status' => $blogCategory->status === 'Active' ? 'Inactive' : 'Active'
        ]);

        return redirect()
            ->back()
            ->with('success', 'Category status updated successfully!');
    }


        /**
     * Display trashed blog categories
     */
    public function trashed()
    {
        $categories = BlogCategory::onlyTrashed()
            ->withCount('blogs')
            ->latest('deleted_at')
            ->paginate(10);
        
        return view('blog::dashboard.blog-categories.trashed', compact('categories'));
    }




    /**
     * Show the form for creating a new blog category.
     */
    public function create()
    {
        return view('blog::dashboard.blog-categories.create');
    }

    /**
     * Store a newly created blog category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'slug' => 'required|string|max:255|unique:blog_categories,slug',
            'status' => 'required|in:Active,Inactive',
        ]);

        // Ensure slug is always lowercase and properly formatted
        $validated['slug'] = Str::slug($validated['slug']);

        BlogCategory::create($validated);

        return redirect()
            ->route('blog-categories.index')
            ->with('success', 'Blog category created successfully!');
    }



       /**
     * Display blogs by category
     */
    public function category($slug)
    {
      $category = BlogCategory::where('slug', $slug)
            ->where('status', 'Active')
            ->withCount('blogs')
            ->firstOrFail();

        $blogs = Blog::with(['category', 'author', 'comments', 'likes'])
            ->where('category_id', $category->id)
            ->where('status', 'Published')
            ->latest('published_date')
            ->paginate(12);

        // Get all active categories for sidebar
        $categories = BlogCategory::withCount('blogs')
            ->where('status', 'Active')
            ->orderBy('name')
            ->get();

        return view('blog.category', compact('blogs', 'category', 'categories'));
    }

    

    /**
     * Display the specified blog category.
     */
    public function show(BlogCategory $blogCategory)
    {
        $blogCategory->load('blogs');
        return view('dashboard.blog-categories.show', compact('blogCategory'));
    }

    /**
     * Show the form for editing the specified blog category.
     */
    public function edit(BlogCategory $blogCategory)
    {
        $blogCategory->loadCount('blogs');
        return view('blog::dashboard.blog-categories.edit', compact('blogCategory'));
    }

    /**
     * Update the specified blog category in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $blogCategory->id,
            'slug' => 'required|string|max:255|unique:blog_categories,slug,' . $blogCategory->id,
            'status' => 'required|in:Active,Inactive',
        ]);

        // Ensure slug is always lowercase and properly formatted
        $validated['slug'] = Str::slug($validated['slug']);

        $blogCategory->update($validated);

        return redirect()
            ->route('blog-categories.index')
            ->with('success', 'Blog category updated successfully!');
    }

    /**
     * Remove the specified blog category from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        // Check if category has any blogs
        if ($blogCategory->blogs()->count() > 0) {
            return redirect()
                ->route('blog-categories.index')
                ->with('error', 'Cannot delete category with associated blogs!');
        }

        $blogCategory->delete();

        return redirect()
            ->route('blog-categories.index')
            ->with('success', 'Blog Category moved to trash successfully!');
    }

    /**
     * Restore the specified soft-deleted blog category.
     */
    public function restore($id)
    {
        $blogCategory = BlogCategory::withTrashed()->findOrFail($id);
        $blogCategory->restore();

        return redirect()
            ->route('blog-categories.index')
            ->with('success', 'Blog category restored successfully!');
    }

    /**
     * Permanently delete the specified blog category.
     */
    public function forceDelete($id)
    {
        $blogCategory = BlogCategory::withTrashed()->findOrFail($id);
        $blogCategory->forceDelete();

        return redirect()
            ->route('blog-categories.index')
            ->with('success', 'Blog category permanently deleted!');
    }
}
