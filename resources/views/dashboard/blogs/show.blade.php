@extends('admin-panel::dashboard.layouts.app')

@section('title', $blog->title . ' - Blog Post')
@section('page-title', 'Blog Post')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">Dashboard</a>
    <span class="text-gray-400 dark:text-gray-600 mx-2">/</span>
    <a href="{{ route('blog.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors">Blog Posts</a>
    <span class="text-gray-400 dark:text-gray-600 mx-2">/</span>
    <span class="text-primary dark:text-blue-400 font-medium">{{ Str::limit($blog->title, 30) }}</span>
@endsection

@section('header-actions')
    <div class="flex items-center space-x-3">
        <a href="{{ route('blog.edit', $blog->id) }}"
            class="hidden md:flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-500 dark:to-blue-600 rounded-lg hover:shadow-lg transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Post
        </a>
        <button onclick="deleteBlog({{ $blog->id }})"
            class="hidden md:flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 dark:from-red-500 dark:to-red-600 rounded-lg hover:shadow-lg transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Delete
        </button>
        <a href="{{ route('blog.index') }}"
            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>
@endsection

@section('content')
    <!-- Blog Header Banner -->
    <div style="background-color: var(--primary);" class="mb-8 bg-gradient-to-r   dark:from-blue-800 dark:to-blue-900 rounded-xl p-8 text-white shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative z-10">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    @if($blog->is_featured)
                        <span class="px-3 py-1 bg-yellow-400 dark:bg-yellow-500 text-yellow-900 dark:text-yellow-100 text-xs font-bold rounded-full flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Featured
                        </span>
                    @endif
                    <span class="px-3 py-1 bg-white/20 dark:bg-white/10 backdrop-blur-sm text-xs font-semibold rounded-full">
                        {{ ucfirst($blog->status) }}
                    </span>
                    @if($blog->category)
                        <span class="px-3 py-1 bg-white/20 dark:bg-white/10 backdrop-blur-sm text-xs font-semibold rounded-full">
                            {{ $blog->category->name }}
                        </span>
                    @endif
                </div>
            </div>
            <h1 class="text-4xl font-bold mb-4 leading-tight">{{ $blog->title }}</h1>
            <p class="text-blue-100 dark:text-blue-200 text-lg mb-6">{{ $blog->excerpt }}</p>
            
            <div class="flex flex-wrap items-center gap-4 text-sm">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ $blog->author->name ?? 'Unknown Author' }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ $blog->published_date->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $blog->reading_time }} min read</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span id="viewCount">{{ number_format($blog->views) }} views</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span id="likeCount">{{ number_format($blog->likes()->count()) }} likes</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Featured Image -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <img src="{{ asset('storage/' . $blog->image) }}" 
                     alt="{{ $blog->title }}" 
                     class="w-full h-96 object-cover">
            </div>

            <!-- Blog Content -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg">
                <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:font-bold prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-img:rounded-lg prose-img:shadow-lg">
                    {!! $blog->content !!}
                </div>
            </div>

            <!-- Tags -->
            @if($blog->tags)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Tags
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $blog->tags) as $tag)
                            <span class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 text-white text-sm rounded-full shadow-md hover:shadow-lg transition-all cursor-pointer">
                                {{ trim($tag) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Like & Share Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <button onclick="toggleLike({{ $blog->id }})" 
                            id="likeButton"
                            class="flex items-center space-x-2 px-6 py-3  dark:from-pink-600 dark:to-red-600 text-white rounded-lg hover:shadow-lg transition-all transform hover:scale-105" style="background-color: var(--secondary);">
                        <svg id="likeIcon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                        </svg>
                        <span id="likeButtonText" >Like this post</span>
                    </button>
                    
                    <div class="flex items-center space-x-3">
                        <button onclick="shareOnTwitter()" class="p-3 bg-blue-400 dark:bg-blue-500 text-white rounded-full hover:shadow-lg transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                            </svg>
                        </button>
                        <button onclick="shareOnFacebook()" class="p-3 bg-blue-600 dark:bg-blue-700 text-white rounded-full hover:shadow-lg transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                            </svg>
                        </button>
                        <button onclick="copyLink()" class="p-3 bg-gray-600 dark:bg-gray-700 text-white rounded-full hover:shadow-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Comments ({{ $blog->comments->count() }})
                </h3>

                <!-- Comment Form -->
                <form action="{{ route('blog.comment', $blog->id) }}" method="POST" class="mb-8">
                    @csrf
                    <div class="space-y-4">
                        <textarea name="content" rows="4" 
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all" 
                                  placeholder="Share your thoughts..." required></textarea>
                        <button type="submit"  style="background-color: var(--primary);"
                                class="px-6 py-3   dark:from-blue-500 dark:to-blue-600 text-white rounded-lg hover:shadow-lg transition-all flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Post Comment
                        </button>
                    </div>
                </form>

                <!-- Comments List -->
                <div class="space-y-6">
                    @forelse($blog->comments as $comment)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 hover:shadow-md transition-all">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                                        {{ substr($comment->user->name ?? 'U', 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">{{ $comment->user->name ?? 'Anonymous' }}</h4>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-lg">No comments yet. Be the first to comment!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Blog Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Statistics
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Word Count</span>
                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ number_format($blog->word_count) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Reading Time</span>
                        <span class="font-bold text-green-600 dark:text-green-400">{{ $blog->reading_time }} min</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total Views</span>
                        <span class="font-bold text-purple-600 dark:text-purple-400">{{ number_format($blog->views) }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-pink-50 dark:bg-pink-900/20 rounded-lg">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total Likes</span>
                        <span class="font-bold text-pink-600 dark:text-pink-400">{{ number_format($blog->likes()->count()) }}</span>
                    </div>
                </div>
            </div>

            <!-- Author Info -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    About Author
                </h3>
                <div class="text-center">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-3xl mx-auto mb-4">
                        {{ substr($blog->author->name ?? 'U', 0, 1) }}
                    </div>
                    <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ $blog->author->name ?? 'Unknown' }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $blog->author->email ?? '' }}</p>
                </div>
            </div>

            <!-- Category Info -->
            @if($blog->category)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Category
                    </h3>
                    <div class="p-4 bg-gradient-to-r from-orange-500 to-red-500 dark:from-orange-600 dark:to-red-600 text-white rounded-lg text-center">
                        <p class="font-bold text-lg">{{ $blog->category->name }}</p>
                    </div>
                </div>
            @endif

            <!-- Recent Posts -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Recent Posts
                </h3>
                <div class="space-y-4">
                    @foreach(\Sndpbag\Blog\Models\Blog::where('id', '!=', $blog->id)->where('status', 'published')->latest()->take(5)->get() as $recentPost)
                        <a href="{{ route('blog.show', $recentPost->id) }}" class="block group">
                            <div class="flex items-start space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:shadow-md transition-all">
                                <img src="{{ asset('storage/' . $recentPost->image) }}" 
                                     alt="{{ $recentPost->title }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                        {{ $recentPost->title }}
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $recentPost->published_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Dark Mode Prose Styles */
    .dark .prose {
        color: #e5e7eb;
    }
    
    .dark .prose h1,
    .dark .prose h2,
    .dark .prose h3,
    .dark .prose h4,
    .dark .prose h5,
    .dark .prose h6 {
        color: #f3f4f6;
    }
    
    .dark .prose strong {
        color: #f9fafb;
    }
    
    .dark .prose a {
        color: #60a5fa;
    }
    
    .dark .prose a:hover {
        color: #93c5fd;
    }
    
    .dark .prose code {
        color: #fbbf24;
        background-color: #1f2937;
    }
    
    .dark .prose pre {
        background-color: #1e293b;
        color: #e2e8f0;
    }
    
    .dark .prose blockquote {
        border-left-color: #3b82f6;
        color: #d1d5db;
        background: linear-gradient(to right, rgba(59, 130, 246, 0.1), transparent);
    }
    
    .dark .prose table {
        color: #e5e7eb;
    }
    
    .dark .prose thead {
        background: linear-gradient(135deg, #1e3a8a, #1e40af);
        color: white;
    }
    
    .dark .prose tbody tr {
        border-bottom-color: #374151;
    }
    
    .dark .prose tbody tr:hover {
        background-color: #1f2937;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Smooth Scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Line Clamp */
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
</style>
@endpush

@push('scripts')
<script>
    // Track View Count
    document.addEventListener('DOMContentLoaded', function() {
        // Increment view count
        fetch('{{ route("blog.increment-view", $blog->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        }).then(response => response.json())
          .then(data => {
              if (data.views) {
                  document.getElementById('viewCount').textContent = data.views.toLocaleString() + ' views';
              }
          });
    });

    // Toggle Like Function
    function toggleLike(blogId) {
        fetch(`/blog/${blogId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const likeCount = document.getElementById('likeCount');
                const likeButton = document.getElementById('likeButton');
                const likeButtonText = document.getElementById('likeButtonText');
                const likeIcon = document.getElementById('likeIcon');
                
                likeCount.textContent = data.likes.toLocaleString() + ' likes';
                
                if (data.liked) {
                    likeButtonText.textContent = 'You liked this';
                    likeButton.classList.add('animate-pulse');
                    setTimeout(() => likeButton.classList.remove('animate-pulse'), 600);
                    showNotification('You liked this post! ❤️', 'success');
                } else {
                    likeButtonText.textContent = 'Like this post';
                    showNotification('Like removed', 'info');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update like', 'error');
        });
    }

    // Share Functions
    function shareOnTwitter() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $blog->title }}');
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
    }

    function shareOnFacebook() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
    }

    function copyLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            showNotification('Link copied to clipboard! 📋', 'success');
        }).catch(() => {
            showNotification('Failed to copy link', 'error');
        });
    }

    // Delete Blog Function
    function deleteBlog(blogId) {
        showConfirmModal('Delete Blog Post', 
            'Are you sure you want to delete this blog post? This action cannot be undone.', 
            function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/blog/${blogId}`;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        );
    }

    // Notification Function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 z-50 max-w-md animate-slide-in';

        const bgColors = {
            'success': 'bg-green-500 dark:bg-green-600',
            'error': 'bg-red-500 dark:bg-red-600',
            'warning': 'bg-yellow-500 dark:bg-yellow-600',
            'info': 'bg-blue-500 dark:bg-blue-600'
        };

        const icons = {
            'success': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
            'error': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
            'warning': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
            'info': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
        };

        notification.innerHTML = `
            <div class="${bgColors[type]} text-white p-4 rounded-lg shadow-2xl flex items-center">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${icons[type]}
                </svg>
                <span class="flex-1">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 5000);
    }

    // Confirmation Modal
    function showConfirmModal(title, message, onConfirm) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-gray-900 bg-opacity-75 dark:bg-opacity-90 flex items-center justify-center z-[9999] animate-fade-in';
        modal.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 max-w-md mx-4 transform transition-all">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">${title}</h3>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-6">${message}</p>
                <div class="flex justify-end space-x-3">
                    <button id="cancelBtn" type="button" class="px-6 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <button id="confirmBtn" type="button" class="px-6 py-2 text-sm font-medium text-white bg-red-600 dark:bg-red-500 rounded-lg hover:bg-red-700 dark:hover:bg-red-600 transition-colors">
                        Confirm
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        document.getElementById('cancelBtn').addEventListener('click', () => modal.remove());
        document.getElementById('confirmBtn').addEventListener('click', () => {
            onConfirm();
            modal.remove();
        });
    }

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush