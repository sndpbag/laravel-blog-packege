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
        {{-- For polymorphic relation, you might want to dynamically set this based on selected author --}}
        {{-- <input type="hidden" name="author_type" value="App\Models\User"> Default to User model for members/admins --}}
        <input type="hidden" name="author_type" value="Sndpbag\AdminPanel\Models\User"> {{-- Default to User model for members/admins --}}
        <input type="hidden" name="author_id" value="{{ auth()->id() }}"> {{-- Default to current authenticated user --}}


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
                    class="dropzone mt-4 p-6 text-center bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 cursor-pointer border-2 border-dashed border-blue-400 rounded-lg transition-all hover:border-blue-600 hover:bg-blue-50">
                    <svg class="w-12 h-12 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                    <p class="text-sm text-gray-600 font-medium">Drag & drop your featured image here or click to browse
                    </p>
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

                <!-- Content Editor Section -->
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
                        <label for="content" class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-2" style="color: #fbbf24;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Content <span class="text-red-500">*</span>
                        </label>

                        <!-- Advanced Rich Text Editor Toolbar -->
                        <div class="bg-gray-100 border border-gray-300 rounded-t-lg p-3">
                            <!-- Row 1: Text Formatting -->
                            <div class="flex flex-wrap gap-1 mb-2">
                                <button type="button" onclick="formatText('bold')" class="toolbar-btn" title="Bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('italic')" class="toolbar-btn"
                                    title="Italic">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 4L6 20m8-16l-4 16"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('underline')" class="toolbar-btn"
                                    title="Underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('strikeThrough')" class="toolbar-btn"
                                    title="Strikethrough">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 8h12M6 16h12M8 12h8"></path>
                                    </svg>
                                </button>

                                <div class="border-l border-gray-400 mx-1"></div>

                                <!-- Font Size -->
                                <select onchange="changeFontSize(this.value)"
                                    class="text-xs px-2 py-1 border rounded bg-white">
                                    <option value="">Size</option>
                                    <option value="1">Small</option>
                                    <option value="3">Normal</option>
                                    <option value="4">Medium</option>
                                    <option value="5">Large</option>
                                    <option value="6">X-Large</option>
                                    <option value="7">XX-Large</option>
                                </select>

                                <!-- Text Colors -->
                                <div class="relative">
                                    <button type="button" onclick="toggleColorPicker()" class="toolbar-btn"
                                        title="Text Color">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2a2 2 0 002-2V5a2 2 0 00-2-2z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div id="colorPicker"
                                        class="hidden absolute top-8 left-0 bg-white border rounded-lg p-2 z-10 shadow-lg">
                                        <div class="grid grid-cols-6 gap-1">
                                            <button type="button" onclick="setTextColor('#000000')"
                                                class="w-6 h-6 rounded border" style="background-color: #000000"
                                                title="Black"></button>
                                            <button type="button" onclick="setTextColor('#FF0000')"
                                                class="w-6 h-6 rounded border" style="background-color: #FF0000"
                                                title="Red"></button>
                                            <button type="button" onclick="setTextColor('#00FF00')"
                                                class="w-6 h-6 rounded border" style="background-color: #00FF00"
                                                title="Green"></button>
                                            <button type="button" onclick="setTextColor('#0000FF')"
                                                class="w-6 h-6 rounded border" style="background-color: #0000FF"
                                                title="Blue"></button>
                                            <button type="button" onclick="setTextColor('#FFFF00')"
                                                class="w-6 h-6 rounded border" style="background-color: #FFFF00"
                                                title="Yellow"></button>
                                            <button type="button" onclick="setTextColor('#FF00FF')"
                                                class="w-6 h-6 rounded border" style="background-color: #FF00FF"
                                                title="Magenta"></button>
                                            <button type="button" onclick="setTextColor('#00FFFF')"
                                                class="w-6 h-6 rounded border" style="background-color: #00FFFF"
                                                title="Cyan"></button>
                                            <button type="button" onclick="setTextColor('#FFA500')"
                                                class="w-6 h-6 rounded border" style="background-color: #FFA500"
                                                title="Orange"></button>
                                            <button type="button" onclick="setTextColor('#800080')"
                                                class="w-6 h-6 rounded border" style="background-color: #800080"
                                                title="Purple"></button>
                                            <button type="button" onclick="setTextColor('#008000')"
                                                class="w-6 h-6 rounded border" style="background-color: #008000"
                                                title="Dark Green"></button>
                                            <button type="button" onclick="setTextColor('#000080')"
                                                class="w-6 h-6 rounded border" style="background-color: #000080"
                                                title="Navy"></button>
                                            <button type="button" onclick="setTextColor('#808080')"
                                                class="w-6 h-6 rounded border" style="background-color: #808080"
                                                title="Gray"></button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Background Color -->
                                <div class="relative">
                                    <button type="button" onclick="toggleBgColorPicker()" class="toolbar-btn"
                                        title="Background Color">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2a2 2 0 002-2V5a2 2 0 00-2-2z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div id="bgColorPicker"
                                        class="hidden absolute top-8 left-0 bg-white border rounded-lg p-2 z-10 shadow-lg">
                                        <div class="grid grid-cols-6 gap-1">
                                            <button type="button" onclick="setBgColor('transparent')"
                                                class="w-6 h-6 rounded border bg-white" title="No Background"></button>
                                            <button type="button" onclick="setBgColor('#FFFF00')"
                                                class="w-6 h-6 rounded border" style="background-color: #FFFF00"
                                                title="Yellow"></button>
                                            <button type="button" onclick="setBgColor('#00FF00')"
                                                class="w-6 h-6 rounded border" style="background-color: #00FF00"
                                                title="Green"></button>
                                            <button type="button" onclick="setBgColor('#00FFFF')"
                                                class="w-6 h-6 rounded border" style="background-color: #00FFFF"
                                                title="Cyan"></button>
                                            <button type="button" onclick="setBgColor('#FF00FF')"
                                                class="w-6 h-6 rounded border" style="background-color: #FF00FF"
                                                title="Magenta"></button>
                                            <button type="button" onclick="setBgColor('#FFA500')"
                                                class="w-6 h-6 rounded border" style="background-color: #FFA500"
                                                title="Orange"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Structure -->
                            <div class="flex flex-wrap gap-1 mb-2">
                                <!-- Headings -->
                                <select onchange="formatHeading(this.value)"
                                    class="text-xs px-2 py-1 border rounded bg-white">
                                    <option value="">Heading</option>
                                    <option value="H1">Heading 1</option>
                                    <option value="H2">Heading 2</option>
                                    <option value="H3">Heading 3</option>
                                    <option value="H4">Heading 4</option>
                                    <option value="H5">Heading 5</option>
                                    <option value="H6">Heading 6</option>
                                </select>

                                <div class="border-l border-gray-400 mx-1"></div>

                                <!-- Lists -->
                                <button type="button" onclick="formatText('insertUnorderedList')" class="toolbar-btn"
                                    title="Bullet List">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('insertOrderedList')" class="toolbar-btn"
                                    title="Numbered List">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('outdent')" class="toolbar-btn"
                                    title="Decrease Indent">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 5l7 7-7 7M6 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('indent')" class="toolbar-btn"
                                    title="Increase Indent">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                                    </svg>
                                </button>

                                <div class="border-l border-gray-400 mx-1"></div>

                                <!-- Alignment -->
                                <button type="button" onclick="formatText('justifyLeft')" class="toolbar-btn"
                                    title="Align Left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h8m-8 6h16"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('justifyCenter')" class="toolbar-btn"
                                    title="Align Center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M8 12h8M4 18h16"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('justifyRight')" class="toolbar-btn"
                                    title="Align Right">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 6H4m16 6h-8m8 6H4"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('justifyFull')" class="toolbar-btn"
                                    title="Justify">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Row 3: Media & Advanced -->
                            <div class="flex flex-wrap gap-1">
                                <!-- Links -->
                                <button type="button" onclick="insertLink()" class="toolbar-btn" title="Insert Link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('unlink')" class="toolbar-btn"
                                    title="Remove Link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <div class="border-l border-gray-400 mx-1"></div>

                                <!-- Image Upload -->
                                <label for="contentImageInput" class="toolbar-btn cursor-pointer" title="Insert Image">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <input type="file" id="contentImageInput" accept="image/*" class="hidden"
                                        onchange="insertImage(this)">
                                </label>

                                <!-- Video Embed -->
                                <button type="button" onclick="insertVideo()" class="toolbar-btn" title="Insert Video">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </button>

                                <!-- Table -->
                                <button type="button" onclick="insertTable()" class="toolbar-btn" title="Insert Table">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M3 14h18m-9-4v8m-7 0V4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H5a1 1 0 01-1-1V10z">
                                        </path>
                                    </svg>
                                </button>

                                <!-- Horizontal Rule -->
                                <button type="button" onclick="insertHorizontalRule()" class="toolbar-btn"
                                    title="Insert Horizontal Line">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 12H4"></path>
                                    </svg>
                                </button>

                                <!-- Code Block -->
                                <button type="button" onclick="insertCodeBlock()" class="toolbar-btn"
                                    title="Insert Code Block">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                    </svg>
                                </button>

                                <!-- Quote Block -->
                                <button type="button" onclick="insertQuote()" class="toolbar-btn" title="Insert Quote">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                </button>

                                <div class="border-l border-gray-400 mx-1"></div>

                                <!-- Clear Formatting -->
                                <button type="button" onclick="formatText('removeFormat')" class="toolbar-btn"
                                    title="Clear Formatting">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>

                                <!-- Undo/Redo -->
                                <button type="button" onclick="formatText('undo')" class="toolbar-btn" title="Undo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('redo')" class="toolbar-btn" title="Redo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 10h-10a8 8 0 00-8 8v2m18-10l-6 6m6-6l-6-6"></path>
                                    </svg>
                                </button>

                                <!-- Full Screen -->
                                <button type="button" onclick="toggleFullscreen()" class="toolbar-btn"
                                    title="Toggle Fullscreen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Rich Text Editor -->
                        <div id="editorContainer" class="border border-gray-300 border-t-0 rounded-b-lg">
                            <div id="editor" contenteditable="true"
                                class="w-full min-h-96 px-4 py-3 border-0 bg-white focus:ring-0 focus:outline-none"
                                style="max-height: 500px; overflow-y: auto;"
                                data-placeholder="Write your blog content here...">{!! old('content') !!}</div>
                            <textarea id="content" name="content" class="hidden" required>{{ old('content') }}</textarea>
                        </div>

                        <!-- Editor Helper Text -->
                        <div
                            class="flex flex-col sm:flex-row sm:justify-between text-xs text-gray-500 mt-2 space-y-1 sm:space-y-0">
                            <div class="flex items-center space-x-4">
                                <span>📝 Rich text formatting enabled</span>
                                <span>🖼️ Images supported</span>
                                <span>🎬 Video embeds supported</span>
                                <span>📊 Tables supported</span>
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

                        <!-- Author Selection (Original for current user/admins) -->
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
                                {{-- Optionally load other admin/editor users here if needed --}}
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

                        <!-- Member Selection (for member contributions) -->
                        <div class="space-y-2">
                            <label for="member_id" class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2" style="color: #22c55e;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                Member (Optional - if different from logged-in user)
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
                            <p class="text-xs text-gray-500">Select a member if this post is by them. Otherwise, it's
                                assigned to the logged-in admin.</p>
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

                        <!-- Status -->
                        {{-- <div class="space-y-2">
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="checkbox" name="status" value="1"
                                    {{ old('status', 1) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1" style="color: #22c55e;" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Publish Immediately
                                </span>
                            </label>
                            <p class="text-xs text-gray-500 ml-7">Uncheck to save as draft</p>
                        </div> --}}


                        {{-- <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700">Status</p>

                            <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="radio" name="status" value="draft"
                                    {{ old('status') === 'draft' ? 'checked' : '' }} class="w-4 h-4 text-blue-600">
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v8m0 0l-4-4m4 4l4-4"></path>
                                    </svg>
                                    Draft
                                </span>
                            </label>

                            <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="radio" name="status" value="published"
                                    {{ old('status', 'published') === 'published' ? 'checked' : '' }}
                                    class="w-4 h-4 text-green-600">
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Published
                                </span>
                            </label>

                            <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="radio" name="status" value="archived"
                                    {{ old('status') === 'archived' ? 'checked' : '' }} class="w-4 h-4 text-yellow-600">
                                <span class="ml-3 text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 inline mr-1 text-yellow-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Archived
                                </span>
                            </label>
                        </div> --}}



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
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1-81h4.914a1 1 0 00.951-.69l1.519-4.674z">
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

        /* Custom focus styles */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(0, 73, 155, 0.1);
        }

        /* Rich Text Editor Styles */
        .toolbar-btn {
            padding: 6px 8px;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #374151;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
        }

        .toolbar-btn:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }

        .toolbar-btn:active,
        .toolbar-btn.active {
            background: var(--primary-blue);
            color: white;
            border-color: var(--light-blue);
        }

        #editor {
            outline: none;
        }

        #editor:empty::before {
            content: attr(data-placeholder);
            color: #9ca3af;
            font-style: italic;
        }

        #editor h1,
        #editor h2,
        #editor h3,
        #editor h4,
        #editor h5,
        #editor h6 {
            font-weight: bold;
            margin: 16px 0 8px 0;
        }

        #editor h1 {
            font-size: 2em;
        }

        #editor h2 {
            font-size: 1.5em;
        }

        #editor h3 {
            font-size: 1.3em;
        }

        #editor h4 {
            font-size: 1.1em;
        }

        #editor ul,
        #editor ol {
            margin: 8px 0;
            padding-left: 24px;
        }

        #editor li {
            margin: 4px 0;
        }

        #editor a {
            color: #3b82f6;
            text-decoration: underline;
        }

        #editor p {
            margin: 8px 0;
        }

        /* Tag Styles */
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

        /* Dropzone Styles */
        .dropzone {
            border: 2px dashed #60a5fa;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .dropzone:hover {
            border-color: var(--primary-blue);
            background: linear-gradient(135deg, rgba(0, 73, 155, 0.05), rgba(30, 91, 184, 0.05));
        }

        /* Form validation styles */
        .form-error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .form-success {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        /* Animation for form sections */
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

        /* Notification Animation */
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

        #editor .content-image:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
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

        /* Enhanced button states */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
            color: white;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 73, 155, 0.3);
        }

        /* Loading animation */
        .loading {
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s ease infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .grid-cols-1.lg\\:grid-cols-3 {
                grid-template-columns: 1fr;
            }

            .toolbar-btn {
                min-width: 28px;
                height: 28px;
                font-size: 10px;
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

        @media (max-width: 640px) {
            .flex.justify-between.items-center {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .toolbar-btn {
                min-width: 24px;
                height: 24px;
            }
        }

        /* Fullscreen Editor Styles */
        .fullscreen-editor {
            max-height: 100vh !important;
            height: 100vh !important;
            width: 100vw !important;
            overflow: auto !important;
            /* Allow scrolling within the fullscreen editor */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            background-color: white;
            /* Ensure it covers everything */
        }



        /* Enhanced Rich Text Editor Styles */
        #editor {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #1f2937;
        }

        #editor img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 16px auto;
            display: block;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        #editor img:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 16px rgba(0, 73, 155, 0.2);
        }

        #editor img.selected {
            outline: 3px solid #00499b;
            outline-offset: 2px;
        }

        /* Image Resize Handles */
        .image-wrapper {
            position: relative;
            display: inline-block;
            max-width: 100%;
        }

        .image-wrapper img {
            display: block;
        }

        .resize-handle {
            position: absolute;
            width: 12px;
            height: 12px;
            background: #00499b;
            border: 2px solid white;
            border-radius: 50%;
            cursor: nwse-resize;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .resize-handle.se {
            bottom: -6px;
            right: -6px;
        }

        /* Enhanced Table Styles */
        #editor table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        #editor table th {
            background: linear-gradient(135deg, #00499b, #1e5bb8);
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        #editor table td {
            padding: 12px;
            border: 1px solid #e5e7eb;
        }

        #editor table tr:hover {
            background-color: #f9fafb;
        }

        /* Code Block Enhanced */
        #editor pre {
            background: #1e293b;
            color: #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.5;
            margin: 20px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Blockquote Enhanced */
        #editor blockquote {
            border-left: 4px solid #00499b;
            background: linear-gradient(to right, #f0f7ff, #ffffff);
            padding: 16px 24px;
            margin: 20px 0;
            font-style: italic;
            border-radius: 0 8px 8px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* List Styles */
        #editor ul {
            list-style-type: disc;
            padding-left: 30px;
            margin: 12px 0;
        }

        #editor ol {
            list-style-type: decimal;
            padding-left: 30px;
            margin: 12px 0;
        }

        #editor li {
            margin: 8px 0;
            line-height: 1.6;
        }

        /* Heading Styles */
        #editor h1 {
            font-size: 2.25em;
            font-weight: 700;
            color: #111827;
            margin: 24px 0 16px 0;
            border-bottom: 2px solid #00499b;
            padding-bottom: 8px;
        }

        #editor h2 {
            font-size: 1.875em;
            font-weight: 700;
            color: #1f2937;
            margin: 20px 0 12px 0;
        }

        #editor h3 {
            font-size: 1.5em;
            font-weight: 600;
            color: #374151;
            margin: 16px 0 10px 0;
        }

        #editor h4 {
            font-size: 1.25em;
            font-weight: 600;
            color: #4b5563;
            margin: 14px 0 8px 0;
        }

        /* Link Styles */
        #editor a {
            color: #2563eb;
            text-decoration: underline;
            transition: color 0.2s;
        }

        #editor a:hover {
            color: #1d4ed8;
        }

        /* Selection Highlight */
        #editor ::selection {
            background-color: rgba(0, 73, 155, 0.2);
            color: inherit;
        }

        /* Video Container */
        #editor .video-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 */
            height: 0;
            overflow: hidden;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        #editor .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Horizontal Rule */
        #editor hr {
            border: none;
            border-top: 2px solid #e5e7eb;
            margin: 24px 0;
        }

        /* Toolbar Button Active State */
        .toolbar-btn.active {
            background: #00499b;
            color: white;
            border-color: #1e5bb8;
        }


        /* Editor Image Styles */
        #editor .editor-image {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 16px auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #editor .editor-image:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 16px rgba(0, 73, 155, 0.2);
        }

        #editor .editor-image.selected {
            outline: 3px solid #00499b;
            outline-offset: 3px;
        }

        /* Image Toolbar Buttons */
        #imageToolbar .toolbar-btn {
            min-width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }



        /* Toolbar Animations */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Image Toolbar Hover Effects */
        #imageToolbar .toolbar-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 73, 155, 0.2);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // ==========================================
        // GLOBAL HELPER FUNCTIONS
        // ==========================================

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
                'error': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                'warning': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>',
                'info': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            };

            notification.innerHTML = `
        <div class="${bgColor} text-white p-4 rounded-lg shadow-lg flex items-center">
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

        // Custom Confirmation Modal (replaces window.confirm)
        function showConfirmationModal(title, message, onConfirm) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-[9999]';
            modal.innerHTML = `
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm mx-auto animate-scale-in">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">${title}</h3>
            <p class="text-gray-700 mb-6">${message}</p>
            <div class="flex justify-end space-x-3">
                <button id="cancelBtn" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</button>
                <button id="confirmBtn" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">Confirm</button>
            </div>
              </div>
                  `;
            document.body.appendChild(modal);

            document.getElementById('cancelBtn').addEventListener('click', () => modal.remove());
            document.getElementById('confirmBtn').addEventListener('click', () => {
                onConfirm();
                modal.remove();
            });

            // Simple animation for the modal
            const style = document.createElement('style');
            style.innerHTML = `
             @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
            }
           .animate-scale-in {
            animation: scaleIn 0.2s ease-out;
            }
            `;
            document.head.appendChild(style);
        }


        // Custom Prompt Modal with an input field
        function showPromptModal(title, message, onConfirm) {
            let savedRange = null;
            if (window.getSelection) {
                const sel = window.getSelection();
                if (sel.getRangeAt && sel.rangeCount) {
                    savedRange = sel.getRangeAt(0);
                }
            }

            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-[9999]';
            modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm mx-auto" style="animation: scaleIn 0.2s ease-out;">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">${title}</h3>
            <p class="text-gray-700 mb-2">${message}</p>
            <input id="promptInput" type="url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 mb-6" placeholder="https://example.com">
            <div class="flex justify-end space-x-3">
                <button id="cancelBtn" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</button>
                <button id="confirmBtn" type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">Confirm</button>
            </div>
        </div>
    `;
            document.body.appendChild(modal);

            const inputField = document.getElementById('promptInput');
            inputField.focus();

            const closeModal = () => modal.remove();

            const confirmAction = () => {
                if (savedRange && window.getSelection) {
                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(savedRange);
                }
                onConfirm(inputField.value);
                closeModal();
            };

            inputField.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    confirmAction();
                }
            });

            document.getElementById('cancelBtn').addEventListener('click', closeModal);
            document.getElementById('confirmBtn').addEventListener('click', confirmAction);
        }

        window.showNotification = showNotification; // Make globally accessible

        // ==========================================
        // RICH TEXT EDITOR FUNCTIONS
        // ==========================================\



        // Custom Prompt Modal with an input field
        function showPromptModal(title, message, onConfirm) {
            // First, save the current text selection
            let savedRange = null;
            if (window.getSelection) {
                const sel = window.getSelection();
                if (sel.getRangeAt && sel.rangeCount) {
                    savedRange = sel.getRangeAt(0);
                }
            }

            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-[9999]';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm mx-auto animate-scale-in">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">${title}</h3>
                    <p class="text-gray-700 mb-2">${message}</p>
                    <input id="promptInput" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200 mb-6" placeholder="https://example.com">
                    <div class="flex justify-end space-x-3">
                        <button id="cancelBtn" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</button>
                        <button id="confirmBtn" type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">Confirm</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);

            const inputField = document.getElementById('promptInput');
            inputField.focus();

            const closeModal = () => modal.remove();

            const confirmAction = () => {
                // Restore the selection before executing the confirm action
                if (savedRange && window.getSelection) {
                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(savedRange);
                }
                onConfirm(inputField.value);
                closeModal();
            };

            inputField.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    confirmAction();
                }
            });

            document.getElementById('cancelBtn').addEventListener('click', closeModal);
            document.getElementById('confirmBtn').addEventListener('click', confirmAction);

            // ... (animation style code is fine as it is) ...
        }


        window.formatText = function(command, value = null) {
            try {
                document.execCommand(command, false, value);
                const editor = document.getElementById('editor');
                const contentInput = document.getElementById('content');
                if (editor && contentInput) {
                    contentInput.value = editor.innerHTML;
                    editor.focus();
                }
            } catch (error) {
                console.error('Format error:', error);
                showNotification('Formatting failed', 'error');
            }
        };

        window.formatHeading = function(tag) {
            if (tag) formatText('formatBlock', tag);
        };

        window.changeFontSize = function(size) {
            if (size) formatText('fontSize', size);
        };

        window.insertLink = function() {
            showPromptModal('Insert Link', 'Enter URL:', (url) => {
                if (url) {
                    // Automatically add https:// if not present for robustness
                    if (!url.startsWith('http://') && !url.startsWith('https://')) {
                        url = 'https://' + url;
                    }
                    formatText('createLink', url);
                }
            });
        };

        window.toggleColorPicker = function() {
            const colorPicker = document.getElementById('colorPicker');
            const bgColorPicker = document.getElementById('bgColorPicker');
            if (colorPicker) {
                colorPicker.classList.toggle('hidden');
                if (bgColorPicker) bgColorPicker.classList.add('hidden');
            }
        };

        window.toggleBgColorPicker = function() {
            const colorPicker = document.getElementById('colorPicker');
            const bgColorPicker = document.getElementById('bgColorPicker');
            if (bgColorPicker) {
                bgColorPicker.classList.toggle('hidden');
                if (colorPicker) colorPicker.classList.add('hidden');
            }
        };

        window.setTextColor = function(color) {
            formatText('foreColor', color);
            const picker = document.getElementById('colorPicker');
            if (picker) picker.classList.add('hidden');
        };

        window.setBgColor = function(color) {
            if (color === 'transparent') {
                formatText('hiliteColor', 'transparent');
                formatText('backColor', 'transparent');
            } else {
                formatText('hiliteColor', color);
            }
            const picker = document.getElementById('bgColorPicker');
            if (picker) picker.classList.add('hidden');
        };

        // image tool bar

        window.insertImage = function(input) {
            const file = input.files[0];
            if (!file) {
                showNotification('No file selected', 'error');
                return;
            }

            if (!file.type.startsWith('image/')) {
                showNotification('Please select an image file', 'error');
                input.value = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                showNotification('Image must be less than 5MB', 'error');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const imageId = 'img_' + Date.now();

                // Create image HTML - SIMPLE VERSION without wrapper
                const imgHtml = `<p><img src="${e.target.result}" 
                     id="${imageId}"
                     style="max-width: 100%; height: auto; display: block; margin: 16px auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); cursor: pointer;" 
                     alt="Content Image"
                     class="editor-image"></p>`;

                // Insert into editor
                const editor = document.getElementById('editor');
                if (editor) {
                    // Focus editor first
                    editor.focus();

                    // Insert HTML
                    document.execCommand('insertHTML', false, imgHtml);

                    // Update hidden content field
                    const contentInput = document.getElementById('content');
                    if (contentInput) {
                        contentInput.value = editor.innerHTML;
                    }

                    // Wait for image to be inserted then add event
                    // Wait for image to be inserted then setup
                    setTimeout(() => {
                        const insertedImg = document.getElementById(imageId);
                        if (insertedImg) {
                            console.log('Image inserted with ID:', imageId); // Debug

                            // Ensure class is added
                            if (!insertedImg.classList.contains('editor-image')) {
                                insertedImg.classList.add('editor-image');
                            }

                            // Force a re-render
                            insertedImg.style.display = 'block';

                            // Test click immediately
                            console.log('Image ready for clicking');
                        } else {
                            console.error('Image not found after insertion!'); // Debug
                        }
                    }, 150); // Increased timeout slightly

                    showNotification('Image inserted successfully! Click image to resize or delete', 'success');
                }
            };

            reader.onerror = () => showNotification('Failed to read file', 'error');
            reader.readAsDataURL(file);
            input.value = '';
        };

        // Image Selection and Toolbar


        // Image Selection and Toolbar
        let selectedImage = null;
        let currentToolbar = null;

        window.selectImage = function(imageId) {
            console.log('Selecting image:', imageId); // Debug log

            // Remove previous selection
            const allImages = document.querySelectorAll('.editor-image');
            allImages.forEach(img => img.classList.remove('selected'));

            // Select new image
            selectedImage = document.getElementById(imageId);
            if (selectedImage) {
                selectedImage.classList.add('selected');
                showImageToolbar(imageId);
            }
        };

        // Show Image Toolbar
        function showImageToolbar(imageId) {
            console.log('Showing toolbar for:', imageId); // Debug log

            // Remove existing toolbar
            if (currentToolbar) {
                currentToolbar.remove();
                currentToolbar = null;
            }

            const img = document.getElementById(imageId);
            if (!img) {
                console.log('Image not found!'); // Debug log
                return;
            }

            const toolbar = document.createElement('div');
            toolbar.id = 'imageToolbar';
            toolbar.className = 'image-toolbar-popup';
            toolbar.style.cssText = `
        position: absolute;
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border: 2px solid #00499b;
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 8px 24px rgba(0,73,155,0.25);
        display: flex;
        gap: 8px;
        z-index: 10000;
        animation: slideDown 0.3s ease;
    `;

            toolbar.innerHTML = `
        <div style="display: flex; gap: 6px; align-items: center;">
            <!-- Size Buttons -->
            <div style="display: flex; gap: 4px; padding-right: 8px; border-right: 2px solid #e5e7eb;">
                <button type="button" onclick="resizeImage('${imageId}', 'small')" class="toolbar-btn" title="Small (300px)" style="min-width: 40px;">
                    <span style="font-size: 11px; font-weight: 600;">S</span>
                </button>
                <button type="button" onclick="resizeImage('${imageId}', 'medium')" class="toolbar-btn" title="Medium (500px)" style="min-width: 40px;">
                    <span style="font-size: 13px; font-weight: 600;">M</span>
                </button>
                <button type="button" onclick="resizeImage('${imageId}', 'large')" class="toolbar-btn" title="Large (700px)" style="min-width: 40px;">
                    <span style="font-size: 15px; font-weight: 600;">L</span>
                </button>
                <button type="button" onclick="resizeImage('${imageId}', 'full')" class="toolbar-btn" title="Full Width" style="min-width: 40px;">
                    <span style="font-size: 15px; font-weight: 600;">F</span>
                </button>
            </div>
            
            <!-- Alignment Buttons -->
            <div style="display: flex; gap: 4px; padding-right: 8px; border-right: 2px solid #e5e7eb;">
                <button type="button" onclick="alignImage('${imageId}', 'left')" class="toolbar-btn" title="Align Left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"></path>
                    </svg>
                </button>
                <button type="button" onclick="alignImage('${imageId}', 'center')" class="toolbar-btn" title="Align Center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M8 12h8M4 18h16"></path>
                    </svg>
                </button>
                <button type="button" onclick="alignImage('${imageId}', 'right')" class="toolbar-btn" title="Align Right">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6H4m16 6h-8m8 6H4"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Delete Button -->
            <button type="button" onclick="deleteImage('${imageId}')" class="toolbar-btn" title="Delete Image" style="background: #fee2e2; color: #dc2626; border-color: #fca5a5;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    `;

            document.body.appendChild(toolbar);
            currentToolbar = toolbar;

            // Position toolbar near image
            const rect = img.getBoundingClientRect();
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

            // Calculate position
            let top = rect.top + scrollTop - toolbar.offsetHeight - 15;
            let left = rect.left + scrollLeft + (rect.width / 2) - (toolbar.offsetWidth / 2);

            // Keep toolbar within viewport
            if (top < scrollTop + 10) {
                top = rect.bottom + scrollTop + 10;
            }
            if (left < scrollLeft + 10) {
                left = scrollLeft + 10;
            }
            if (left + toolbar.offsetWidth > scrollLeft + window.innerWidth - 10) {
                left = scrollLeft + window.innerWidth - toolbar.offsetWidth - 10;
            }

            toolbar.style.top = top + 'px';
            toolbar.style.left = left + 'px';

            console.log('Toolbar positioned at:', top, left); // Debug log
        }

        // Resize Image
        window.resizeImage = function(imageId, size) {
            const img = document.getElementById(imageId);
            if (!img) return;

            const sizes = {
                'small': '300px',
                'medium': '500px',
                'large': '700px',
                'full': '100%'
            };

            img.style.width = sizes[size] || '100%';
            img.style.height = 'auto';

            const editor = document.getElementById('editor');
            const contentInput = document.getElementById('content');
            if (editor && contentInput) {
                contentInput.value = editor.innerHTML;
            }

            showNotification(`📏 Image resized to ${size}`, 'success');

            // Reposition toolbar after resize
            setTimeout(() => showImageToolbar(imageId), 50);
        };

        // Align Image
        window.alignImage = function(imageId, alignment) {
            const img = document.getElementById(imageId);
            if (!img) return;

            const parent = img.parentElement;
            if (parent) {
                if (alignment === 'left') {
                    parent.style.textAlign = 'left';
                    img.style.marginLeft = '0';
                    img.style.marginRight = 'auto';
                    img.style.display = 'block';
                } else if (alignment === 'center') {
                    parent.style.textAlign = 'center';
                    img.style.marginLeft = 'auto';
                    img.style.marginRight = 'auto';
                    img.style.display = 'block';
                } else if (alignment === 'right') {
                    parent.style.textAlign = 'right';
                    img.style.marginLeft = 'auto';
                    img.style.marginRight = '0';
                    img.style.display = 'block';
                }
            }

            const editor = document.getElementById('editor');
            const contentInput = document.getElementById('content');
            if (editor && contentInput) {
                contentInput.value = editor.innerHTML;
            }

            showNotification(`↔️ Image aligned to ${alignment}`, 'success');
        };

        // Delete Image
        window.deleteImage = function(imageId) {
            const img = document.getElementById(imageId);
            if (!img) return;

            // Create custom confirmation modal
            const confirmModal = document.createElement('div');
            confirmModal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        animation: fadeIn 0.2s ease;
    `;

            confirmModal.innerHTML = `
        <div style="background: white; padding: 24px; border-radius: 12px; max-width: 400px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); animation: scaleIn 0.3s ease;">
            <div style="display: flex; align-items: center; margin-bottom: 16px;">
                <svg style="width: 24px; height: 24px; color: #dc2626; margin-right: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin: 0;">Delete Image?</h3>
            </div>
            <p style="color: #6b7280; margin-bottom: 20px;">Are you sure you want to delete this image? This action cannot be undone.</p>
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button id="cancelDelete" type="button" style="padding: 8px 16px; background: #f3f4f6; color: #374151; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;">Cancel</button>
                <button id="confirmDelete" type="button" style="padding: 8px 16px; background: #dc2626; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;">Delete</button>
            </div>
        </div>
    `;

            document.body.appendChild(confirmModal);

            // Handle buttons
            document.getElementById('cancelDelete').onclick = () => {
                confirmModal.remove();
            };

            document.getElementById('confirmDelete').onclick = () => {
                const parent = img.parentElement;
                if (parent && parent.tagName === 'P' && parent.children.length === 1) {
                    parent.remove();
                } else {
                    img.remove();
                }

                if (currentToolbar) {
                    currentToolbar.remove();
                    currentToolbar = null;
                }

                const editor = document.getElementById('editor');
                const contentInput = document.getElementById('content');
                if (editor && contentInput) {
                    contentInput.value = editor.innerHTML;
                }

                confirmModal.remove();
                showNotification('🗑️ Image deleted successfully', 'info');
            };
        };

        // Click outside to hide toolbar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.editor-image') && !e.target.closest('#imageToolbar') && !e.target.closest(
                    '.image-toolbar-popup')) {
                if (currentToolbar) {
                    currentToolbar.remove();
                    currentToolbar = null;
                }

                const allImages = document.querySelectorAll('.editor-image');
                allImages.forEach(img => img.classList.remove('selected'));
                selectedImage = null;
            }
        });









        // end image





        window.insertVideo = function() {
            const url = prompt('Enter YouTube, Vimeo, or video URL:');
            if (!url) return;

            let embedCode = '';
            if (url.includes('youtube.com') || url.includes('youtu.be')) {
                const videoId = url.includes('youtu.be/') ?
                    url.split('youtu.be/')[1].split('?')[0] :
                    url.split('v=')[1]?.split('&')[0];
                if (videoId) {
                    embedCode =
                        `<div class="video-container"><iframe src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe></div><p><br></p>`;
                }
            } else if (url.includes('vimeo.com')) {
                const videoId = url.split('vimeo.com/')[1]?.split('?')[0];
                if (videoId) {
                    embedCode =
                        `<div class="video-container"><iframe src="https://player.vimeo.com/video/${videoId}" frameborder="0" allowfullscreen></iframe></div><p><br></p>`;
                }
            } else if (url.match(/\.(mp4|webm|ogg)$/i)) {
                embedCode =
                    `<div style="margin: 20px 0;"><video controls style="max-width: 100%; border-radius: 8px;"><source src="${url}" type="video/mp4"></video></div><p><br></p>`;
            }

            if (embedCode) {
                document.execCommand('insertHTML', false, embedCode);
                const editor = document.getElementById('editor');
                const contentInput = document.getElementById('content');
                if (editor && contentInput) contentInput.value = editor.innerHTML;
                showNotification('Video inserted!', 'success');
            } else {
                showNotification('Invalid video URL', 'error');
            }
        };

        window.insertTable = function() {
            const rows = prompt('Number of rows:');
            if (!rows) return;
            const rowCount = parseInt(rows);
            if (isNaN(rowCount) || rowCount < 1) {
                showNotification('Invalid number of rows', 'error');
                return;
            }

            const cols = prompt('Number of columns:');
            if (!cols) return;
            const colCount = parseInt(cols);
            if (isNaN(colCount) || colCount < 1) {
                showNotification('Invalid number of columns', 'error');
                return;
            }

            let html = '<table style="border-collapse: collapse; width: 100%; margin: 20px 0;">';
            for (let i = 0; i < rowCount; i++) {
                html += '<tr>';
                for (let j = 0; j < colCount; j++) {
                    if (i === 0) {
                        html +=
                            `<th style="padding: 12px; text-align: left; border: 1px solid #e5e7eb;">Header ${j + 1}</th>`;
                    } else {
                        html += `<td style="padding: 12px; border: 1px solid #e5e7eb;">Cell ${i + 1}-${j + 1}</td>`;
                    }
                }
                html += '</tr>';
            }
            html += '</table><p><br></p>';

            document.execCommand('insertHTML', false, html);
            const editor = document.getElementById('editor');
            const contentInput = document.getElementById('content');
            if (editor && contentInput) contentInput.value = editor.innerHTML;
            showNotification('Table inserted!', 'success');
        };

        window.insertHorizontalRule = function() {
            const hr = '<hr style="margin: 20px 0; border: none; border-top: 2px solid #e5e7eb;"><p></p>';
            document.execCommand('insertHTML', false, hr);
            const editor = document.getElementById('editor');
            const contentInput = document.getElementById('content');
            if (editor && contentInput) contentInput.value = editor.innerHTML;
            showNotification('Horizontal rule inserted!', 'success');
        };

        window.insertCodeBlock = function() {
            showConfirmationModal('Insert Code Block', 'Enter code:', (code) => {
                if (code) {
                    const block =
                        `<div style="background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 16px; margin: 20px 0; font-family: 'Courier New', monospace; overflow-x: auto;"><pre style="margin: 0; white-space: pre-wrap;">${code.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</pre></div><p></p>`;
                    document.execCommand('insertHTML', false, block);
                    const editor = document.getElementById('editor');
                    const contentInput = document.getElementById('content');
                    if (editor && contentInput) contentInput.value = editor.innerHTML;
                    showNotification('Code block inserted!', 'success');
                }
            });
        };

        window.insertQuote = function() {
            showConfirmationModal('Insert Quote', 'Enter quote:', (quote) => {
                if (quote) {
                    const block =
                        `<blockquote style="border-left: 4px solid #00499b; margin: 20px 0; padding: 16px 24px; background: #f8f9ff; font-style: italic; border-radius: 0 8px 8px 0;">${quote}</blockquote><p></p>`;
                    document.execCommand('insertHTML', false, block);
                    const editor = document.getElementById('editor');
                    const contentInput = document.getElementById('content');
                    if (editor && contentInput) contentInput.value = editor.innerHTML;
                    showNotification('Quote inserted!', 'success');
                }
            });
        };

        window.toggleFullscreen = function() {
            const editorContainer = document.getElementById('editorContainer');
            const formContainer = document.querySelector(
                '.form-section.bg-white.rounded-xl.p-6.shadow-sm.border.border-gray-200'
            ); // Assuming this is the parent of editorContainer
            if (!editorContainer || !formContainer) return;

            if (editorContainer.classList.contains('fullscreen-editor')) {
                editorContainer.classList.remove('fullscreen-editor');
                editorContainer.style.position = '';
                editorContainer.style.top = '';
                editorContainer.style.left = '';
                editorContainer.style.right = '';
                editorContainer.style.bottom = '';
                editorContainer.style.zIndex = '';
                editorContainer.style.backgroundColor = '';
                document.body.style.overflow = '';
                if (formContainer) formContainer.style.height = ''; // Reset parent height
            } else {
                editorContainer.classList.add('fullscreen-editor');
                editorContainer.style.position = 'fixed';
                editorContainer.style.top = '0';
                editorContainer.style.left = '0';
                editorContainer.style.right = '0';
                editorContainer.style.bottom = '0';
                editorContainer.style.zIndex = '9999';
                editorContainer.style.backgroundColor = 'white';
                document.body.style.overflow = 'hidden'; // Hide body scrollbar
                if (formContainer) formContainer.style.height = '100vh'; // Ensure parent allows full height
            }
            showNotification(editorContainer.classList.contains('fullscreen-editor') ? 'Fullscreen enabled!' :
                'Fullscreen disabled!', 'info');
        };


        window.saveDraft = function() {
            const checkbox = document.querySelector('input[name="status"]');
            if (checkbox) checkbox.checked = false; // Uncheck to save as draft
            const form = document.getElementById('blogForm');
            if (form) {
                const editor = document.getElementById('editor');
                const contentInput = document.getElementById('content');
                if (editor && contentInput) contentInput.value = editor.innerHTML;

                // Temporarily change the 'action' button's value to 'draft'
                const publishButton = form.querySelector('button[name="action"][value="publish"]');
                if (publishButton) {
                    publishButton.name = 'temp_action'; // Change name to avoid sending two 'action' fields
                }
                const draftButton = form.querySelector('button[name="action"][value="draft"]');
                if (draftButton) {
                    draftButton.name = 'action'; // Ensure only the draft button sends 'action'
                }

                form.submit();
            }
        };

        window.resetForm = function() {
            showConfirmationModal('Reset Form',
                'Are you sure you want to reset the form? All unsaved data will be lost.', () => {
                    const form = document.getElementById('blogForm');
                    if (form) form.reset();

                    const editor = document.getElementById('editor');
                    if (editor) editor.innerHTML = '';

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
                });
        };

        // Function to set author_id and author_type based on selection
        // window.setAuthorType = function(memberId = null) {
        //     const authorIdHidden = document.querySelector('input[name="author_id"]');
        //     const authorTypeHidden = document.querySelector('input[name="author_type"]');

        //     if (authorIdHidden && authorTypeHidden) {
        //         if (memberId) {

        //             authorIdHidden.value = memberId;
        //             authorTypeHidden.value = 'App\\Models\\User';  
        //         } else {

        //             authorIdHidden.value = '{{ auth()->id() }}';
        //             authorTypeHidden.value = 'App\\Models\\User';  
        //         }
        //     }
        // };


        window.setAuthorType = function(memberId = null) {
            const authorIdHidden = document.querySelector('input[name="author_id"]');
            const authorTypeHidden = document.querySelector('input[name="author_type"]');

            // PHP-এর মাধ্যমে সঠিক মডেল ক্লাসটি জাভাস্ক্রিপ্টে ইনজেক্ট করা হলো
            const modelClass = '{{ addslashes(\Sndpbag\AdminPanel\Models\User::class) }}';
            // এই addslashes() ফাংশনটি জাভাস্ক্রিপ্ট স্ট্রিং-এ \s গুলোকে ঠিকমতো escape করবে।

            if (authorIdHidden && authorTypeHidden) {
                if (memberId) {
                    // যদি মেম্বার সিলেক্ট করা হয়
                    authorIdHidden.value = memberId;
                    authorTypeHidden.value = modelClass; // সঠিক মডেল ক্লাস ব্যবহার করা হলো
                } else {
                    // যদি লগইন করা অ্যাডমিন থাকে
                    authorIdHidden.value = '{{ auth()->id() }}';
                    authorTypeHidden.value = modelClass; // সঠিক মডেল ক্লাস ব্যবহার করা হলো
                }
            }
        };


        // ==========================================
        // DOM READY
        // ==========================================

        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Blog Form Initializing...');

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
            const editor = document.getElementById('editor');
            const contentInput = document.getElementById('content');
            const seoTitle = document.getElementById('seo-title');
            const seoUrl = document.getElementById('seo-url');
            const seoExcerpt = document.getElementById('seo-excerpt');
            const memberSelect = document.getElementById('member_id');
            const authorSelect = document.getElementById('author_id'); // Main author select

            // Initialize author_id and author_type hidden fields if not already set by old()
            const authorIdHidden = document.querySelector('input[name="author_id"]');
            const authorTypeHidden = document.querySelector('input[name="author_type"]');
            if (!authorIdHidden.value) { // Only set if old() didn't provide a value
                authorIdHidden.value = '{{ auth()->id() }}';
            }
            if (!authorTypeHidden.value) { // Only set if old() didn't provide a value
                authorTypeHidden.value = 'App\\Models\\User';
            }


            // ==========================================
            // FEATURED IMAGE
            // ==========================================

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
                        showNotification('Image selected!', 'success');
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

            // ==========================================
            // TAGS
            // ==========================================

            let tags = [];

            if (tagsHidden && tagsHidden.value) {
                tags = tagsHidden.value.split(',').map(t => t.trim()).filter(t => t);
                updateTagDisplay();
            }

            function addTag(text) {
                const trimmed = text.trim();
                if (trimmed && !tags.includes(trimmed)) {
                    tags.push(trimmed);
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
                    el.innerHTML = `<span>${tag}</span><span class="tag-remove">&times;</span>`;
                    tagContainer.appendChild(el);

                    el.querySelector('.tag-remove').addEventListener('click', () => removeTag(tag));
                });
            }

            window.removeTag = removeTag; // Make globally accessible

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

            // ==========================================
            // SLUG AUTO-GENERATE
            // ==========================================

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

            // ==========================================
            // COUNTERS
            // ==========================================

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

            window.updateCounters = updateCounters; // Make globally accessible

            // ==========================================
            // SEO PREVIEW
            // ==========================================

            function updateSEOPreview() {
                if (seoTitle && titleInput && metaTitleInput) {
                    seoTitle.textContent = metaTitleInput.value || titleInput.value || 'Your Blog Title';
                }
                if (seoUrl && slugInput) {
                    seoUrl.textContent = `yoursite.com/blog/${slugInput.value || 'your-slug'}`;
                }
                if (seoExcerpt && excerptInput && metaDescInput) {
                    seoExcerpt.textContent = metaDescInput.value || excerptInput.value || 'Your excerpt...';
                }
            }

            window.updateSEOPreview = updateSEOPreview; // Make globally accessible

            [excerptInput, metaTitleInput, metaDescInput].forEach(input => {
                if (input) input.addEventListener('input', () => {
                    updateCounters();
                    updateSEOPreview();
                });
            });

            if (slugInput) slugInput.addEventListener('input', updateSEOPreview);

            updateCounters();
            updateSEOPreview();

            // ==========================================
            // EDITOR
            // ==========================================

            function updateWordCount() {
                if (!editor) return;
                const text = editor.innerText || '';
                const words = text.trim().split(/\s+/).filter(w => w.length > 0);
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

            if (editor && contentInput) {
                editor.addEventListener('input', function() {
                    contentInput.value = editor.innerHTML;
                    updateWordCount();
                });

                editor.addEventListener('paste', () => setTimeout(() => {
                    contentInput.value = editor.innerHTML;
                    updateWordCount();
                }, 100));

                editor.addEventListener('keydown', function(e) {
                    if (e.ctrlKey || e.metaKey) {
                        if (e.key === 'b') {
                            e.preventDefault();
                            formatText('bold');
                        }
                        if (e.key === 'i') {
                            e.preventDefault();
                            formatText('italic');
                        }
                        if (e.key === 'u') {
                            e.preventDefault();
                            formatText('underline');
                        }
                        if (e.key === 'k') {
                            e.preventDefault();
                            insertLink();
                        }
                        if (e.key === 'z') {
                            e.preventDefault();
                            formatText(e.shiftKey ? 'redo' : 'undo');
                        }
                    }
                    if (e.key === 'Enter') {
                        setTimeout(() => {
                            contentInput.value = editor.innerHTML;
                            updateWordCount();
                        }, 10);
                    }
                });

                // Handle image clicks in editor
                // Handle image clicks in editor - IMPROVED VERSION
                editor.addEventListener('click', function(e) {
                    // Check if clicked element is an image
                    if (e.target.tagName === 'IMG') {
                        const imageId = e.target.id;

                        // If image has ID and editor-image class, show toolbar
                        if (imageId && imageId.startsWith('img_')) {
                            e.preventDefault();
                            e.stopPropagation();

                            console.log('Image clicked in editor:', imageId); // Debug

                            // Add editor-image class if not present
                            if (!e.target.classList.contains('editor-image')) {
                                e.target.classList.add('editor-image');
                            }

                            // Call selectImage function
                            selectImage(imageId);
                        }
                    }
                });

                updateWordCount();

                const observer = new MutationObserver(() => updateWordCount());
                observer.observe(editor, {
                    childList: true,
                    subtree: true,
                    characterData: true
                });

                if (contentInput.value) {
                    editor.innerHTML = contentInput.value;
                    updateWordCount();
                }
            }

            // ==========================================
            // FORM SUBMISSION
            // ==========================================

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (editor && contentInput) contentInput.value = editor.innerHTML;

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

                    if (editor && (!editor.innerHTML.trim() || editor.innerHTML === '<br>' || editor
                            .innerHTML === '<div><br></div>')) {
                        e.preventDefault();
                        showNotification('Enter blog content', 'error');
                        editor.focus();
                        return;
                    }

                    form.querySelectorAll('button[type="submit"]').forEach(btn => {
                        btn.disabled = true;
                        let originalContent = btn.innerHTML;
                        btn.innerHTML =
                            `<svg class="w-4 h-4 mr-2 animate-spin inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Saving...`;
                    });
                });
            }

            // ==========================================
            // KEYBOARD SHORTCUTS
            // ==========================================

            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    saveDraft();
                }
                if (e.key === 'Escape') {
                    const editorContainer = document.getElementById('editorContainer');
                    if (editorContainer && editorContainer.classList.contains('fullscreen-editor')) {
                        toggleFullscreen();
                    }
                }
            });

            document.addEventListener('click', function(e) {
                // Hide color pickers when clicking outside
                if (!e.target.closest('.relative')) { // Assuming color pickers are inside .relative
                    const colorPicker = document.getElementById('colorPicker');
                    const bgColorPicker = document.getElementById('bgColorPicker');
                    if (colorPicker) colorPicker.classList.add('hidden');
                    if (bgColorPicker) bgColorPicker.classList.add('hidden');
                }
            });

            // Initial focus and notifications
            if (titleInput) titleInput.focus();
            showNotification('Ready to create!', 'success'); // Show initial notification

            console.log('✅ Blog Form Ready!');
        });
    </script>
@endpush
