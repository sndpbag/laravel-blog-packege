 @extends('admin-panel::dashboard.layouts.app')

 @section('title', 'Blog - Dashboard')
 @section('page-title', 'Blog Management System')
 @section('page-description', 'Professional blog content management and organization system')




 @section('breadcrumb')
     <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-primary transition-colors">Dashboard</a>
     <span class="text-gray-400 mx-2">/</span>
     <span class="text-primary font-medium">Blog Posts</span>
 @endsection

 @section('header-actions')
     <div class="flex items-center space-x-3">
         <a href="{{ route('blog.create') }}"
             class="flex items-center px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors hover:bg-opacity-90 shadow-md hover:shadow-lg"
             style="background: linear-gradient(135deg, #00499b, #1e5bb8);">
             <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                 </path>
             </svg>
             Create New Post
         </a>
         <button type="button" onclick="exportBlogs()"
             class="hidden md:flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
             <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                 </path>
             </svg>
             Export
         </button>
     </div>
 @endsection

 @section('content')
     <!-- Header Banner -->
     <div class="mb-8 bg-gradient-to-r rounded-xl p-6 text-white shadow-lg" style="background-color: var(--primary);">
         <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
             <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                 <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                     <svg class="w-8 h-8 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                         </path>
                     </svg>
                 </div>
                 <div>
                     <h2 class="text-2xl font-bold mb-1">📝 Blog Management</h2>
                     <p class="text-blue-100 text-lg">Professional blog content management and organization system</p>
                 </div>
             </div>

             <!-- Quick Stats -->
             <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                 <div class="bg-white/20 rounded-lg p-3 text-center">
                     <div class="text-2xl font-bold">{{ $totalPosts ?? 0 }}</div>
                     <div class="text-xs text-blue-100">Total Posts</div>
                 </div>
                 <div class="bg-white/20 rounded-lg p-3 text-center">
                     <div class="text-2xl font-bold">{{ $publishedPosts ?? 0 }}</div>
                     <div class="text-xs text-blue-100">Published</div>
                 </div>
                 <div class="bg-white/20 rounded-lg p-3 text-center">
                     <div class="text-2xl font-bold">{{ $draftPosts ?? 0 }}</div>
                     <div class="text-xs text-blue-100">Drafts</div>
                 </div>
                 <div class="bg-white/20 rounded-lg p-3 text-center">
                     <div class="text-2xl font-bold">{{ $totalCategories ?? 0 }}</div>
                     <div class="text-xs text-blue-100">Categories</div>
                 </div>
             </div>
         </div>
     </div>

     <!-- Filters Section -->
     <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-6">
         <form method="GET" action="{{ route('blog.index') }}"
             class="space-y-4 lg:space-y-0 lg:flex lg:items-center lg:space-x-4">
             <!-- Search -->
             <div class="flex-1">
                 <div class="relative">
                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                         <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                         </svg>
                     </div>
                     <input type="text" name="search" value="{{ request('search') }}"
                         class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200"
                         style="focus:ring-color: #00499b;" placeholder="Search by title or content...">
                 </div>
             </div>

             <!-- Status Filter -->
             <div class="lg:w-48">
                 <select name="status"
                     class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200">
                     <option value="">All Status</option>
                     <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Published</option>
                     <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Draft</option>
                 </select>
             </div>

             <!-- Category Filter -->
             <div class="lg:w-48">
                 <select name="category"
                     class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200">
                     <option value="">All Categories</option>
                     @foreach ($categories ?? [] as $category)
                         <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                             {{ $category->name }}
                         </option>
                     @endforeach
                 </select>
             </div>

             <!-- Action Buttons -->
             <div class="flex space-x-2">
                 <button type="submit"
                     class="flex items-center px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors hover:bg-opacity-90"
                     style="background-color: var(--primary);>
                    <svg class="w-4 h-4 mr-2" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                     </path>
                     </svg>
                     Filter
                 </button>
                 <a href="{{ route('blog.index') }}"
                     class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                     <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                         </path>
                     </svg>
                     Reset
                 </a>
             </div>
         </form>
     </div>

     <!-- Blog Posts Table -->
     <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
         <div class="px-6 py-4 border-b border-gray-200">
             <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                 <div>
                     <h3 class="text-lg font-semibold text-gray-800">Blog Posts</h3>
                     <p class="text-sm text-gray-500 mt-1">Manage your blog content and publications</p>
                 </div>
                 <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                     <!-- Bulk Actions -->
                     <div class="relative">
                         <div class="flex gap-2">
                             <button type="button" onclick="toggleBulkActions()"
                                 class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                                 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                         d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                     </path>
                                 </svg>
                                 Bulk Actions
                             </button>
                             {{-- create blog --}}

                             <a href="{{ route('blog.create') }}" style="background-color: var(--primary);"
                                 class="flex items-center px-3 py-2 text-sm font-medium   text-white border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">

                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                         d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                 </svg>
                                 Create
                             </a>

                         </div>

                         <div id="bulkActionsMenu"
                             class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                             <div class="py-1">
                                 <button onclick="bulkPublish()"
                                     class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                     <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                     </svg>
                                     Publish Selected
                                 </button>
                                 <button onclick="bulkDraft()"
                                     class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                     <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                         </path>
                                     </svg>
                                     Move to Draft
                                 </button>
                                 <hr class="my-1">
                                 <button onclick="bulkDelete()"
                                     class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                     <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                         </path>
                                     </svg>
                                     Delete Selected
                                 </button>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

         @if ($blogs->count() > 0)
             <div class="overflow-x-auto">
                 <table class="min-w-full divide-y divide-gray-200">
                     <thead class="bg-gray-50">
                         <tr>
                             <th scope="col" class="px-6 py-3 text-left">
                                 <input type="checkbox" id="selectAll"
                                     class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                             </th>
                             <th scope="col"
                                 class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                 Post Details
                             </th>
                             <th scope="col"
                                 class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                 Category & Author
                             </th>
                             <th scope="col"
                                 class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                 Status & Stats
                             </th>
                             <th scope="col"
                                 class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                 Published Date
                             </th>
                             <th scope="col"
                                 class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                 Actions
                             </th>
                         </tr>
                     </thead>
                     <tbody class="bg-white divide-y divide-gray-200">
                         @foreach ($blogs as $blog)
                             <tr class="hover:bg-gray-50 transition-colors">
                                 <td class="px-6 py-4 whitespace-nowrap">
                                     <input type="checkbox" name="selected_blogs[]" value="{{ $blog->id }}"
                                         class="blog-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                 </td>
                                 <td class="px-6 py-4">
                                     <div class="flex items-start space-x-4">
                                         <!-- Featured Image -->
                                         <div class="flex-shrink-0">
                                             @if ($blog->image)
                                                 <img class="h-16 w-24 rounded-lg object-cover border border-gray-200"
                                                     src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}"
                                                     loading="lazy">
                                             @else
                                                 <div
                                                     class="h-16 w-24 rounded-lg bg-gray-200 flex items-center justify-center border border-gray-200">
                                                     <svg class="w-6 h-6 text-gray-400" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round"
                                                             stroke-width="2"
                                                             d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                         </path>
                                                     </svg>
                                                 </div>
                                             @endif
                                         </div>
                                         <!-- Post Info -->
                                         <div class="flex-1 min-w-0">
                                             <div class="flex items-start justify-between">
                                                 <div class="flex-1">
                                                     <h4 class="text-sm font-semibold text-gray-900 truncate">
                                                         <a href="{{ route('blog.show', $blog->id) }}"
                                                             class="hover:text-blue-600 transition-colors">
                                                             {{ $blog->title }}
                                                         </a>
                                                     </h4>
                                                     <p class="text-xs text-gray-500 mt-1">
                                                         Slug: {{ $blog->slug }}
                                                     </p>
                                                     @if ($blog->excerpt)
                                                         <p class="text-xs text-gray-600 mt-2 line-clamp-2">
                                                             {{ Str::limit($blog->excerpt, 100) }}
                                                         </p>
                                                     @endif
                                                     @if ($blog->tags)
                                                         <div class="flex flex-wrap gap-1 mt-2">
                                                             @foreach (explode(',', $blog->tags) as $tag)
                                                                 <span
                                                                     class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                                     {{ trim($tag) }}
                                                                 </span>
                                                             @endforeach
                                                         </div>
                                                     @endif
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </td>
                                 <td class="px-6 py-4 whitespace-nowrap">
                                     <div class="space-y-2">
                                         <!-- Category -->
                                         <div class="flex items-center">
                                             <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                 </path>
                                             </svg>
                                             <span class="text-sm text-gray-900">
                                                 {{ $blog->category->name ?? 'Uncategorized' }}
                                             </span>
                                         </div>
                                         <!-- Author -->
                                         <div class="flex items-center">
                                             <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                 </path>
                                             </svg>

                                             <span class="text-sm text-gray-900">
                                                 @php
                                                     $authorName = 'Unknown';
                                                     $authorType = '';

                                                     if (
                                                         $blog->author_type === \App\Models\Club::class &&
                                                         $blog->author
                                                     ) {
                                                         $authorName = $blog->author->club_name ?? 'Unknown Club';
                                                         $authorType = '[Club]';
                                                     } elseif (
                                                         $blog->author_type === \App\Models\Member::class &&
                                                         $blog->author
                                                     ) {
                                                         $authorName = $blog->author->full_name ?? 'Unknown Member';
                                                         $authorType = '[Member]';
                                                     } elseif (
                                                         //  $blog->author_type === \App\Models\User::class &&
                                                         $blog->author_type ===
                                                             \Sndpbag\AdminPanel\Models\User::class &&
                                                         $blog->author
                                                     ) {
                                                         $authorName = $blog->author->name ?? 'Unknown Admin';
                                                         $authorType = '[Admin]';
                                                     }
                                                 @endphp

                                                 {{ $authorType }} {{ \Illuminate\Support\Str::limit($authorName, 10) }}
                                             </span>



                                         </div>
                                     </div>
                                 </td>

                                 <td class="px-6 py-4 whitespace-nowrap">
                                     <div class="space-y-2">
                                         <div>
                                             @php
                                                 // সমস্যাটি হলো: $blog->status এর ভ্যালু 'published' অথবা 'draft' (string)
                                                 // তাই, সরাসরি if($blog->status) লিখলে 'draft' হলেও true রিটার্ন করে।
                                                 // সমাধান: স্ট্রিং ভ্যালু 'published' এর সাথে সরাসরি তুলনা করা হচ্ছে।
                                                 $isPublished = $blog->status === 'published';
                                                 $statusText = $isPublished ? 'Published' : 'Draft';
                                                 $statusClass = $isPublished
                                                     ? 'bg-green-100 text-green-800 hover:bg-green-200'
                                                     : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200';
                                             @endphp

                                             <button onclick="toggleStatus({{ $blog->id }})"
                                                 class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors {{ $statusClass }}">
                                                 <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                     @if ($isPublished)
                                                         <path fill-rule="evenodd"
                                                             d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                             clip-rule="evenodd"></path>
                                                     @else
                                                         <path fill-rule="evenodd"
                                                             d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                             clip-rule="evenodd"></path>
                                                     @endif
                                                 </svg>
                                                 {{ $statusText }}
                                             </button>
                                         </div>
                                         <div class="flex items-center space-x-4 text-xs text-gray-500">
                                             <div class="flex items-center">
                                                 <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round"
                                                         stroke-width="2"
                                                         d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                     </path>
                                                 </svg>
                                                 {{ $blog->likes_count ?? 0 }} likes
                                             </div>
                                         </div>
                                     </div>
                                 </td>

                                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                     <div class="space-y-1">
                                         <div>
                                             {{ $blog->published_date ? $blog->published_date->format('M d, Y') : 'Not published' }}
                                         </div>
                                         <div class="text-xs text-gray-500">{{ $blog->created_at->format('H:i A') }}</div>
                                     </div>
                                 </td>
                                 <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                     <div class="flex items-center justify-end space-x-2">
                                         <!-- View -->
                                         <a href="{{ route('blog.show', $blog->id) }}"
                                             class="text-gray-600 hover:text-blue-600 transition-colors" title="View">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                 </path>
                                             </svg>
                                         </a>
                                         <!-- Edit -->
                                         {{-- <a href="{{ route('blog.edit', $blog->id) }}" 
                                           class="text-gray-600 hover:text-yellow-600 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a> --}}

                                         @if (auth()->check() && auth()->id() === $blog->author_id)
                                             <!-- Edit button enabled -->
                                             <a href="{{ route('blog.edit', $blog->id) }}"
                                                 class="text-gray-600 hover:text-yellow-600 transition-colors"
                                                 title="Edit">
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round"
                                                         stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2
                                 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                 </svg>
                                             </a>
                                         @else
                                             <!-- Disabled button -->
                                             <span class="text-gray-400 cursor-not-allowed"
                                                 title="You can't edit this blog">
                                                 <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round"
                                                         stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2
                                 0 002-2v-5m-1.414-9.414a2 2
                                 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                 </svg>
                                             </span>
                                         @endif

                                         <!-- Delete -->
                                         <button onclick="deleteBlog({{ $blog->id }})"
                                             class="text-gray-600 hover:text-red-600 transition-colors" title="Delete">
                                             <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                 </path>
                                             </svg>
                                         </button>
                                     </div>
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>

             <!-- Pagination -->
             @if ($blogs->hasPages())
                 <div class="px-6 py-4 border-t border-gray-200">
                     <div class="flex items-center justify-between">
                         <div class="flex items-center">
                             <p class="text-sm text-gray-700">
                                 Showing <span class="font-medium">{{ $blogs->firstItem() }}</span> to <span
                                     class="font-medium">{{ $blogs->lastItem() }}</span>
                                 of <span class="font-medium">{{ $blogs->total() }}</span> results
                             </p>
                         </div>
                         <div>
                             {{ $blogs->appends(request()->query())->links() }}
                         </div>
                     </div>
                 </div>
             @endif
         @else
             <!-- Empty State -->
             <div class="text-center py-12">
                 <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                     </path>
                 </svg>
                 <h3 class="mt-2 text-sm font-medium text-gray-900">No blog posts found</h3>
                 <p class="mt-1 text-sm text-gray-500">
                     @if (request()->hasAny(['search', 'status', 'category']))
                         No blog posts match your current filters. Try adjusting your search criteria.
                     @else
                         Get started by creating your first blog post.
                     @endif
                 </p>
                 <div class="mt-6">
                     @if (request()->hasAny(['search', 'status', 'category']))
                         <a href="{{ route('blog.index') }}"
                             class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white shadow-sm hover:bg-opacity-90 transition-colors"
                             style="background-color: #00499b;">
                             <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                 </path>
                             </svg>
                             Clear Filters
                         </a>
                     @else
                         <a href="{{ route('blog.create') }}"
                             class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white shadow-sm hover:bg-opacity-90 transition-colors"
                             style="background-color: #00499b;">
                             <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                             </svg>
                             Create your first blog post
                         </a>
                     @endif
                 </div>
             </div>
         @endif
     </div>

     <!-- Delete Confirmation Modal -->
     <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
         <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
             <div class="mt-3">
                 <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                     <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.75 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                         </path>
                     </svg>
                 </div>
                 <div class="mt-3 text-center">
                     <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Blog Post</h3>
                     <div class="mt-2 px-7 py-3">
                         <p class="text-sm text-gray-500">
                             Are you sure you want to delete this blog post? This action cannot be undone.
                         </p>
                     </div>
                     <div class="flex justify-center space-x-3 px-4 py-3">
                         <button onclick="closeDeleteModal()"
                             class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                             Cancel
                         </button>
                         <button onclick="confirmDelete()"
                             class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                             Delete
                         </button>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <!-- Bulk Delete Confirmation Modal -->
     <div id="bulkDeleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
         <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
             <div class="mt-3">
                 <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                     <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.75 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                         </path>
                     </svg>
                 </div>
                 <div class="mt-3 text-center">
                     <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Selected Posts</h3>
                     <div class="mt-2 px-7 py-3">
                         <p class="text-sm text-gray-500">
                             Are you sure you want to delete the selected blog posts? This action cannot be undone.
                         </p>
                     </div>
                     <div class="flex justify-center space-x-3 px-4 py-3">
                         <button onclick="closeBulkDeleteModal()"
                             class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                             Cancel
                         </button>
                         <button onclick="confirmBulkDelete()"
                             class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                             Delete Selected
                         </button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection

 @push('styles')
     <style>
         :root {
             --primary-blue: #00499b;
             --primary-yellow: #fbbf24;
             --light-blue: #1e5bb8;
             --dark-yellow: #f59e0b;
         }

         /* Custom focus styles */
         input:focus,
         select:focus,
         textarea:focus {
             outline: none;
             border-color: var(--primary-blue);
             box-shadow: 0 0 0 3px rgba(0, 73, 155, 0.1);
         }

         /* Enhanced table styles */
         .table-row-hover:hover {
             background-color: #f8fafc;
             transform: translateY(-1px);
             box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
             transition: all 0.2s ease;
         }

         /* Status badge animations */
         .status-badge {
             transition: all 0.2s ease;
         }

         .status-badge:hover {
             transform: scale(1.05);
         }

         /* Primary theme utilities */
         .text-primary {
             color: var(--primary-blue);
         }

         .bg-primary {
             background-color: var(--primary-blue);
         }

         .border-primary {
             border-color: var(--primary-blue);
         }

         /* Line clamp utility */
         .line-clamp-2 {
             overflow: hidden;
             display: -webkit-box;
             -webkit-box-orient: vertical;
             -webkit-line-clamp: 2;
         }

         /* Custom scrollbar */
         .overflow-x-auto::-webkit-scrollbar {
             height: 6px;
         }

         .overflow-x-auto::-webkit-scrollbar-track {
             background: #f1f1f1;
         }

         .overflow-x-auto::-webkit-scrollbar-thumb {
             background: var(--primary-blue);
             border-radius: 3px;
         }

         .overflow-x-auto::-webkit-scrollbar-thumb:hover {
             background: var(--light-blue);
         }

         /* Animation for cards */
         .animate-fade-in {
             animation: fadeIn 0.5s ease-in;
         }

         @keyframes fadeIn {
             from {
                 opacity: 0;
                 transform: translateY(20px);
             }

             to {
                 opacity: 1;
                 transform: translateY(0);
             }
         }

         /* Loading animation */
         .loading-spinner {
             border: 2px solid #f3f3f3;
             border-top: 2px solid var(--primary-blue);
             border-radius: 50%;
             width: 20px;
             height: 20px;
             animation: spin 1s linear infinite;
         }

         @keyframes spin {
             0% {
                 transform: rotate(0deg);
             }

             100% {
                 transform: rotate(360deg);
             }
         }

         /* Modal animations */
         .modal-enter {
             animation: modalEnter 0.3s ease-out;
         }

         @keyframes modalEnter {
             from {
                 opacity: 0;
                 transform: scale(0.9) translateY(-50px);
             }

             to {
                 opacity: 1;
                 transform: scale(1) translateY(0);
             }
         }

         /* Enhanced button styles */
         .btn-hover-lift:hover {
             transform: translateY(-2px);
             box-shadow: 0 4px 12px rgba(0, 73, 155, 0.3);
             transition: all 0.2s ease;
         }

         /* Stats cards responsive design */
         @media (max-width: 640px) {
             .stats-grid {
                 grid-template-columns: repeat(2, 1fr);
             }
         }

         @media (max-width: 480px) {
             .stats-grid {
                 grid-template-columns: 1fr;
             }
         }
     </style>
 @endpush

 @push('scripts')
     <script>
         let deleteId = null;
         let selectedBlogs = [];

         document.addEventListener('DOMContentLoaded', function() {
             console.log('Blog Index Page loaded');

             // Initialize bulk selection
             initializeBulkSelection();

             // Close modals when clicking outside
             document.addEventListener('click', function(e) {
                 if (e.target.classList.contains('fixed')) {
                     closeAllModals();
                 }
             });

             // Close bulk actions menu when clicking outside
             document.addEventListener('click', function(e) {
                 const bulkMenu = document.getElementById('bulkActionsMenu');
                 const bulkButton = e.target.closest('button[onclick="toggleBulkActions()"]');

                 if (!bulkButton && !bulkMenu.contains(e.target)) {
                     bulkMenu.classList.add('hidden');
                 }
             });
         });

         // Bulk Selection Functions
         function initializeBulkSelection() {
             const selectAllCheckbox = document.getElementById('selectAll');
             const blogCheckboxes = document.querySelectorAll('.blog-checkbox');

             // Select all functionality
             if (selectAllCheckbox) {
                 selectAllCheckbox.addEventListener('change', function() {
                     blogCheckboxes.forEach(checkbox => {
                         checkbox.checked = this.checked;
                     });
                     updateSelectedBlogs();
                 });
             }

             // Individual checkbox functionality
             blogCheckboxes.forEach(checkbox => {
                 checkbox.addEventListener('change', function() {
                     updateSelectAllState();
                     updateSelectedBlogs();
                 });
             });
         }

         function updateSelectAllState() {
             const selectAllCheckbox = document.getElementById('selectAll');
             const blogCheckboxes = document.querySelectorAll('.blog-checkbox');
             const checkedBoxes = document.querySelectorAll('.blog-checkbox:checked');

             if (selectAllCheckbox) {
                 if (checkedBoxes.length === 0) {
                     selectAllCheckbox.checked = false;
                     selectAllCheckbox.indeterminate = false;
                 } else if (checkedBoxes.length === blogCheckboxes.length) {
                     selectAllCheckbox.checked = true;
                     selectAllCheckbox.indeterminate = false;
                 } else {
                     selectAllCheckbox.checked = false;
                     selectAllCheckbox.indeterminate = true;
                 }
             }
         }

         function updateSelectedBlogs() {
             const checkedBoxes = document.querySelectorAll('.blog-checkbox:checked');
             selectedBlogs = Array.from(checkedBoxes).map(checkbox => checkbox.value);
             console.log('Selected blogs:', selectedBlogs);
         }

         // Bulk Actions
         function toggleBulkActions() {
             const menu = document.getElementById('bulkActionsMenu');
             menu.classList.toggle('hidden');
         }

         function bulkPublish() {
             if (selectedBlogs.length === 0) {
                 showNotification('Please select blogs to publish', 'warning');
                 return;
             }

             if (confirm(`Are you sure you want to publish ${selectedBlogs.length} selected blog(s)?`)) {
                 // Implementation would go here
                 console.log('Bulk publishing:', selectedBlogs);
                 showNotification(`${selectedBlogs.length} blog(s) published successfully`, 'success');
                 // You would make an AJAX call to your bulk publish endpoint here
             }
             document.getElementById('bulkActionsMenu').classList.add('hidden');
         }

         function bulkDraft() {
             if (selectedBlogs.length === 0) {
                 showNotification('Please select blogs to move to draft', 'warning');
                 return;
             }

             if (confirm(`Are you sure you want to move ${selectedBlogs.length} selected blog(s) to draft?`)) {
                 // Implementation would go here
                 console.log('Bulk draft:', selectedBlogs);
                 showNotification(`${selectedBlogs.length} blog(s) moved to draft successfully`, 'success');
                 // You would make an AJAX call to your bulk draft endpoint here
             }
             document.getElementById('bulkActionsMenu').classList.add('hidden');
         }

         function bulkDelete() {
             if (selectedBlogs.length === 0) {
                 showNotification('Please select blogs to delete', 'warning');
                 return;
             }

             document.getElementById('bulkDeleteModal').classList.remove('hidden');
             document.getElementById('bulkActionsMenu').classList.add('hidden');
         }

         function confirmBulkDelete() {
             if (selectedBlogs.length > 0) {
                 // Implementation would go here
                 console.log('Bulk deleting:', selectedBlogs);
                 showNotification(`${selectedBlogs.length} blog(s) deleted successfully`, 'success');
                 // You would make an AJAX call to your bulk delete endpoint here

                 // Reset selection
                 selectedBlogs = [];
                 document.querySelectorAll('.blog-checkbox').forEach(cb => cb.checked = false);
                 updateSelectAllState();
             }
             closeBulkDeleteModal();
         }

         function closeBulkDeleteModal() {
             document.getElementById('bulkDeleteModal').classList.add('hidden');
         }

         // Individual Blog Actions
         function toggleStatus(blogId) {
             if (confirm('Are you sure you want to change the status of this blog post?')) {
                 fetch(`/blog/${blogId}/toggle-status`, {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                 'content') || ''
                         }
                     })
                     .then(response => response.json())
                     .then(data => {
                         if (data.success) {
                             showNotification(data.message, 'success');
                             location.reload(); // Reload to update the UI
                         } else {
                             showNotification(data.message || 'Failed to update status', 'error');
                         }
                     })
                     .catch(error => {
                         console.error('Error:', error);
                         showNotification('An error occurred while updating the status', 'error');
                     });
             }
         }

         function deleteBlog(blogId) {
             deleteId = blogId;
             document.getElementById('deleteModal').classList.remove('hidden');
         }

         function confirmDelete() {
             if (deleteId) {
                 const form = document.createElement('form');
                 form.method = 'POST';
                 form.action = `/blog/${deleteId}`;

                 const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                 if (csrfToken) {
                     const csrfInput = document.createElement('input');
                     csrfInput.type = 'hidden';
                     csrfInput.name = '_token';
                     csrfInput.value = csrfToken;
                     form.appendChild(csrfInput);
                 }

                 const methodInput = document.createElement('input');
                 methodInput.type = 'hidden';
                 methodInput.name = '_method';
                 methodInput.value = 'DELETE';
                 form.appendChild(methodInput);

                 document.body.appendChild(form);
                 form.submit();
             }
             closeDeleteModal();
         }

         function closeDeleteModal() {
             document.getElementById('deleteModal').classList.add('hidden');
             deleteId = null;
         }

         function closeAllModals() {
             closeDeleteModal();
             closeBulkDeleteModal();
         }

         // Export functionality
         function exportBlogs() {
             showNotification('Export feature coming soon!', 'info');
             // Implementation would go here
         }

         // Notification system
         function showNotification(message, type = 'info') {
             const notification = document.createElement('div');
             notification.className = `fixed top-4 right-4 z-50 max-w-md animate-fade-in`;

             const bgColor = type === 'success' ? 'bg-green-500' :
                 type === 'error' ? 'bg-red-500' :
                 type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';

             const icon = type === 'success' ?
                 '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                 type === 'error' ?
                 '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>' :
                 type === 'warning' ?
                 '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.98-.833-2.75 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>' :
                 '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';

             notification.innerHTML = `
                <div class="${bgColor} text-white p-4 rounded-lg shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        ${icon}
                    </svg>
                    <span>${message}</span>
                    <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;

             document.body.appendChild(notification);

             // Auto-remove after 5 seconds
             setTimeout(() => {
                 if (notification.parentElement) {
                     notification.remove();
                 }
             }, 5000);
         }

         // Keyboard shortcuts
         document.addEventListener('keydown', function(e) {
             // Ctrl/Cmd + N for new blog
             if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                 e.preventDefault();
                 window.location.href = '{{ route('blog.create') }}';
             }

             // Escape to close modals
             if (e.key === 'Escape') {
                 closeAllModals();
                 document.getElementById('bulkActionsMenu').classList.add('hidden');
             }




         });


         function toggleStatus(blogId) {
             if (confirm('আপনি কি নিশ্চিত যে এই পোস্টটির স্ট্যাটাস পরিবর্তন করতে চান?')) {
                 // নতুন Route এর সাথে সামঞ্জস্য রেখে URL এবং Method পরিবর্তন করা হলো
                 fetch(`{{ route('blog.toggle-status', ['blog' => 'BLOG_ID_PLACEHOLDER']) }}`.replace('BLOG_ID_PLACEHOLDER',
                         blogId), {
                         method: 'POST', // আমরা PATCH রিকোয়েস্ট পাঠাবো, কিন্তু fetch-এর জন্য POST ব্যবহার করে _method: PATCH বডিতে পাঠাবো
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                 'content') || ''
                         },
                         body: JSON.stringify({
                             // এই লাইনটি Laravel-কে বলে দেবে যে এটি আসলে একটি PATCH রিকোয়েস্ট
                             _method: 'PATCH'
                         })
                     })
                     .then(response => response.json())
                     .then(data => {
                         if (data.success) {
                             showNotification(data.message, 'success');
                             // স্ট্যাটাস পরিবর্তন হওয়ার পরে পেইজ রিলোড করুন
                             location.reload();
                         } else {
                             showNotification(data.message || 'স্ট্যাটাস আপডেট ব্যর্থ হয়েছে', 'error');
                         }
                     })
                     .catch(error => {
                         console.error('Error:', error);
                         showNotification('স্ট্যাটাস আপডেট করার সময় একটি ত্রুটি হয়েছে', 'error');
                     });
             }
         }

         console.log('Blog Index initialization complete');
     </script>
     @push('scripts')
