@extends('admin-panel::layouts.guest')

@section('title', $blog->title . ' - ' . config('app.name'))
@section('page-heading', $blog->title)

@push('meta-tags')
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $blog->meta_description ?? $blog->excerpt }}">
    <meta name="keywords" content="{{ $blog->tags }}">
    <meta name="author" content="{{ $blog->author->name ?? config('app.name') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $blog->meta_title ?? $blog->title }}">
    <meta property="og:description" content="{{ $blog->meta_description ?? $blog->excerpt }}">
    <meta property="og:image" content="{{ asset('storage/' . $blog->image) }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $blog->meta_title ?? $blog->title }}">
    <meta name="twitter:description" content="{{ $blog->meta_description ?? $blog->excerpt }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $blog->image) }}">
@endpush

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumb -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href=" "
                            class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            {{-- <a href="{{ route('blog.list') }}" class="ml-1 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 md:ml-2">Blog</a> --}}
                            <a href=" "
                                class="ml-1 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 md:ml-2">Blog</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span
                                class="ml-1 text-gray-500 dark:text-gray-400 md:ml-2 truncate max-w-xs">{{ Str::limit($blog->title, 50) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Blog Header Card -->
                    <article
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-all duration-300">
                        <!-- Featured Image -->
                        <div class="relative h-96 overflow-hidden">
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                                class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                            <!-- Floating Badges -->
                            <div class="absolute top-4 left-4 flex gap-2">
                                @if ($blog->is_featured)
                                    <span
                                        class="px-4 py-2 bg-yellow-500 text-white text-xs font-bold rounded-full shadow-lg flex items-center animate-pulse">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        Featured
                                    </span>
                                @endif
                                @if ($blog->category)
                                    <span
                                        class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-xs font-bold rounded-full shadow-lg">
                                        {{ $blog->category->name }}
                                    </span>
                                @endif
                            </div>

                            <!-- Title Overlay -->
                            <div class="absolute bottom-0 left-0 right-0 p-8">
                                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight drop-shadow-2xl">
                                    {{ $blog->title }}
                                </h1>
                            </div>
                        </div>

                        <!-- Meta Information Bar -->
                        <div style="background-color: var(--primary);"
                            class="  dark:from-blue-700 dark:to-purple-700 text-white p-6">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="flex items-center space-x-6">
                                    <!-- Author -->
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-lg font-bold">
                                            {{ substr($blog->author->name ?? 'A', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs opacity-80">Written by</p>
                                            <p class="font-semibold">{{ $blog->author->name ?? 'Anonymous' }}</p>
                                        </div>
                                    </div>

                                    <!-- Date -->
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-sm">{{ $blog->published_date->format('M d, Y') }}</span>
                                    </div>

                                    <!-- Reading Time -->
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm">{{ $blog->reading_time }} min read</span>
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="flex items-center space-x-6">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <span id="viewCount"
                                            class="text-sm font-semibold">{{ number_format($blog->views) }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span id="totalLikes"
                                            class="text-sm font-semibold">{{ number_format($blog->likes()->count()) }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        <span class="text-sm font-semibold">{{ $blog->comments->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Excerpt -->
                        @if ($blog->excerpt)
                            <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-xl text-gray-700 dark:text-gray-300 italic leading-relaxed">
                                    "{{ $blog->excerpt }}"
                                </p>
                            </div>
                        @endif

                        <!-- Blog Content -->
                        <div class="p-8 md:p-12">
                            <div
                                class="prose prose-lg dark:prose-invert max-w-none 
                                    prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-gray-100
                                    prose-p:text-gray-700 dark:prose-p:text-gray-300 prose-p:leading-relaxed
                                    prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline
                                    prose-strong:text-gray-900 dark:prose-strong:text-gray-100
                                    prose-img:rounded-xl prose-img:shadow-2xl
                                    prose-blockquote:border-l-4 prose-blockquote:border-blue-600 prose-blockquote:bg-blue-50 dark:prose-blockquote:bg-blue-900/20 prose-blockquote:py-2
                                    prose-code:text-pink-600 dark:prose-code:text-pink-400 prose-code:bg-gray-100 dark:prose-code:bg-gray-800 prose-code:px-1 prose-code:rounded
                                    prose-pre:bg-gray-900 dark:prose-pre:bg-gray-950 prose-pre:shadow-2xl">
                                {!! $blog->content !!}
                            </div>
                        </div>

                        <!-- Tags Section -->
                        @if ($blog->tags)
                            <div class="px-8 pb-8">
                                <div class="flex flex-wrap items-center gap-2">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                    @foreach (explode(',', $blog->tags) as $tag)
                                        {{-- <a href="{{ route('blog.tag', trim($tag)) }}" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white text-sm font-medium rounded-full shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                        #{{ trim($tag) }}
                                    </a> --}}
                                        <a href=" "
                                            class="px-4 py-2   hover:to-purple-600 text-white text-sm font-medium rounded-full shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200"
                                            style="background-color: var(--secondary);">
                                            #{{ trim($tag) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Engagement Bar -->
                        <div class="border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-6">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <!-- Like Button -->
                                <button onclick="toggleLike({{ $blog->id }})" id="likeButton"
                                    class="group flex items-center space-x-3 px-6 py-3 bg-gradient-to-r from-pink-500 to-red-500 hover:from-pink-600 hover:to-red-600 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                    <svg id="likeIcon" class="w-6 h-6 group-hover:animate-pulse" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span id="likeButtonText" class="font-semibold">Like this post</span>
                                </button>

                                <!-- Share Buttons -->
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">Share:</span>

                                    <!-- Facebook -->
                                    <button onclick="shareOnFacebook()"
                                        class="p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-md hover:shadow-lg transform hover:scale-110 transition-all duration-200"
                                        title="Share on Facebook">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- Twitter -->
                                    <button onclick="shareOnTwitter()"
                                        class="p-3 bg-sky-500 hover:bg-sky-600 text-white rounded-full shadow-md hover:shadow-lg transform hover:scale-110 transition-all duration-200"
                                        title="Share on Twitter">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- WhatsApp -->
                                    <button onclick="shareOnWhatsApp()"
                                        class="p-3 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-md hover:shadow-lg transform hover:scale-110 transition-all duration-200"
                                        title="Share on WhatsApp">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- LinkedIn -->
                                    <button onclick="shareOnLinkedIn()"
                                        class="p-3 bg-blue-700 hover:bg-blue-800 text-white rounded-full shadow-md hover:shadow-lg transform hover:scale-110 transition-all duration-200"
                                        title="Share on LinkedIn">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z">
                                            </path>
                                        </svg>
                                    </button>

                                    <!-- Copy Link -->
                                    <button onclick="copyLink()"
                                        class="p-3 bg-gray-700 hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-700 text-white rounded-full shadow-md hover:shadow-lg transform hover:scale-110 transition-all duration-200"
                                        title="Copy Link">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Comments Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-8 h-8 mr-3 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                Comments <span
                                    class="text-blue-600 dark:text-blue-400 ml-2">({{ $blog->comments->count() }})</span>
                            </h2>
                        </div>

                        <!-- Comment Form -->
                        @auth
                            <form action="{{ route('frontend.blog.comment', $blog->slug) }}" method="POST" class="mb-10">
                                @csrf
                                <div class="space-y-4">
                                    <div class="relative">
                                        <textarea name="content" rows="4"
                                            class="w-full px-6 py-4 border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl shadow-sm focus:ring-4 focus:ring-blue-500/20 dark:focus:ring-blue-400/20 focus:border-blue-500 dark:focus:border-blue-400 transition-all resize-none"
                                            placeholder="Share your thoughts..." required></textarea>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Be respectful and constructive
                                        </p>
                                        <button type="submit" style="background-color: var(--primary);"
                                            class="group relative px-8 py-3      hover:from-blue-700 hover:to-purple-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            <span class="font-semibold">Post Comment</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div
                                class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl p-8 text-center mb-10 border-2 border-dashed border-blue-300 dark:border-blue-700">
                                <svg class="w-16 h-16 mx-auto mb-4 text-blue-500 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Join the Conversation</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">Please login to post a comment</p>
                                <div class="flex items-center justify-center space-x-4">
                                    <a href="{{ route('login') }}"
                                        class="px-8 py-3   hover:from-blue-700 hover:to-purple-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-semibold"
                                        style="background-color: var(--primary);">
                                        Login
                                    </a>
                                    <a href="{{ route('register') }}"
                                        class="px-8 py-3 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 border-2 border-blue-600 dark:border-blue-400 rounded-xl hover:bg-blue-50 dark:hover:bg-gray-600 transition-all duration-200 font-semibold">
                                        Register
                                    </a>
                                </div>
                            </div>
                        @endauth
 

                        {{-- Comments List --}}
                        <div class="space-y-6" id="commentsList">
                            @forelse($blog->comments as $comment)
                                {{-- এইখানে ক্লাস যোগ করা হচ্ছে এবং একটি শর্তসাপেক্ষ ব্যাজ যোগ করা হচ্ছে --}}
                                <div class="comment-item group bg-gradient-to-br from-gray-50 to-blue-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6 hover:shadow-xl transition-all duration-300 border-l-4 {{ $comment->status == 'pending' ? 'border-yellow-500 opacity-80' : 'border-blue-500' }}"
                                    data-comment-id="{{ $comment->id }}">

                                    <div class="flex items-start space-x-4">
                                        {{-- Avatar --}}
                                        <div class="flex-shrink-0">
                                            <div style="background-color: var(--primary);"
                                                class="w-14 h-14 rounded-full   to-pink-500 flex items-center justify-center text-white font-bold text-xl shadow-lg ring-4 ring-white dark:ring-gray-800">
                                                {{ substr($comment->user->name ?? 'U', 0, 1) }}
                                            </div>
                                        </div>

                                        {{-- Comment Content --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <h4 class="font-bold text-gray-900 dark:text-white text-lg">
                                                        {{ $comment->user->name ?? 'Anonymous' }}</h4>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $comment->created_at->diffForHumans() }}

                                                        {{-- *** অপেক্ষমাণ স্ট্যাটাস দেখানোর জন্য ব্যাজ *** --}}
                                                        @if ($comment->status == 'pending' && Auth::check() && $comment->user_id == Auth::id())
                                                            <span
                                                                class="ml-3 px-2 py-0.5 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Awaiting
                                                                Approval</span>
                                                        @endif
                                                        {{-- *** ব্যাজ শেষ *** --}}
                                                    </p>
                                                </div>
                                                {{-- Delete button er code --}}
                                                @auth
                                                    @if ($comment->user_id === auth()->id())
                                                        <button onclick="deleteComment({{ $comment->id }})"
                                                            class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 opacity-0 group-hover:opacity-100 transition-opacity"
                                                            title="Delete Comment">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                @endauth
                                            </div>

                                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">
                                                {{ $comment->body }}</p>

                                            {{-- Comment Actions (Like, Reply) --}}
                                            <div class="flex items-center space-x-6">
                                                {{-- Like Button --}}
                                                <button onclick="toggleCommentLike({{ $comment->id }})"
                                                    class="comment-like-btn flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400 transition-colors group/like">
                                                    <svg class="w-5 h-5 group-hover/like:scale-125 transition-transform"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                        </path>
                                                    </svg>
                                                    <span
                                                        class="text-sm font-semibold comment-like-count">{{ $comment->likes()->count() }}</span>
                                                </button>

                                                {{-- Reply Button --}}
                                                @auth
                                                    <button onclick="toggleReplyForm({{ $comment->id }})"
                                                        class="flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6">
                                                            </path>
                                                        </svg>
                                                        <span class="text-sm font-semibold">Reply</span>
                                                    </button>
                                                @endauth
                                            </div>

                                            {{-- Reply Form (Hidden by default) --}}
                                            @auth
                                                <div id="replyForm{{ $comment->id }}" class="hidden mt-4">
                                                    <form
                                                        action="{{ route('frontend.blog.comment.reply', [$blog->slug, $comment->id]) }}"
                                                        method="POST" class="space-y-3">
                                                        @csrf
                                                        <textarea name="content" rows="3"
                                                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all resize-none"
                                                            placeholder="Write your reply..." required></textarea>
                                                        <div class="flex items-center justify-end space-x-3">
                                                            <button type="button"
                                                                onclick="toggleReplyForm({{ $comment->id }})"
                                                                class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                                                                Cancel
                                                            </button>
                                                            <button type="submit" style="background-color: var(--primary);"
                                                                class="px-6 py-2 hover:from-blue-700 hover:to-purple-700 text-white rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all text-sm font-semibold">
                                                                Reply
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endauth

                                            {{-- Replies Loop --}}

                                            {{-- Replies Loop --}}
@if($comment->replies && $comment->replies->count() > 0)
    <div class="mt-6 space-y-4 pl-6 border-l-2 border-gray-300 dark:border-gray-600">
        @foreach($comment->replies as $reply)
            {{-- রিপ্লাইয়ের স্ট্যাটাসও চেক করুন এবং দরকার হলে ব্যাজ দেখান --}}
            {{-- *** এই div-এ data-comment-id যোগ করা হয়েছে *** --}}
            <div class="bg-white dark:bg-gray-900 rounded-lg p-4 shadow-md {{ $reply->status == 'pending' ? 'opacity-75 border border-yellow-300' : '' }}" data-comment-id="{{ $reply->id }}">
                <div class="flex items-start space-x-3">
                    {{-- Reply Avatar --}}
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-teal-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ substr($reply->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h5 class="font-semibold text-gray-900 dark:text-white">{{ $reply->user->name ?? 'Anonymous' }}</h5>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $reply->created_at->diffForHumans() }}
                                {{-- রিপ্লাইয়ের জন্য অপেক্ষমাণ ব্যাজ --}}
                                @if($reply->status == 'pending' && Auth::check() && $reply->user_id == Auth::id())
                                    <span class="ml-2 px-1.5 py-0.5 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Pending</span>
                                @endif
                            </span>
                        </div>
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $reply->body }}</p>
                        {{-- Reply Like Button --}}
                        {{-- *** এই button-এ comment-like-btn ক্লাস যোগ করা হয়েছে *** --}}
                        <button onclick="toggleCommentLike({{ $reply->id }})"
                                class="mt-2 flex items-center space-x-1 text-gray-500 dark:text-gray-400 hover:text-pink-600 dark:hover:text-pink-400 transition-colors comment-like-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            {{-- *** এই span-এ comment-like-count ক্লাস যোগ করা হয়েছে *** --}}
                            <span class="text-xs comment-like-count">{{ $reply->likes()->count() }}</span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
                                          
                                        </div>
                                    </div>
                                </div>
                            @empty
                                {{-- No comments found message --}}
                                <div class="text-center py-16">
                                    <svg class="w-24 h-24 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    <h3 class="text-2xl font-bold text-gray-400 dark:text-gray-500 mb-2">No comments yet
                                    </h3>
                                    <p class="text-gray-500 dark:text-gray-400">Be the first to share your thoughts!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Author Card -->
                    <div style="background-color: var(--primary);"
                        class="  rounded-2xl shadow-2xl p-8 text-white transform hover:scale-105 transition-all duration-300">
                        <div class="text-center">
                            <div
                                class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-4xl font-bold mx-auto mb-4 shadow-xl ring-4 ring-white/30">
                                {{ substr($blog->author->name ?? 'A', 0, 1) }}
                            </div>
                            <h3 class="text-2xl font-bold mb-2">{{ $blog->author->name ?? 'Anonymous' }}</h3>
                            <p class="text-blue-100 text-sm mb-4">{{ $blog->author->email ?? '' }}</p>
                            <div class="flex items-center justify-center space-x-4 text-sm">
                                <div class="text-center">
                                    <p class="font-bold text-2xl">
                                        {{ \Sndpbag\Blog\Models\Blog::where('author_id', $blog->author_id)->where('author_type', $blog->author_type)->count() }}</p>
                                    <p class="text-blue-100 text-xs">Posts</p>
                                </div>
                                <div class="w-px h-12 bg-white/30"></div>
                                <div class="text-center">
                                    <p class="font-bold text-2xl">
                                        {{ \Sndpbag\Blog\Models\Blog::where('author_id', $blog->author_id)->where('author_type', $blog->author_type)->sum('views') }}
                                    </p>
                                    <p class="text-blue-100 text-xs">Views</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blog Stats -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600 dark:text-green-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Statistics
                        </h3>
                        <div class="space-y-4">
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Word Count</span>
                                <span
                                    class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ number_format($blog->word_count) }}</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/30 dark:to-green-800/30 rounded-xl">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Reading Time</span>
                                <span
                                    class="text-lg font-bold text-green-600 dark:text-green-400">{{ $blog->reading_time }}
                                    min</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-800/30 rounded-xl">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Views</span>
                                <span
                                    class="text-lg font-bold text-purple-600 dark:text-purple-400">{{ number_format($blog->views) }}</span>
                            </div>
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-r from-pink-50 to-pink-100 dark:from-pink-900/30 dark:to-pink-800/30 rounded-xl">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total Likes</span>
                                <span
                                    class="text-lg font-bold text-pink-600 dark:text-pink-400">{{ number_format($blog->likes()->count()) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if ($relatedPosts && $relatedPosts->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-orange-600 dark:text-orange-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                Related Posts
                            </h3>
                            <div class="space-y-4">
                                @foreach ($relatedPosts as $relatedPost)
                                    <a href="{{ route('frontend.blog.show', $relatedPost->slug) }}" class="group block">
                                        <div
                                            class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                                            <img src="{{ asset('storage/' . $relatedPost->image) }}"
                                                alt="{{ $relatedPost->title }}"
                                                class="w-20 h-20 object-cover rounded-lg shadow-md">
                                            <div class="flex-1 min-w-0">
                                                <h4
                                                    class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 mb-1">
                                                    {{ $relatedPost->title }}
                                                </h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    {{ $relatedPost->published_date->format('M d, Y') }}
                                                </p>
                                                <div
                                                    class="flex items-center mt-2 space-x-3 text-xs text-gray-500 dark:text-gray-400">
                                                    <span class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                        {{ number_format($relatedPost->views) }}
                                                    </span>
                                                    <span class="flex items-center">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $relatedPost->likes()->count() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Categories -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-purple-600 dark:text-purple-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                            Categories
                        </h3>
                        <div class="space-y-2">
                            @foreach (\Sndpbag\Blog\Models\BlogCategory::withCount('blogs')->get() as $category)
                                <a href="{{ route('frontend.blog.category', $category->slug) }}"
                                    class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gradient-to-r hover:from-blue-500 hover:to-purple-500 hover:text-white transition-all duration-300 group">
                                    <span class="font-medium">{{ $category->name }}</span>
                                    <span
                                        class="px-3 py-1 bg-gray-200 dark:bg-gray-600 group-hover:bg-white/20 rounded-full text-xs font-bold">
                                        {{ $category->blogs_count }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter Signup -->
                    {{-- <div style="background-color: var(--primary);" class="  rounded-2xl shadow-2xl p-8 text-white">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 opacity-80" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <h3 class="text-2xl font-bold mb-2">Stay Updated</h3>
                            <p class="text-indigo-100 mb-6">Subscribe to our newsletter for the latest posts</p>
                            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                            
                                @csrf
                                <input type="email" name="email" required
                                    class="w-full px-4 py-3 bg-white/20 backdrop-blur-sm border-2 border-white/30 rounded-lg text-white placeholder-indigo-200 focus:outline-none focus:ring-4 focus:ring-white/30"
                                    placeholder="Enter your email">
                                <button type="submit"
                                    class="w-full py-3 bg-white text-indigo-600 rounded-lg font-bold hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                                    Subscribe Now
                                </button>
                            </form>
                        </div>
                    </div> --}}

                    {{-- Newsletter Widget --}}
 {{-- Newsletter Widget --}}
<div style="background-color: var(--primary);" class="rounded-2xl shadow-2xl p-8 text-white">
    <div class="text-center">
        {{-- Icon and Text --}}
        <svg class="w-16 h-16 mx-auto mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>
        <h3 class="text-2xl font-bold mb-2">Stay Updated</h3>
        <p class="text-indigo-100 mb-6">Subscribe to our newsletter...</p>

        {{-- Error/Success message gulo eখান থেকে মুছে ফেলা হয়েছে --}}

        {{-- *** Form Action Route Updated *** --}}
        <form id="newsletterForm" action="{{ route('blog.newsletter.subscribe') }}" method="POST" class="space-y-3">
            @csrf
            @auth
                {{-- Logged-in user email input (readonly) --}}
                <input type="email" name="email" required readonly
                       value="{{ auth()->user()->email }}"
                       class="w-full px-4 py-3 bg-white/10 ... cursor-not-allowed">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
            @else
                {{-- Guest email input (editable) --}}
                <input type="email" id="newsletterEmail" name="email" required
                       value="{{ old('email') }}"
                       class="w-full px-4 py-3 bg-white/20 ... @error('email') border-red-500 ring-red-500/30 @enderror"
                       placeholder="Enter your email">
            @endauth

            <button type="submit" id="newsletterButton"
                    class="w-full py-3 bg-white text-indigo-600 ...">
                Subscribe Now
            </button>
        </form>
    </div>
</div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-4"></div>
@endsection

@push('scripts')
    <script>
        // Track view count on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('frontend.blog.increment-view', $blog->slug) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.views) {
                        document.getElementById('viewCount').textContent = data.views.toLocaleString();
                    }
                });
        });



        // *** START: Newsletter AJAX Form Submission ***
            const newsletterForm = document.getElementById('newsletterForm');
            const newsletterEmailInput = document.getElementById('newsletterEmail'); // Guest input
            const newsletterButton = document.getElementById('newsletterButton');

            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Page reload bondho korun

                    // Button-e loading state din
                    if (newsletterButton) {
                        newsletterButton.disabled = true;
                        newsletterButton.innerHTML = 'Subscribing...';
                    }

                    // Form theke data nin
                    const formData = new FormData(newsletterForm);
                    const email = formData.get('email');

                    fetch("{{ route('blog.newsletter.subscribe') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            email: email
                        })
                    })
                    .then(response => response.json().then(data => ({ status: response.status, body: data })))
                    .then(res => {
                        if (res.status >= 200 && res.status < 300) { // Success
                            showToast(res.body.message, 'success');
                            if (newsletterEmailInput) {
                                newsletterEmailInput.value = ''; // Guest hole field khali korun
                            }
                        } else if (res.status === 422) { // Validation error
                            // "email" field-er error dekhabe
                            if (res.body.errors && res.body.errors.email) {
                                showToast(res.body.errors.email[0], 'warning');
                            } else {
                                showToast(res.body.message || 'Validation error', 'warning');
                            }
                        } else {
                            // Onnano server error (500)
                            showToast(res.body.message || 'An error occurred', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Subscription Error:', error);
                        showToast('A network error occurred. Please try again.', 'error');
                    })
                    .finally(() => {
                        // Button-ke normal korun
                        if (newsletterButton) {
                            newsletterButton.disabled = false;
                            newsletterButton.innerHTML = 'Subscribe Now';
                        }
                    });
                });
            }
            // *** END: Newsletter AJAX Form Submission ***

        // Toggle Like Function
        function toggleLike(blogId) {
            @guest
            showToast('Please login to like this post', 'warning');
            setTimeout(() => {
                window.location.href = '{{ route('login') }}';
            }, 1500);
            return;
        @endguest

        fetch(`{{ route('frontend.blog.like', $blog->slug) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const likeButton = document.getElementById('likeButton');
                    const likeButtonText = document.getElementById('likeButtonText');
                    const totalLikes = document.getElementById('totalLikes');

                    totalLikes.textContent = data.likes.toLocaleString();

                    if (data.liked) {
                        likeButtonText.textContent = '❤️ You liked this';
                        likeButton.classList.add('animate-bounce');
                        showToast('You liked this post! ❤️', 'success');
                        setTimeout(() => likeButton.classList.remove('animate-bounce'), 1000);
                    } else {
                        likeButtonText.textContent = 'Like this post';
                        showToast('Like removed', 'info');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to update like', 'error');
            });
        }

        // Toggle Comment Like
        function toggleCommentLike(commentId) {
            @guest
            showToast('Please login to like comments', 'warning');
            return;
             @endguest

                 fetch(`/blog/comment/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const commentItem = document.querySelector(`[data-comment-id="${commentId}"]`);
                    const likeCount = commentItem.querySelector('.comment-like-count');
                    likeCount.textContent = data.likes;

                    showToast(data.liked ? 'Comment liked! 👍' : 'Like removed', data.liked ? 'success' : 'info');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to update like', 'error');
            });
        }

        // Toggle Reply Form
        function toggleReplyForm(commentId) {
            const replyForm = document.getElementById(`replyForm${commentId}`);
            replyForm.classList.toggle('hidden');
        }

        // Delete Comment
        function deleteComment(commentId) {
            if (confirm('Are you sure you want to delete this comment?')) {
                fetch(`/blog/comment/${commentId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`[data-comment-id="${commentId}"]`).remove();
                            showToast('Comment deleted successfully', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Failed to delete comment', 'error');
                    });
            }
        }

        // Share Functions
        function shareOnFacebook() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
            showToast('Opening Facebook share...', 'info');
        }

        function shareOnTwitter() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $blog->title }}');
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
            showToast('Opening Twitter share...', 'info');
        }

        function shareOnWhatsApp() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('{{ $blog->title }}');
            window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
            showToast('Opening WhatsApp share...', 'info');
        }

        function shareOnLinkedIn() {
            const url = encodeURIComponent(window.location.href);
            window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
            showToast('Opening LinkedIn share...', 'info');
        }

        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                showToast('Link copied to clipboard! 📋', 'success');
            }).catch(() => {
                showToast('Failed to copy link', 'error');
            });
        }

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
        <div class="bg-gradient-to-r ${colors[type]} text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 min-w-[300px]">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${icons[type]}
            </svg>
            <span class="flex-1 font-medium">${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

            const container = document.getElementById('toastContainer');
            container.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('opacity-0', 'translate-x-full');
            }, 100);

            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => toast.remove(), 500);
            }, 5000);
        }

        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
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

        // Reading Progress Bar
        window.addEventListener('scroll', function() {
            const article = document.querySelector('article');
            if (article) {
                const windowHeight = window.innerHeight;
                const documentHeight = article.offsetHeight;
                const scrollTop = window.pageYOffset;
                const trackLength = documentHeight - windowHeight;
                const percentage = Math.min((scrollTop / trackLength) * 100, 100);

                // Create or update progress bar
                let progressBar = document.getElementById('readingProgress');
                if (!progressBar) {
                    progressBar = document.createElement('div');
                    progressBar.id = 'readingProgress';
                    progressBar.className =
                        'fixed top-0 left-0 h-1 bg-[var(--primary)] z-50 transition-all duration-150';
                    document.body.appendChild(progressBar);
                }
                progressBar.style.width = percentage + '%';
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Custom Styles for Blog Show Page */
        .prose img {
            @apply rounded-xl shadow-2xl my-8;
        }

        .prose blockquote {
            @apply border-l-4 border-blue-600 bg-gradient-to-r from-blue-50 to-transparent dark:from-blue-900/20 dark:to-transparent pl-6 py-4 my-6 italic;
        }

        .prose pre {
            @apply bg-gray-900 dark:bg-gray-950 rounded-xl p-6 my-6 overflow-x-auto shadow-2xl;
        }

        .prose code {
            @apply text-pink-600 dark:text-pink-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded text-sm;
        }

        .prose table {
            @apply w-full my-8 shadow-xl rounded-xl overflow-hidden;
        }

        .prose th {
            @apply bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold px-6 py-4;
        }

        .prose td {
            @apply px-6 py-4 border-b border-gray-200 dark:border-gray-700;
        }

        .prose a {
            @apply text-blue-600 dark:text-blue-400 hover:underline transition-colors;
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

        /* Line Clamp Utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Gradient Text */
        .gradient-text {
            @apply bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600;
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
    </style>
@endpush
