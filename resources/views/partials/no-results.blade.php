<div class="col-span-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl rounded-3xl shadow-2xl p-16 text-center border border-gray-200 dark:border-gray-700">
    <div class="max-w-md mx-auto">
        <!-- Animated Icon -->
        <div class="relative mb-8">
            <div class="w-32 h-32 mx-auto bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-200 dark:bg-blue-900/20 rounded-full -mr-8 -mt-8 opacity-50"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-purple-200 dark:bg-purple-900/20 rounded-full -ml-6 -mb-6 opacity-50"></div>
        </div>

        <!-- Message -->
        <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-4 bg-gradient-to-r from-gray-700 to-gray-900 dark:from-gray-100 dark:to-gray-300 bg-clip-text text-transparent">
            No Posts Found
        </h3>
        
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
            @if(request('search'))
                We couldn't find any posts matching <strong class="text-blue-600 dark:text-blue-400">"{{ request('search') }}"</strong>. Try different keywords or browse all posts.
            @else
                There are no published posts yet. Check back soon for amazing content!
            @endif
        </p>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if(request('search'))
                <button onclick="document.getElementById('searchInput').value = ''; searchBlogs();"
                        class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 text-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 active:scale-95 transition-all duration-300 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    <span>Browse All Posts</span>
                </button>
                
                <button onclick="document.getElementById('searchInput').focus();"
                        class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-2xl shadow-lg hover:shadow-xl font-bold transition-all duration-300 border-2 border-gray-200 dark:border-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Try New Search</span>
                </button>
            @else
                <a href="{{ route('frontend.blog.index') }}" 
                   class="inline-flex items-center justify-center space-x-2 px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 text-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 active:scale-95 transition-all duration-300 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Refresh Page</span>
                </a>
            @endif
        </div>
        
        <!-- Suggestions -->
        <div class="mt-12 p-6 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl border border-blue-200 dark:border-blue-800">
            <h4 class="font-bold text-gray-900 dark:text-white mb-3 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Search Tips
            </h4>
            <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-2 text-left">
                <li class="flex items-start">
                    <span class="text-blue-600 dark:text-blue-400 mr-2">•</span>
                    <span>Try using different or more general keywords</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-600 dark:text-blue-400 mr-2">•</span>
                    <span>Check your spelling</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-600 dark:text-blue-400 mr-2">•</span>
                    <span>Use fewer keywords to broaden your search</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-600 dark:text-blue-400 mr-2">•</span>
                    <span>Browse categories to discover content</span>
                </li>
            </ul>
        </div>
    </div>
</div>