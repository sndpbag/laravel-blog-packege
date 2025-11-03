@extends('admin-panel::dashboard.layouts.app')

@section('title', 'Add New Blog Post - Dashboard')
@section('page-title', 'Blog Management')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <span class="text-gray-400 mx-2">/</span>
    <a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-primary transition-colors">Blog Posts</a>
    <span class="text-gray-400 mx-2">/</span>
    <span class="text-primary font-medium">Create New Post</span>
@endsection

@section('header-actions')
    <div class="flex items-center space-x-3">
        <a href="{{ route('blog.index') }}"
            class="hidden md:flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            Back to Blog List
        </a>
    </div>
@endsection

@section('content')
    <!-- Header Banner -->
    <div class="mb-8 bg-gradient-to-r rounded-xl p-6 text-white shadow-lg"
        style="background: linear-gradient(135deg, #00499b, #1e5bb8);">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-1">📝 Create Blog Post</h2>
                    <p class="text-blue-100 text-lg">Professional content creation interface for blog management</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <form id="blogForm" action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Hidden Fields -->
        <input type="hidden" name="views" value="0">
        <input type="hidden" name="word_count" id="word_count_hidden">
        <input type="hidden" name="reading_time" id="reading_time_hidden">
        <input type="hidden" name="author_type"
            value="{{ addslashes(config('admin-panel.user_model', \Sndpbag\AdminPanel\Models\User::class)) }}">
        <input type="hidden" name="author_id" value="{{ auth()->id() }}">

        <!-- Featured Image Section -->
        <div
            class="form-section bg-white rounded-xl p-6 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-lg">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4"
                    style="background-color: rgba(0, 73, 155, 0.1);">
                    <svg class="w-5 h-5" style="color: #00499b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Featured Image</h3>
            </div>

            <div class="text-center">
                <div class="relative inline-block mb-4">
                    <img id="imagePreview"
                        src="data:image/svg+xml,%3Csvg width='300' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='100%25' height='100%25' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' font-family='Arial' font-size='16' fill='%236b7280' text-anchor='middle' dy='.3em'%3EFeatured Image%3C/text%3E%3C/svg%3E"
                        alt="Featured Image Preview"
                        class="w-80 h-48 rounded-lg mx-auto border-4 border-blue-400 shadow-lg object-cover">
                    <label for="imageInput"
                        class="absolute bottom-2 right-2 text-white rounded-full p-3 cursor-pointer shadow-lg transition-all hover:shadow-xl"
                        style="background: linear-gradient(135deg, #00499b, #1e5bb8);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </label>
                    <input type="file" id="imageInput" name="image" accept="image/*" class="hidden" required>
                </div>

                <!-- Drag & Drop Zone -->
                <div id="dropzone"
                    class="dropzone mt-4 p-6 text-center bg-gradient-to-br from-blue-50 to-indigo-50 cursor-pointer border-2 border-dashed border-blue-400 rounded-lg transition-all hover:border-blue-600 hover:bg-blue-50">
                    <svg class="w-12 h-12 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                    <p class="text-sm text-gray-600 font-medium">Drag & drop your featured image here or click to browse</p>
                    <p class="text-xs text-blue-600 mt-2 font-medium">PNG, JPG, GIF up to 5MB</p>
                </div>
                @error('image')
                    <p class="text-red-500 text-sm mt-2 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Main Content & Sidebar Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Content (2/3 width) -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Basic Information Section -->
                <div
                    class="form-section bg-white rounded-xl p-6 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4"
                            style="background-color: rgba(0, 73, 155, 0.1);">
                            <svg class="w-5 h-5" style="color: #00499b;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Blog Information</h3>
                    </div>

                    <div class="space-y-6">
                        <!-- Title -->
                        <div class="space-y-2">
                            <label for="title" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #00499b;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                Blog Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                style="focus:ring-color: #00499b;" placeholder="Enter an engaging blog title">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="space-y-2">
                            <label for="slug" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #00499b;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                    </path>
                                </svg>
                                URL Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                style="focus:ring-color: #00499b;" placeholder="blog-url-slug">
                            <p class="text-xs text-gray-500 mt-1">URL-friendly version of the title (auto-generated from
                                title)</p>
                            @error('slug')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div class="space-y-2">
                            <label for="excerpt" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #00499b;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                Excerpt
                            </label>
                            <textarea id="excerpt" name="excerpt" rows="3" maxlength="500"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 hover:border-gray-400 resize-none"
                                style="focus:ring-color: #00499b;" placeholder="Brief description of the blog post...">{{ old('excerpt') }}</textarea>
                            <div class="flex justify-between text-xs mt-1">
                                <p class="text-gray-500">Short summary that appears in blog listings</p>
                                <div id="excerptCounter" class="text-gray-400">0/500 characters</div>
                            </div>
                            @error('excerpt')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Tags -->
                        <div class="space-y-2">
                            <label for="tagsInput" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #00499b;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                Tags
                            </label>
                            <div class="tag-input">
                                <input type="text" id="tagsInput"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 hover:border-gray-400"
                                    style="focus:ring-color: #00499b;" placeholder="Type a tag and press Enter or comma">
                                <input type="hidden" id="tags" name="tags" value="{{ old('tags') }}">
                                <div id="tagContainer" class="tag-container flex flex-wrap gap-2 mt-2"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Add relevant tags separated by commas or Enter key</p>
                            @error('tags')
                                <p class="text-red-500 text-sm mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- CKEditor 5 Content Section -->
                <div
                    class="form-section bg-white rounded-xl p-6 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4"
                            style="background-color: rgba(251, 191, 36, 0.1);">
                            <svg class="w-5 h-5" style="color: #fbbf24;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Blog Content</h3>
                    </div>

                    <div class="space-y-2">
                        <label for="editor" class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2" style="color: #fbbf24;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Content <span class="text-red-500">*</span>
                        </label>

                        <!-- CKEditor 5 Container -->
                        <div id="editor" style="min-height: 400px;">{!! old('content') !!}</div>
                        <textarea id="content" name="content" class="hidden" required>{{ old('content') }}</textarea>

                        <!-- Editor Helper Text -->
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between text-xs text-gray-500 mt-2 space-y-1 sm:space-y-0">
                            <div class="flex items-center space-x-4">
                                <span>📝 Rich text formatting enabled</span>
                                <span>🖼️ Images supported</span>
                                <span>🎬 Video embeds supported</span>
                                <span>📊 Tables supported</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span>Word count: <span id="wordCount">0</span></span>
                                <span>|</span>
                                <span>Characters: <span id="charCount">0</span></span>
                            </div>
                        </div>

                        @error('content')
                            <p class="text-red-500 text-sm mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar (1/3 width) -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Publish Settings -->
                <div
                    class="form-section bg-white rounded-xl p-6 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4"
                            style="background-color: rgba(34, 197, 94, 0.1);">
                            <svg class="w-5 h-5" style="color: #22c55e;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Publish Settings</h3>
                    </div>

                    <div class="space-y-4">
                        <!-- Category -->
                        <div class="space-y-2">
                            <label for="category_id" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #22c55e;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                                Category
                            </label>
                            <select id="category_id" name="category_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200">
                                <option value="">Select Category</option>
                                @foreach ($categories ?? [] as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Author Selection -->
                        <div class="space-y-2">
                            <label for="author_id" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #22c55e;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Author (Admin/Editor)
                            </label>
                            <select id="author_id" name="author_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200"
                                onchange="setAuthorType()">
                                <option value="{{ auth()->id() }}" selected>Current User
                                    ({{ auth()->user()->name ?? 'N/A' }})</option>
                            </select>
                            <p class="text-xs text-gray-500">Defaults to the current logged-in user.</p>
                            @error('author_id')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Member Selection -->
                        <div class="space-y-2">
                            <label for="member_id" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #22c55e;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                Member (Optional)
                            </label>
                            <select id="member_id" name="member_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200"
                                onchange="setAuthorType(this.value)">
                                <option value="">None - (Post by Logged-in User)</option>
                                @foreach ($members ?? [] as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500">Select a member if this post is by them.</p>
                        </div>

                        <!-- Published Date -->
                        <div class="space-y-2">
                            <label for="published_date" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #22c55e;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Published Date
                            </label>
                            <input type="date" id="published_date" name="published_date"
                                value="{{ old('published_date', date('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200">
                            @error('published_date')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Is Featured Toggle -->
                        <div class="space-y-2">
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="checkbox" name="is_featured" value="1"
                                    {{ old('is_featured') ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1" style="color: #fbbf24;" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                        </path>
                                    </svg>
                                    Mark as Featured Post
                                </span>
                            </label>
                            <p class="text-xs text-gray-500 ml-7">Featured posts appear prominently on homepage</p>
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div
                    class="form-section bg-white rounded-xl p-6 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4"
                            style="background-color: rgba(168, 85, 247, 0.1);">
                            <svg class="w-5 h-5" style="color: #a855f7;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">SEO Settings</h3>
                    </div>

                    <div class="space-y-4">
                        <!-- Meta Title -->
                        <div class="space-y-2">
                            <label for="meta_title" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #a855f7;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                    </path>
                                </svg>
                                Meta Title
                            </label>
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                                maxlength="60"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200"
                                placeholder="SEO optimized title">
                            <div class="flex justify-between text-xs mt-1">
                                <p class="text-gray-500">Leave empty to use blog title</p>
                                <div id="metaTitleCounter" class="text-gray-400">0/60 chars</div>
                            </div>
                            @error('meta_title')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="space-y-2">
                            <label for="meta_description" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #a855f7;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                Meta Description
                            </label>
                            <textarea id="meta_description" name="meta_description" rows="3" maxlength="160"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 resize-none"
                                placeholder="Brief description for search engines...">{{ old('meta_description') }}</textarea>
                            <div class="flex justify-between text-xs mt-1">
                                <p class="text-gray-500">Leave empty to use excerpt</p>
                                <div id="metaDescCounter" class="text-gray-400">0/160 chars</div>
                            </div>
                            @error('meta_description')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Blog Statistics -->
                <div
                    class="form-section bg-white rounded-xl p-6 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4"
                            style="background-color: rgba(239, 68, 68, 0.1);">
                            <svg class="w-5 h-5" style="color: #ef4444;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Blog Statistics</h3>
                    </div>

                    <div class="space-y-4">
                        <!-- Initial Likes -->
                        <div class="space-y-2">
                            <label for="likes" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #ef4444;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                                Initial Likes
                            </label>
                            <input type="number" id="likes" name="likes" value="{{ old('likes', 0) }}"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200">
                            <p class="text-xs text-gray-500">Set initial like count (usually 0)</p>
                            @error('likes')
                                <p class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO Preview -->
                <div
                    class="form-section bg-white rounded-xl p-6 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-lg">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4"
                            style="background-color: rgba(59, 130, 246, 0.1);">
                            <svg class="w-5 h-5" style="color: #3b82f6;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Search Preview</h3>
                    </div>

                    <div class="space-y-2 p-4 bg-gray-50 rounded-lg border">
                        <div id="seo-title" class="text-blue-600 font-medium text-sm truncate">Your Blog Title</div>
                        <div id="seo-url" class="text-green-600 text-xs">yoursite.com/blog/your-slug</div>
                        <div id="seo-excerpt" class="text-gray-600 text-xs leading-relaxed">Your excerpt will appear
                            here...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between p-6 bg-gray-50 rounded-xl border border-gray-200">
            <div class="flex items-center space-x-4">
                <button type="button" onclick="resetForm()"
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Reset Form
                </button>
                <p class="text-sm text-gray-500">
                    Fields marked with <span class="text-red-500">*</span> are required
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('blog.index') }}"
                    class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" name="action" value="draft"
                    class="flex items-center px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                        </path>
                    </svg>
                    Save as Draft
                </button>
                <button type="submit" name="action" value="publish"
                    class="flex items-center px-6 py-3 text-sm font-medium text-white rounded-lg transition-colors hover:bg-opacity-90 shadow-md hover:shadow-lg"
                    style="background: linear-gradient(135deg, #00499b, #1e5bb8);">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Publish Blog
                </button>
            </div>
        </div>
    </form>
@endsection

@push('styles')
    <style>
        :root {
            --primary-blue: #00499b;
            --primary-yellow: #fbbf24;
            --light-blue: #1e5bb8;
            --dark-yellow: #f59e0b;
        }

        .form-section {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 73, 155, 0.1), 0 4px 6px -2px rgba(0, 73, 155, 0.05);
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 73, 155, 0.1);
        }

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
        }

        .tag-item {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tag-remove {
            cursor: pointer;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .tag-remove:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .dropzone {
            border: 2px dashed #60a5fa;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .dropzone:hover {
            border-color: var(--primary-blue);
            background: linear-gradient(135deg, rgba(0, 73, 155, 0.05), rgba(30, 91, 184, 0.05));
        }

        .form-section {
            animation: fadeInUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .form-section:nth-child(1) {
            animation-delay: 0.1s;
        }

        .form-section:nth-child(2) {
            animation-delay: 0.2s;
        }

        .form-section:nth-child(3) {
            animation-delay: 0.3s;
        }

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

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* CKEditor Custom Styles */
        .ck-editor__editable {
            min-height: 400px;
            max-height: 600px;
        }

        .ck.ck-editor__main>.ck-editor__editable {
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 0 0 0.5rem 0.5rem;
        }

        .ck.ck-editor__main>.ck-editor__editable:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 73, 155, 0.1);
        }

        .ck.ck-toolbar {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem 0.5rem 0 0;
            background: #f9fafb;
        }

        @media (max-width: 768px) {
            .grid-cols-1.lg\:grid-cols-3 {
                grid-template-columns: 1fr;
            }

            .dropzone {
                padding: 1rem;
            }

            #imagePreview {
                width: 100%;
                max-width: 300px;
                height: auto;
            }
        }
    </style>
