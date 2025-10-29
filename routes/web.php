<?php

use Illuminate\Support\Facades\Route;
use Sndpbag\Blog\Http\Controllers\Frontend\CommentController;
use Sndpbag\Blog\Http\Controllers\BlogController;
use Sndpbag\Blog\Http\Controllers\BlogCategoryController;
use Sndpbag\Blog\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use Sndpbag\Blog\Http\Controllers\CommentController as DashboardCommentController;
use Sndpbag\Blog\Http\Controllers\Frontend\NewsletterController;

// ====================================================
// 1. BACKEND / DASHBOARD ROUTES
// ====================================================
Route::middleware(['web', 'auth'])->prefix('dashboard')->group(function () {

    // Blog Posts Resource (e.g., /dashboard/blog, /dashboard/blog/create)
    
Route::patch('/blog/{blog}/toggle-status', [BlogController::class, 'toggleStatus'])->name('blog.toggle-status');
     Route::post('/dashboard/blogs/upload-image', [BlogController::class, 'uploadContentImage'])->name('blog.uploadContentImage');
  Route::post('/blog/{blog}/increment-view', [BlogController::class, 'incrementView'])->name('blog.increment-view');
    Route::post('/blog/{blog}/like', [BlogController::class, 'like'])->name('blog.like');
    Route::post('/blog/{blog}/comment', [BlogController::class, 'comment'])->name('blog.comment');

   Route::get('blog/trashed', [BlogController::class, 'trashed'])->name('blog.trashed');
    Route::post('blog/{id}/restore', [BlogController::class, 'restore'])->name('blog.restore');
    Route::delete('blog/{id}/force-delete', [BlogController::class, 'forceDelete'])->name('blog.force-delete');
 Route::resource('blog', BlogController::class)->names('blog');



    // Blog Categories Resource (e.g., /dashboard/blog-categories)
    Route::resource('blog-categories', BlogCategoryController::class);

    // Image Upload from Editor
    Route::post('/blogs/upload-image', [BlogController::class, 'uploadContentImage'])->name('blogs.uploadContentImage');

    // Category Status Toggle
    Route::patch('blog-categories/{blogCategory}/toggle-status', [BlogCategoryController::class, 'toggleStatus'])
        ->name('blog-categories.toggleStatus');

    // Trashed Categories
    Route::get('blog-categories/trashed', [BlogCategoryController::class, 'trashed'])
        ->name('blog-categories.trashed');
    Route::post('blog-categories/{id}/restore', [BlogCategoryController::class, 'restore'])
        ->name('blog-categories.restore');
    Route::delete('blog-categories/{id}/force-delete', [BlogCategoryController::class, 'forceDelete'])
        ->name('blog-categories.force-delete');


        Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/', [DashboardCommentController::class, 'index'])->name('index'); // কমেন্ট লিস্ট দেখানোর রুট
        Route::patch('/{comment}/approve', [DashboardCommentController::class, 'approve'])->name('approve'); // Approve করার রুট
        Route::patch('/{comment}/reject', [DashboardCommentController::class, 'reject'])->name('reject'); // Reject করার রুট
        Route::delete('/{comment}', [DashboardCommentController::class, 'destroy'])->name('destroy'); // ডিলিট করার রুট
    });
});


// ====================================================
// 2. FRONTEND ROUTES
// ====================================================
Route::middleware('web')->prefix('blog')->name('frontend.blog.')->group(function () {
    
    // All blogs page
    Route::get('/', [FrontendBlogController::class, 'index'])->name('index');
    
    // Blogs by category
    Route::get('/category/{slug}', [FrontendBlogController::class, 'category'])
        ->name('category');

    // Single blog post page
    Route::get('/{slug}', [FrontendBlogController::class, 'show'])->name('show');
    
    // Increment view count (can be public)
    Route::post('/{slug}/increment-views', [FrontendBlogController::class, 'incrementView'])->name('increment-view');

    // Routes requiring authentication
    Route::middleware('auth')->group(function () {
        Route::post('/{slug}/likes', [FrontendBlogController::class, 'like'])->name('like');
        Route::post('/{slug}/comments', [FrontendBlogController::class, 'comment'])->name('comment');
        Route::post('/{slug}/comment/{comment}/replys', [FrontendBlogController::class, 'commentReply'])->name('comment.reply');
        
        // Comment specific actions
        Route::post('/comment/{comment}/like', [CommentController::class, 'like'])->name('comment.like');
        Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    });


    
});


Route::prefix('newsletter')->name('blog.newsletter.')->group(function () {
    Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');
    Route::get('/verify/{token}', [NewsletterController::class, 'verify'])->name('verify');
});