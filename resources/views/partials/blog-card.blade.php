<article class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden transform hover:scale-[1.03] hover:shadow-2xl transition-all duration-500 group flex flex-col border border-gray-100 dark:border-gray-700">
    <!-- Image -->
    <div class="relative h-64 overflow-hidden">
        <img src="{{ asset('storage/' . $blog->image) }}" 
             alt="{{ $blog->title }}" 
             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 group-hover:rotate-2">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
        
        <!-- Badges -->
        <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
            @if($blog->is_featured)
                <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-black rounded-full shadow-lg animate-pulse backdrop-blur-sm">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    FEATURED
                </span>
            @endif
            
            @if($blog->category)
                <a href="{{ route('frontend.blog.category', $blog->category->slug) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white text-xs font-black rounded-full shadow-lg backdrop-blur-sm transition-all duration-300 transform hover:scale-110">
                    {{ strtoupper($blog->category->name) }}
                </a>
            @endif
        </div>

        <!-- Reading Time & Date -->
        <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between z-10">
            <div class="flex items-center space-x-2 bg-black/60 backdrop-blur-md text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $blog->reading_time }} min read</span>
            </div>
            <div class="bg-black/60 backdrop-blur-md text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                {{ $blog->published_date->format('M d, Y') }}
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="p-6 flex-1 flex flex-col">
        <!-- Author Info -->
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center text-white font-black text-sm shadow-lg ring-2 ring-white dark:ring-gray-800">
                {{ substr($blog->author->name ?? 'A', 0, 1) }}
            </div>
            <div>
                <p class="font-bold text-gray-900 dark:text-white text-sm">
                    {{ $blog->author->name ?? 'Anonymous' }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Author
                </p>
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-xl font-black text-gray-900 dark:text-white mb-3 group-hover:text-transparent group-hover:bg-gradient-to-r group-hover:from-blue-600 group-hover:to-purple-600 group-hover:bg-clip-text transition-all duration-300 line-clamp-2 leading-tight">
            <a href="{{ route('frontend.blog.show', $blog->slug) }}">{{ $blog->title }}</a>
        </h2>

        <!-- Excerpt -->
        @if($blog->excerpt)
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed line-clamp-3 mb-4 flex-1">
                {{ $blog->excerpt }}
            </p>
        @endif

        <!-- Footer Stats -->
        <div class="flex items-center justify-between pt-4 border-t-2 border-gray-100 dark:border-gray-700 mt-auto">
            <div class="flex items-center space-x-4 text-sm">
                <span class="flex items-center space-x-1 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>{{ number_format($blog->views) }}</span>
                </span>
                <span class="flex items-center space-x-1 text-gray-500 dark:text-gray-400 hover:text-red-500 transition-colors font-semibold">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ $blog->likes()->count() }}</span>
                </span>
                <span class="flex items-center space-x-1 text-gray-500 dark:text-gray-400 hover:text-green-500 transition-colors font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span>{{ $blog->comments->count() }}</span>
                </span>
            </div>

            <a href="{{ route('frontend.blog.show', $blog->slug) }}" 
               class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-full shadow-lg hover:shadow-xl font-bold text-sm group/btn transition-all duration-300 transform hover:scale-105 active:scale-95">
                <span>Read More</span>
                <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</article>