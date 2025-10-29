@extends('admin-panel::layouts.guest')

@section('title', 'Blog - ' . config('app.name'))
@section('page-heading', 'Our Blog')

@push('meta-tags')
    <!-- SEO Meta Tags -->
    <meta name="description" content="Read our latest blog posts and articles">
    <meta name="keywords" content="blog, articles, news, updates">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Blog - {{ config('app.name') }}">
    <meta property="og:description" content="Read our latest blog posts and articles">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="Blog - {{ config('app.name') }}">
    <meta name="twitter:description" content="Read our latest blog posts and articles">
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-900 dark:via-slate-900 dark:to-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="flex mb-8 animate-fade-in" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-full px-6 py-3 shadow-lg">
                <li class="inline-flex items-center">
                    <a href="/" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 inline-flex items-center transition-all duration-300 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-gray-700 dark:text-gray-300 md:ml-2 font-bold">Blog</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Page Header -->
        <div class="text-center mb-16 animate-fade-in-up">
            <div class="inline-block mb-4">
                <span class="px-6 py-2 bg-gradient-to-r from-blue-500/10 to-purple-500/10 dark:from-blue-500/20 dark:to-purple-500/20 backdrop-blur-sm rounded-full text-blue-600 dark:text-blue-400 font-semibold text-sm border border-blue-200 dark:border-blue-700">
                    ✨ Discover Amazing Content
                </span>
            </div>
            <h1 class="text-6xl md:text-7xl font-black bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent mb-6 tracking-tight">
                Our Blog
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto font-light">
                Dive into insights, stories, and updates from our creative minds
            </p>
        </div>

        <!-- Search & Filter Section with AJAX -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl p-8 mb-12 border border-gray-200 dark:border-gray-700">
            <form id="searchForm" class="flex flex-col md:flex-row gap-4">
                @csrf
                <!-- Search Input -->
                <div class="flex-1 relative group">
                    <input type="text" 
                           id="searchInput"
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search articles, topics, ideas..." 
                           class="w-full pl-14 pr-4 py-4 border-2 border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-2xl shadow-sm focus:ring-4 focus:ring-blue-500/30 dark:focus:ring-blue-400/30 focus:border-blue-500 dark:focus:border-blue-400 transition-all duration-300 font-medium">
                    <div class="absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex gap-3">
                    <button type="submit" 
                            class="px-10 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 text-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 active:scale-95 transition-all duration-300 font-bold flex items-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Search</span>
                    </button>
                    
                    @if(request('search'))
                        <button type="button" 
                                id="clearSearch"
                                class="px-8 py-4 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-2xl font-bold transition-all duration-300 flex items-center space-x-2 transform hover:scale-105 active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Clear</span>
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Categories Filter Pills with AJAX -->
        <div class="flex flex-wrap gap-3 mb-12" id="categoriesFilter">
            <button data-category="" 
                    class="category-filter px-8 py-4 rounded-full font-bold transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg
                           {{ !request('category') ? 'bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white shadow-xl' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:shadow-xl' }}">
                <span class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>All Posts</span>
                </span>
            </button>
            @foreach($categories as $cat)
                <button data-category="{{ $cat->slug }}" 
                        class="category-filter px-8 py-4 rounded-full font-bold transition-all duration-300 transform hover:scale-105 active:scale-95 shadow-lg flex items-center space-x-3
                               bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:shadow-xl hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white group">
                    <span>{{ $cat->name }}</span>
                    <span class="px-3 py-1 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/50 dark:to-purple-900/50 group-hover:from-white/20 group-hover:to-white/20 rounded-full text-xs font-bold transition-all">
                        {{ $cat->blogs_count }}
                    </span>
                </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content - Blog Cards -->
            <div class="lg:col-span-2">
                <!-- Loading Spinner -->
                <div id="loadingSpinner" class="hidden">
                    <div class="flex items-center justify-center py-20">
                        <div class="relative">
                            <div class="w-20 h-20 border-4 border-blue-200 dark:border-blue-900 rounded-full"></div>
                            <div class="w-20 h-20 border-4 border-blue-600 dark:border-blue-400 border-t-transparent rounded-full animate-spin absolute top-0 left-0"></div>
                        </div>
                    </div>
                </div>

                <!-- Search Results Info -->
                <div id="searchInfo" class="mb-6 hidden">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-lg flex items-center justify-between">
                        <p class="text-gray-700 dark:text-gray-300 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Search results for: <strong class="text-blue-600 dark:text-blue-400" id="searchTerm"></strong></span>
                        </p>
                        <span class="text-sm font-semibold text-gray-500 dark:text-gray-400 px-4 py-2 bg-white dark:bg-gray-800 rounded-full" id="resultsCount"></span>
                    </div>
                </div>

                <!-- Blog Cards Container -->
                <div id="blogContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($blogs as $blog)
                        @include('blog::partials.blog-card', ['blog' => $blog])
                    @empty
                        @include('blog::partials.no-results')
                    @endforelse
                </div>

                <!-- Pagination -->
                <div id="paginationContainer" class="mt-8">
                    @if($blogs->hasPages())
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl p-6 border border-gray-200 dark:border-gray-700">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Categories Widget -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl p-8 sticky top-6 border border-gray-200 dark:border-gray-700 transform hover:scale-[1.02] transition-all duration-300">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-8 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        Categories
                    </h3>
                    <div class="space-y-3">
                        @foreach($categories as $cat)
                            <a href="{{ route('frontend.blog.category', $cat->slug) }}" 
                               class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl hover:from-blue-500 hover:to-purple-500 hover:text-white transition-all duration-300 group shadow-md hover:shadow-xl transform hover:translate-x-2">
                                <span class="font-bold text-lg">{{ $cat->name }}</span>
                                <span class="px-4 py-2 bg-white dark:bg-gray-800 group-hover:bg-white/20 rounded-full text-sm font-black transition-all shadow-inner">
                                    {{ $cat->blogs_count }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Popular Posts Widget -->
                @php
                    $popularPosts = \Sndpbag\Blog\Models\Blog::where('status', 'Published')
                        ->orderBy('views', 'desc')
                        ->take(5)
                        ->get();
                @endphp

                @if($popularPosts->count() > 0)
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-gray-200 dark:border-gray-700 transform hover:scale-[1.02] transition-all duration-300">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-8 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            Trending
                        </h3>
                        <div class="space-y-4">
                            @foreach($popularPosts as $index => $popularPost)
                                <a href="{{ route('frontend.blog.show', $popularPost->slug) }}" class="group block">
                                    <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                                        <div class="relative flex-shrink-0">
                                            <img src="{{ asset('storage/' . $popularPost->image) }}" 
                                                 alt="{{ $popularPost->title }}" 
                                                 class="w-24 h-24 object-cover rounded-xl shadow-lg">
                                            <div class="absolute -top-2 -left-2 w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-black text-xs shadow-lg">
                                                {{ $index + 1 }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 mb-3">
                                                {{ $popularPost->title }}
                                            </h4>
                                            <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-gray-400">
                                                <span class="flex items-center space-x-1 font-semibold">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    <span>{{ number_format($popularPost->views) }}</span>
                                                </span>
                                                <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                                <span class="font-semibold">{{ $popularPost->published_date->format('M d') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Newsletter Widget -->
                <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl p-10 text-white transform hover:scale-[1.02] transition-all duration-300 relative overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mb-16"></div>
                    
                    <div class="text-center relative z-10">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black mb-3">Stay Updated!</h3>
                        <p class="text-white/90 mb-8 text-lg">Subscribe for the latest insights</p>
                        
                        <form id="newsletterForm" action="{{ route('blog.newsletter.subscribe') }}" method="POST" class="space-y-4">
                            @csrf
                            @auth
                                <input type="email" name="email" required readonly
                                       value="{{ auth()->user()->email }}"
                                       class="w-full px-6 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/30 rounded-2xl text-white placeholder-white/70 focus:outline-none focus:ring-4 focus:ring-white/30 transition-all cursor-not-allowed font-medium">
                            @else
                                <input type="email" id="newsletterEmail" name="email" required
                                       value="{{ old('email') }}"
                                       class="w-full px-6 py-4 bg-white/20 backdrop-blur-sm border-2 border-white/30 rounded-2xl text-white placeholder-white/70 focus:outline-none focus:ring-4 focus:ring-white/30 transition-all font-medium"
                                       placeholder="Enter your email">
                            @endauth

                            <button type="submit" id="newsletterButton"
                                    class="w-full py-4 bg-white text-purple-600 rounded-2xl font-black hover:shadow-2xl transform hover:scale-105 active:scale-95 transition-all duration-300 text-lg">
                                Subscribe Now 🚀
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Tags Cloud -->
                @php
                    $allTags = \Sndpbag\Blog\Models\Blog::where('status', 'Published')
                        ->whereNotNull('tags')
                        ->pluck('tags')
                        ->flatMap(function($tags) {
                            return explode(',', $tags);
                        })
                        ->map(function($tag) {
                            return trim($tag);
                        })
                        ->filter()
                        ->countBy()
                        ->sortDesc()
                        ->take(15);
                @endphp

                @if($allTags->count() > 0)
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-gray-200 dark:border-gray-700 transform hover:scale-[1.02] transition-all duration-300">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-8 flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-500 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            Popular Tags
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($allTags as $tag => $count)
                                <a href="{{ route('frontend.blog.index', ['search' => $tag]) }}" 
                                   class="px-5 py-3 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/30 dark:to-purple-900/30 hover:from-blue-500 hover:to-purple-500 hover:text-white text-blue-700 dark:text-blue-300 text-sm font-bold rounded-full shadow-md hover:shadow-xl transform hover:scale-110 active:scale-95 transition-all duration-300">
                                    #{{ $tag }} <span class="text-xs opacity-75">({{ $count }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-4"></div>
@endsection

@push('styles')
<style>
/* Enhanced Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(40px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out;
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.animate-slide-in-right {
    animation: slideInRight 0.6s ease-out;
}

/* Line Clamp Utilities */
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

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 12px;
}

::-webkit-scrollbar-track {
    background: linear-gradient(to bottom, #f1f5f9, #e2e8f0);
}

.dark ::-webkit-scrollbar-track {
    background: linear-gradient(to bottom, #1e293b, #0f172a);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
    border-radius: 10px;
    border: 2px solid transparent;
    background-clip: padding-box;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #2563eb, #7c3aed);
    background-clip: padding-box;
}

/* Glassmorphism Effect */
.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* Loading Spinner */
@keyframes spin {
    to { transform: rotate(360deg); }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Smooth Transitions */
* {
    transition-property: background-color, border-color, color, fill, stroke;
    transition-duration: 200ms;
    transition-timing-function: ease-in-out;
}

/* Card Hover Effects */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

/* Pulse Animation for Badges */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
@endpush

@push('scripts')
<script>
// AJAX Configuration
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

// Toast Notification Function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const colors = {
        'success': 'from-green-500 to-emerald-600',
        'error': 'from-red-500 to-rose-600',
        'warning': 'from-yellow-500 to-orange-600',
        'info': 'from-blue-500 to-indigo-600'
    };
    
    const icons = {
        'success': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
        'error': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
        'warning': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
        'info': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
    };

    toast.className = 'transform transition-all duration-500 ease-out opacity-0 translate-x-full';
    toast.innerHTML = `
        <div class="bg-gradient-to-r ${colors[type]} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center space-x-3 min-w-[320px] backdrop-blur-sm">
            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${icons[type]}
                </svg>
            </div>
            <span class="flex-1 font-semibold">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white/80 hover:text-white transition-colors ml-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    const container = document.getElementById('toastContainer');
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('opacity-0', 'translate-x-full');
    }, 100);
    
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-x-full');
        setTimeout(() => toast.remove(), 500);
    }, 5000);
}

// AJAX Blog Search Function
function searchBlogs(page = 1) {
    const searchInput = document.getElementById('searchInput');
    const blogContainer = document.getElementById('blogContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const paginationContainer = document.getElementById('paginationContainer');
    const searchInfo = document.getElementById('searchInfo');
    
    const searchTerm = searchInput.value.trim();
    const activeCategory = document.querySelector('.category-filter.active')?.dataset.category || '';
    
    // Show loading
    loadingSpinner.classList.remove('hidden');
    blogContainer.style.opacity = '0.5';
    
    // Build URL
    let url = new URL('{{ route("frontend.blog.index") }}');
    if (searchTerm) url.searchParams.set('search', searchTerm);
    if (activeCategory) url.searchParams.set('category', activeCategory);
    if (page > 1) url.searchParams.set('page', page);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        // Hide loading
        loadingSpinner.classList.add('hidden');
        blogContainer.style.opacity = '1';
        
        // Update blog container
        if (data.html) {
            blogContainer.innerHTML = data.html;
            
            // Animate cards
            const cards = blogContainer.querySelectorAll('article');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }
        
        // Update pagination
        if (data.pagination) {
            paginationContainer.innerHTML = data.pagination;
        } else {
            paginationContainer.innerHTML = '';
        }
        
        // Show search info
        if (searchTerm) {
            searchInfo.classList.remove('hidden');
            document.getElementById('searchTerm').textContent = searchTerm;
            document.getElementById('resultsCount').textContent = `${data.total || 0} ${data.total === 1 ? 'result' : 'results'}`;
            
            if (data.total > 0) {
                showToast(`Found ${data.total} result${data.total !== 1 ? 's' : ''} for "${searchTerm}"`, 'success');
            } else {
                showToast('No results found. Try a different search term.', 'warning');
            }
        } else {
            searchInfo.classList.add('hidden');
        }
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    })
    .catch(error => {
        console.error('Search error:', error);
        loadingSpinner.classList.add('hidden');
        blogContainer.style.opacity = '1';
        showToast('An error occurred. Please try again.', 'error');
    });
}

// Search Form Handler
document.getElementById('searchForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    searchBlogs();
});

// Clear Search Button
document.getElementById('clearSearch')?.addEventListener('click', function() {
    document.getElementById('searchInput').value = '';
    searchBlogs();
});

// Category Filter Buttons
document.querySelectorAll('.category-filter').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all buttons
        document.querySelectorAll('.category-filter').forEach(btn => {
            btn.classList.remove('active', 'bg-gradient-to-r', 'from-blue-600', 'via-purple-600', 'to-pink-600', 'text-white', 'shadow-xl');
            btn.classList.add('bg-white', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300');
        });
        
        // Add active class to clicked button
        this.classList.add('active', 'bg-gradient-to-r', 'from-blue-600', 'via-purple-600', 'to-pink-600', 'text-white', 'shadow-xl');
        this.classList.remove('bg-white', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300');
        
        const category = this.dataset.category;
        
        // Update URL without reload
        const url = new URL(window.location);
        if (category) {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }
        window.history.pushState({}, '', url);
        
        // Fetch blogs for this category
        searchBlogs();
    });
});

// Newsletter Form AJAX
document.getElementById('newsletterForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const button = document.getElementById('newsletterButton');
    const email = document.getElementById('newsletterEmail')?.value || '{{ auth()->user()->email ?? "" }}';
    
    // Disable button
    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message || 'Successfully subscribed to newsletter! 🎉', 'success');
            form.reset();
        } else {
            showToast(data.message || 'Subscription failed. Please try again.', 'error');
        }
    })
    .catch(error => {
        console.error('Newsletter error:', error);
        showToast('An error occurred. Please try again.', 'error');
    })
    .finally(() => {
        // Re-enable button
        button.disabled = false;
        button.innerHTML = 'Subscribe Now 🚀';
    });
});

// Pagination AJAX Handler
document.addEventListener('click', function(e) {
    if (e.target.closest('.pagination a')) {
        e.preventDefault();
        const url = new URL(e.target.closest('.pagination a').href);
        const page = url.searchParams.get('page');
        if (page) {
            searchBlogs(page);
        }
    }
});

// Real-time Search (Optional - debounced)
let searchTimeout;
document.getElementById('searchInput')?.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        if (this.value.length >= 3 || this.value.length === 0) {
            searchBlogs();
        }
    }, 500);
});

// Keyboard Shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('searchInput');
        searchInput?.focus();
        searchInput?.select();
    }
    
    // Escape to clear search
    if (e.key === 'Escape') {
        const searchInput = document.getElementById('searchInput');
        if (searchInput && searchInput.value) {
            searchInput.value = '';
            searchBlogs();
        }
    }
});

// Smooth Scroll for Internal Links
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

// Lazy Loading for Images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                observer.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// View Counter (track views on scroll)
let viewsCounted = false;
window.addEventListener('scroll', function() {
    if (!viewsCounted && window.scrollY > 300) {
        viewsCounted = true;
        // Track page view analytics here
        console.log('Page view tracked');
    }
});

// Dark Mode Toggle Animation
const darkModeObserver = new MutationObserver(() => {
    document.body.style.transition = 'background-color 0.3s ease';
});

if (document.documentElement) {
    darkModeObserver.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
}

// Initial load animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate page elements on load
    const elements = document.querySelectorAll('.animate-on-scroll');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
            }
        });
    }, { threshold: 0.1 });
    
    elements.forEach(el => observer.observe(el));
    
    // Show initial search results if present
    @if(request('search'))
        const resultsCount = {{ $blogs->total() }};
        if (resultsCount > 0) {
            showToast(`Found ${resultsCount} result${resultsCount !== 1 ? 's' : ''} for "{{ request('search') }}"`, 'success');
        }
    @endif
});

// Service Worker for offline support (optional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        // navigator.serviceWorker.register('/sw.js');
    });
}
</script>
@endpush