@endpush

@push('scripts')
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        // Security & Utilities
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        function sanitizeHtml(html) {
            const temp = document.createElement('div');
            temp.textContent = html;
            return temp.innerHTML;
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 z-50 max-w-md animate-slide-in';

            const bgColor = {
                'success': 'bg-green-500',
                'error': 'bg-red-500',
                'warning': 'bg-yellow-500',
                'info': 'bg-blue-500'
            } [type] || 'bg-blue-500';

            const icons = {
                'success': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
                'error': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
                'warning': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
                'info': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            };

            notification.innerHTML = `
        <div class="${bgColor} text-white p-4 rounded-lg shadow-lg flex items-center">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${icons[type]}
            </svg>
            <span class="flex-1">${sanitizeHtml(message)}</span>
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

        // Custom Upload Adapter for CKEditor 5
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file
                    .then(file => new Promise((resolve, reject) => {
                        this._initRequest();
                        this._initListeners(resolve, reject, file);
                        this._sendRequest(file);
                    }));
            }

            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }

            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('blog.upload-content-image') }}', true);
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                xhr.responseType = 'json';
            }

            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `Couldn't upload file: ${file.name}.`;

                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());

                xhr.addEventListener('load', () => {
                    const response = xhr.response;

                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }

                    resolve({
                        default: response.url
                    });
                });

                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }

            _sendRequest(file) {
                const data = new FormData();
                data.append('upload', file);
                this.xhr.send(data);
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        window.setAuthorType = function(memberId = null) {
            const authorIdHidden = document.querySelector('input[name="author_id"]');
            const authorTypeHidden = document.querySelector('input[name="author_type"]');

            const modelClass =
                '{{ addslashes(config('admin-panel.user_model', \Sndpbag\AdminPanel\Models\User::class)) }}';

            if (authorIdHidden && authorTypeHidden) {
                if (memberId) {
                    authorIdHidden.value = memberId;
                    authorTypeHidden.value = modelClass;
                } else {
                    authorIdHidden.value = '{{ auth()->id() }}';
                    authorTypeHidden.value = modelClass;
                }
            }
        };

        window.resetForm = function() {
            if (confirm('Are you sure you want to reset the form? All unsaved data will be lost.')) {
                const form = document.getElementById('blogForm');
                if (form) form.reset();

                if (window.editorInstance) {
                    window.editorInstance.setData('');
                }

                const tagContainer = document.getElementById('tagContainer');
                if (tagContainer) tagContainer.innerHTML = '';

                const tagsHidden = document.getElementById('tags');
                if (tagsHidden) tagsHidden.value = '';

                const imagePreview = document.getElementById('imagePreview');
                if (imagePreview) {
                    imagePreview.src =
                        "data:image/svg+xml,%3Csvg width='300' height='200' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='100%25' height='100%25' fill='%23f3f4f6'/%3E%3Ctext x='50%25' y='50%25' font-family='Arial' font-size='16' fill='%236b7280' text-anchor='middle' dy='.3em'%3EFeatured Image%3C/text%3E%3C/svg%3E";
                }

                if (typeof updateCounters === 'function') updateCounters();
                if (typeof updateSEOPreview === 'function') updateSEOPreview();

                showNotification('Form reset', 'info');

                const titleInput = document.getElementById('title');
                if (titleInput) titleInput.focus();
            }
        };

        // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize CKEditor 5 with Custom Upload Adapter
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'strikethrough', '|',
                            'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                            'alignment:left', 'alignment:center', 'alignment:right', 'alignment:justify',
                            '|',
                            'link', 'uploadImage', 'insertTable', 'mediaEmbed', 'blockQuote', 'codeBlock',
                            '|',
                            'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|',
                            'horizontalLine', 'removeFormat', '|',
                            'undo', 'redo'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    alignment: {
                        options: ['left', 'center', 'right', 'justify']
                    },
                    image: {
                        toolbar: [
                            'imageStyle:inline',
                            'imageStyle:block',
                            'imageStyle:side',
                            '|',
                            'toggleImageCaption',
                            'imageTextAlternative',
                            '|',
                            'linkImage'
                        ],
                        upload: {
                            types: ['jpeg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'jpg']
                        }
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties',
                            'tableCellProperties'
                        ]
                    },
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            },
                            {
                                model: 'heading4',
                                view: 'h4',
                                title: 'Heading 4',
                                class: 'ck-heading_heading4'
                            }
                        ]
                    },
                    fontSize: {
                        options: [9, 11, 13, 'default', 17, 19, 21, 24, 28, 32]
                    },
                    fontColor: {
                        colors: [{
                                color: 'hsl(0, 0%, 0%)',
                                label: 'Black'
                            },
                            {
                                color: 'hsl(0, 0%, 30%)',
                                label: 'Dim grey'
                            },
                            {
                                color: 'hsl(0, 0%, 60%)',
                                label: 'Grey'
                            },
                            {
                                color: 'hsl(0, 0%, 90%)',
                                label: 'Light grey'
                            },
                            {
                                color: 'hsl(0, 0%, 100%)',
                                label: 'White',
                                hasBorder: true
                            },
                            {
                                color: 'hsl(0, 75%, 60%)',
                                label: 'Red'
                            },
                            {
                                color: 'hsl(30, 75%, 60%)',
                                label: 'Orange'
                            },
                            {
                                color: 'hsl(60, 75%, 60%)',
                                label: 'Yellow'
                            },
                            {
                                color: 'hsl(90, 75%, 60%)',
                                label: 'Light green'
                            },
                            {
                                color: 'hsl(120, 75%, 60%)',
                                label: 'Green'
                            },
                            {
                                color: 'hsl(150, 75%, 60%)',
                                label: 'Aquamarine'
                            },
                            {
                                color: 'hsl(180, 75%, 60%)',
                                label: 'Turquoise'
                            },
                            {
                                color: 'hsl(210, 75%, 60%)',
                                label: 'Light blue'
                            },
                            {
                                color: 'hsl(240, 75%, 60%)',
                                label: 'Blue'
                            },
                            {
                                color: 'hsl(270, 75%, 60%)',
                                label: 'Purple'
                            }
                        ]
                    },
                    fontBackgroundColor: {
                        colors: [{
                                color: 'hsl(0, 75%, 60%)',
                                label: 'Red'
                            },
                            {
                                color: 'hsl(30, 75%, 60%)',
                                label: 'Orange'
                            },
                            {
                                color: 'hsl(60, 75%, 60%)',
                                label: 'Yellow'
                            },
                            {
                                color: 'hsl(90, 75%, 60%)',
                                label: 'Light green'
                            },
                            {
                                color: 'hsl(120, 75%, 60%)',
                                label: 'Green'
                            },
                            {
                                color: 'hsl(180, 75%, 60%)',
                                label: 'Turquoise'
                            },
                            {
                                color: 'hsl(240, 75%, 60%)',
                                label: 'Blue'
                            },
                            {
                                color: 'hsl(270, 75%, 60%)',
                                label: 'Purple'
                            }
                        ]
                    },
                    mediaEmbed: {
                        previewsInData: true
                    },
                    link: {
                        decorators: {
                            openInNewTab: {
                                mode: 'manual',
                                label: 'Open in a new tab',
                                attributes: {
                                    target: '_blank',
                                    rel: 'noopener noreferrer'
                                }
                            }
                        }
                    }
                })
                .then(editor => {
                    window.editorInstance = editor;

                    console.log('✅ CKEditor 5 initialized successfully!');

                    // Update hidden textarea on change
                    editor.model.document.on('change:data', () => {
                        const contentInput = document.getElementById('content');
                        if (contentInput) {
                            contentInput.value = editor.getData();
                        }
                        updateWordCount();
                    });

                    // Load old content if exists
                    const oldContent = document.getElementById('content').value;
                    if (oldContent) {
                        editor.setData(oldContent);
                    }

                    showNotification('Editor ready! You can now upload images.', 'success');
                })
                .catch(error => {
                    console.error('CKEditor initialization error:', error);
                    showNotification('Failed to initialize editor: ' + error.message, 'error');
                });

            // Word count update function
            function updateWordCount() {
                if (!window.editorInstance) return;

                const data = window.editorInstance.getData();
                const text = data.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
                const words = text.split(/\s+/).filter(w => w.length > 0);
                const wordCount = words.length;
                const charCount = text.length;
                const readingTime = Math.ceil(wordCount / 200) || 1;

                const wordCountEl = document.getElementById('wordCount');
                const charCountEl = document.getElementById('charCount');
                const wordCountHidden = document.getElementById('word_count_hidden');
                const readingTimeHidden = document.getElementById('reading_time_hidden');

                if (wordCountEl) wordCountEl.textContent = wordCount;
                if (charCountEl) charCountEl.textContent = charCount;
                if (wordCountHidden) wordCountHidden.value = wordCount;
                if (readingTimeHidden) readingTimeHidden.value = readingTime;
            }

            // Get elements
            const form = document.getElementById('blogForm');
            const dropzone = document.getElementById('dropzone');
            const fileInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            const excerptInput = document.getElementById('excerpt');
            const excerptCounter = document.getElementById('excerptCounter');
            const metaTitleInput = document.getElementById('meta_title');
            const metaTitleCounter = document.getElementById('metaTitleCounter');
            const metaDescInput = document.getElementById('meta_description');
            const metaDescCounter = document.getElementById('metaDescCounter');
            const tagsInput = document.getElementById('tagsInput');
            const tagsHidden = document.getElementById('tags');
            const tagContainer = document.getElementById('tagContainer');
            const seoTitle = document.getElementById('seo-title');
            const seoUrl = document.getElementById('seo-url');
            const seoExcerpt = document.getElementById('seo-excerpt');

            // Featured Image Handler
            function handleImageSelect(file) {
                if (!file) return;

                if (!file.type.startsWith('image/')) {
                    showNotification('Please select an image file', 'error');
                    if (fileInput) fileInput.value = '';
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    showNotification('Image must be less than 5MB', 'error');
                    if (fileInput) fileInput.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    if (imagePreview) {
                        imagePreview.src = e.target.result;
                        showNotification('Featured image selected!', 'success');
                    }
                };
                reader.onerror = () => showNotification('Failed to read file', 'error');
                reader.readAsDataURL(file);
            }

            if (dropzone && fileInput) {
                dropzone.addEventListener('click', () => fileInput.click());

                dropzone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '#00499b';
                    this.style.background = 'rgba(0, 73, 155, 0.1)';
                });

                dropzone.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '#60a5fa';
                    this.style.background = '';
                });

                dropzone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '#60a5fa';
                    this.style.background = '';

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        handleImageSelect(files[0]);
                        const dt = new DataTransfer();
                        dt.items.add(files[0]);
                        fileInput.files = dt.files;
                    }
                });

                fileInput.addEventListener('change', function(e) {
                    if (e.target.files.length > 0) {
                        handleImageSelect(e.target.files[0]);
                    }
                });
            }

            // Tags Handler
            let tags = [];

            if (tagsHidden && tagsHidden.value) {
                tags = tagsHidden.value.split(',').map(t => t.trim()).filter(t => t);
                updateTagDisplay();
            }

            function addTag(text) {
                const trimmed = text.trim();
                const cleaned = trimmed.replace(/[^a-zA-Z0-9\s-]/g, '');

                if (cleaned && !tags.includes(cleaned)) {
                    if (tags.length >= 10) {
                        showNotification('Maximum 10 tags allowed', 'warning');
                        return;
                    }
                    tags.push(cleaned);
                    updateTagDisplay();
                    if (tagsHidden) tagsHidden.value = tags.join(',');
                }
            }

            function removeTag(text) {
                tags = tags.filter(t => t !== text);
                updateTagDisplay();
                if (tagsHidden) tagsHidden.value = tags.join(',');
            }

            function updateTagDisplay() {
                if (!tagContainer) return;
                tagContainer.innerHTML = '';
                tags.forEach(tag => {
                    const el = document.createElement('div');
                    el.className = 'tag-item';
                    el.innerHTML =
                        `<span>${sanitizeHtml(tag)}</span><span class="tag-remove">&times;</span>`;
                    tagContainer.appendChild(el);

                    el.querySelector('.tag-remove').addEventListener('click', () => removeTag(tag));
                });
            }

            window.removeTag = removeTag;

            if (tagsInput) {
                tagsInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        if (this.value.trim()) {
                            addTag(this.value);
                            this.value = '';
                        }
                    }
                });

                tagsInput.addEventListener('blur', function() {
                    if (this.value.trim()) {
                        addTag(this.value);
                        this.value = '';
                    }
                });
            }

            // Slug Auto-Generate
            if (titleInput && slugInput) {
                titleInput.addEventListener('input', function() {
                    const slug = this.value.toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim();
                    slugInput.value = slug;
                    updateSEOPreview();
                });
            }

            // Counters
            function updateCounters() {
                if (excerptInput && excerptCounter) {
                    const len = excerptInput.value.length;
                    excerptCounter.textContent = `${len}/500 characters`;
                    excerptCounter.className = len > 500 ? 'text-red-500' : 'text-gray-400';
                }

                if (metaTitleInput && metaTitleCounter) {
                    const len = metaTitleInput.value.length;
                    metaTitleCounter.textContent = `${len}/60 chars`;
                    metaTitleCounter.className = len > 60 ? 'text-red-500' : 'text-gray-400';
                }

                if (metaDescInput && metaDescCounter) {
                    const len = metaDescInput.value.length;
                    metaDescCounter.textContent = `${len}/160 chars`;
                    metaDescCounter.className = len > 160 ? 'text-red-500' : 'text-gray-400';
                }
            }

            window.updateCounters = updateCounters;

            // SEO Preview
            function updateSEOPreview() {
                const currentDomain = window.location.hostname;

                if (seoTitle && titleInput && metaTitleInput) {
                    seoTitle.textContent = metaTitleInput.value || titleInput.value || 'Your Blog Title';
                }
                if (seoUrl && slugInput) {
                    seoUrl.textContent = `${currentDomain}/blog/${slugInput.value || 'your-slug'}`;
                }
                if (seoExcerpt && excerptInput && metaDescInput) {
                    seoExcerpt.textContent = metaDescInput.value || excerptInput.value || 'Your excerpt...';
                }
            }

            window.updateSEOPreview = updateSEOPreview;

            [excerptInput, metaTitleInput, metaDescInput].forEach(input => {
                if (input) input.addEventListener('input', () => {
                    updateCounters();
                    updateSEOPreview();
                });
            });

            if (slugInput) slugInput.addEventListener('input', updateSEOPreview);

            updateCounters();
            updateSEOPreview();

            // Form Submission
            let isSubmitting = false;

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (isSubmitting) {
                        e.preventDefault();
                        return;
                    }

                    // Sync CKEditor content
                    if (window.editorInstance) {
                        const contentInput = document.getElementById('content');
                        if (contentInput) {
                            contentInput.value = window.editorInstance.getData();
                        }
                    }

                    if (titleInput && !titleInput.value.trim()) {
                        e.preventDefault();
                        showNotification('Enter blog title', 'error');
                        titleInput.focus();
                        return;
                    }

                    if (slugInput && !slugInput.value.trim()) {
                        e.preventDefault();
                        showNotification('Enter URL slug', 'error');
                        slugInput.focus();
                        return;
                    }

                    if (fileInput && !fileInput.files.length) {
                        e.preventDefault();
                        showNotification('Select featured image', 'error');
                        return;
                    }

                    const contentInput = document.getElementById('content');
                    if (contentInput && !contentInput.value.trim()) {
                        e.preventDefault();
                        showNotification('Enter blog content', 'error');
                        if (window.editorInstance) {
                            window.editorInstance.focus();
                        }
                        return;
                    }

                    isSubmitting = true;

                    form.querySelectorAll('button[type="submit"]').forEach(btn => {
                        btn.disabled = true;
                        btn.innerHTML = `
                    <svg class="w-4 h-4 mr-2 animate-spin inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                `;
                    });
                });
            }

            // Keyboard Shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    if (form && !isSubmitting) {
                        const draftButton = form.querySelector('button[name="action"][value="draft"]');
                        if (draftButton) draftButton.click();
                    }
                }
            });

            // Initial focus
            if (titleInput) titleInput.focus();

            console.log('✅ Blog Form with CKEditor 5 Ready!');
        });
    </script>
@endpush


