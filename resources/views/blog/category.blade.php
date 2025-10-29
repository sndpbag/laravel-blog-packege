@extends('admin-panel::layouts.guest')

@section('title', $category->name . ' - Blog Category')
@section('page-heading', $category->name)

@push('meta-tags')
    <!-- SEO Meta Tags -->
    <meta name="description" content="Browse all blog posts in {{ $category->name }} category">
    <meta name="keywords" content="{{ $category->name }}, blog, articles">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $category->name }} - Blog Category">
    <meta property="og:description" content="Browse all blog posts in {{ $category->name }} category">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $category->name }} - Blog Category">
    <meta name="twitter:description" content="Browse all blog posts in {{ $category->name }} category">
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href=" " class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 inline-flex items-center transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href=" " class="ml-1 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 md:ml-2 transition-colors">Blog</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-500 dark:text-gray-400 md:ml-2 font-semibold">{{ $category->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Category Header -->
        <div style="background-color: var(--primary);" class="  to-pink-600 rounded-3xl shadow-2xl overflow-hidden mb-12 transform hover:scale-[1.01] transition-transform duration-300">
            <div class="relative p-12 text-center">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="relative z-10">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm mb-6 ring-8 ring-white/30">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 drop-shadow-2xl">{{ $category->name }}</h1>
                    <p class="text-xl text-blue-100 max-w-2xl mx-auto mb-6">
                        Explore {{ $blogs->total() }} amazing {{ Str::plural('article', $blogs->total()) }} in this category
                    </p>
                    <div class="flex items-center justify-center space-x-6 text-white/90">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="font-semibold">{{ $blogs->total() }} Posts</span>
                        </div>
                        <div class="w-px h-6 bg-white/30"></div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="font-semibold">{{ $blogs->sum('views') }} Views</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content - Blog List -->
            <div class="lg:col-span-2 space-y-8">
                @forelse($blogs as $blog)
                    <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden transform hover:scale-[1.02] hover:shadow-3xl transition-all duration-300 group">
                        <div class="grid md:grid-cols-5 gap-0">
                            <!-- Featured Image -->
                            <div class="md:col-span-2 relative h-64 md:h-auto overflow-hidden">
                                <img src="{{ asset('storage/' . $blog->image) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                
                                <!-- Badges -->
                                <div class="absolute top-4 left-4 space-y-2">
                                    @if($blog->is_featured)
                                        <span class="inline-flex items-center px-3 py-1 bg-yellow-500 text-white text-xs font-bold rounded-full shadow-lg animate-pulse">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            Featured
                                        </span>
                                    @endif
                                </div>

                                <!-- Stats Overlay -->
                                <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between text-white text-xs">
                                    <div class="flex items-center space-x-3">
                                        <span class="flex items-center space-x-1 bg-black/30 backdrop-blur-sm px-2 py-1 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <span>{{ number_format($blog->views) }}</span>
                                        </span>
                                        <span class="flex items-center space-x-1 bg-black/30 backdrop-blur-sm px-2 py-1 rounded-full">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $blog->likes()->count() }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="md:col-span-3 p-8 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center space-x-4 mb-4">
                                        <!-- Author -->
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-xs">
                                                {{ substr($blog->author->name ?? 'A', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $blog->author->name ?? 'Anonymous' }}</span>
                                        </div>

                                        <span class="text-gray-400">•</span>

                                        <!-- Date -->
                                        <div class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $blog->published_date->format('M d, Y') }}</span>
                                        </div>

                                        <span class="text-gray-400">•</span>

                                        <!-- Reading Time -->
                                        <div class="flex items-center space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>{{ $blog->reading_time }} min read</span>
                                        </div>
                                    </div>

                                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                        <a href="{{ route('frontend.blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                                    </h2>

                                    @if($blog->excerpt)
                                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed line-clamp-3 mb-4">
                                            {{ $blog->excerpt }}
                                        </p>
                                    @endif

                                    <!-- Tags -->
                                    @if($blog->tags)
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @foreach(array_slice(explode(',', $blog->tags), 0, 3) as $tag)
                                                <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-full">
                                                    #{{ trim($tag) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('frontend.blog.show', $blog->slug) }}" 
                                       class="inline-flex items-center space-x-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold group/btn transition-colors">
                                        <span>Read More</span>
                                        <svg class="w-5 h-5 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>

                                    <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            <span>{{ $blog->comments->count() }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-16 text-center">
                        <svg class="w-24 h-24 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-300 mb-2">No Posts Found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6">There are no published posts in this category yet.</p>
                        <a href="{{ route('frontend.blog.index') }}" 
                           class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-semibold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Browse All Posts</span>
                        </a>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if($blogs->hasPages())
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                        {{ $blogs->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- All Categories -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 sticky top-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        All Categories
                    </h3>
                    <div class="space-y-2">
                        @foreach($categories as $cat)
                            <a href="{{ route('frontend.blog.category', $cat->slug) }}" 
                               class="flex items-center justify-between p-3 rounded-lg transition-all duration-300 group
                                      @if($cat->id === $category->id) 
                                          bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg
                                      @else 
                                          bg-gray-50 dark:bg-gray-700 hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white
                                      @endif">
                                <span class="font-medium">{{ $cat->name }}</span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                            @if($cat->id === $category->id) 
                                                bg-white/20
                                            @else 
                                                bg-gray-200 dark:bg-gray-600 group-hover:bg-white/20
                                            @endif">
                                    {{ $cat->blogs_count }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Popular Posts -->
                @php
                    $popularPosts = \App\Models\Blog::where('status', 'Published')
                        ->where('category_id', $category->id)
                        ->orderBy('views', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                @if($popularPosts->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Popular in {{ $category->name }}
                        </h3>
                        <div class="space-y-4">
                            @foreach($popularPosts as $popularPost)
                                <a href="{{ route('frontend.blog.show', $popularPost->slug) }}" class="group block">
                                    <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                                        <img src="{{ asset('storage/' . $popularPost->image) }}" 
                                             alt="{{ $popularPost->title }}" 
                                             class="w-20 h-20 object-cover rounded-lg shadow-md flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 mb-2">
                                                {{ $popularPost->title }}
                                            </h4>
                                            <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400">
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    {{ number_format($popularPost->views) }}
                                                </span>
                                                <span>•</span>
                                                <span>{{ $popularPost->published_date->format('M d') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Newsletter -->
                <div style="background-color: var(--primary);" class=" rounded-2xl shadow-2xl p-8 text-white">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-2xl font-bold mb-2">Stay Updated</h3>
                        <p class="text-indigo-100 mb-6">Get the latest {{ $category->name }} posts delivered to your inbox</p>
                        <form action="" method="POST" class="space-y-3">
                            @csrf
                            <input type="email" name="email" required
                                   class="w-full px-4 py-3 bg-white/20 backdrop-blur-sm border-2 border-white/30 rounded-lg text-white placeholder-indigo-200 focus:outline-none focus:ring-4 focus:ring-white/30 transition-all"
                                   placeholder="Enter your email">
                            <button type="submit" 
                                    class="w-full py-3 bg-white text-indigo-600 rounded-lg font-bold hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                                Subscribe Now
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Line Clamp Utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    @apply bg-gray-100 dark:bg-gray-900;
}

::-webkit-scrollbar-thumb {
    @apply bg-gradient-to-b from-blue-500 to-purple-500 rounded-full;
}

::-webkit-scrollbar-thumb:hover {
    @apply from-blue-600 to-purple-600;
}

/* Dark Mode Transitions */
* {
    @apply transition-colors duration-200;
}

/* Hover Effects */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}
</style>
@endpush