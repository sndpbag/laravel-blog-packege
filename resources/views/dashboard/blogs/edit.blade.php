@extends('admin-panel::dashboard.layouts.app')

@section('title', 'Edit Blog Post - Dashboard')
@section('page-title', 'Blog Management')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <span class="text-gray-400 mx-2">/</span>
    <a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-primary transition-colors">Blog Posts</a>
    <span class="text-gray-400 mx-2">/</span>
    <span class="text-primary font-medium">Edit Post</span>
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
        style="background-color: var(--primary);">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-1">✍️ Edit Blog Post</h2>
                    <p class="text-blue-100 text-lg">Update the content and settings for your blog post.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <form id="blogForm" action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Hidden Fields -->
        <input type="hidden" name="word_count" id="word_count_hidden">
        <input type="hidden" name="reading_time" id="reading_time_hidden">
        <input type="hidden" name="author_type" value="Sndpbag\AdminPanel\Models\User">
        {{-- <input type="hidden" name="author_type" value="App\Models\User"> --}}
        <input type="hidden" name="author_id" value="{{ $blog->author_id }}">


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
                        src="{{ asset('storage/' . $blog->image) }}"
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
                    <input type="file" id="imageInput" name="image" accept="image/*" class="hidden">
                </div>

                 <p class="text-xs text-gray-500 mt-1">Upload a new image to replace the current one.</p>

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
                            <input type="text" id="title" name="title" value="{{ old('title', $blog->title) }}" required
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
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $blog->slug) }}" required
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
                                style="focus:ring-color: #00499b;" placeholder="Brief description of the blog post...">{{ old('excerpt', $blog->excerpt) }}</textarea>
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
                                <input type="hidden" id="tags" name="tags" value="{{ old('tags', $blog->tags) }}">
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
                                <button type="button" onclick="formatText('italic')" class="toolbar-btn" title="Italic">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4L6 20m8-16l-4 16">
                                        </path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('underline')" class="toolbar-btn" title="Underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="formatText('strikeThrough')" class="toolbar-btn" title="Strikethrough">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8h12M6 16h12M8 12h8">
                                        </path>
                                    </svg>
                                </button>

                                <div class="border-l border-gray-400 mx-1"></div>

                                <!-- Font Size -->
                                <select onchange="changeFontSize(this.value)" class="text-xs px-2 py-1 border rounded bg-white">
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
                                    <button type="button" onclick="toggleColorPicker()" class="toolbar-btn" title="Text Color">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3H5a2 2 0 00-2 2v12a4 4 0 004 4h2a2 2 0 002-2V5a2 2 0 00-2-2z">
                                            </path>
                                        </svg>
                                    </button>
                                    <div id="colorPicker" class="hidden absolute top-8 left-0 bg-white border rounded-lg p-2 z-10 shadow-lg">
                                        <div class="grid grid-cols-6 gap-1">
                                            <button type="button" onclick="setTextColor('#000000')" class="w-6 h-6 rounded border"
                                                style="background-color: #000000" title="Black"></button>
                                            <button type="button" onclick="setTextColor('#FF0000')" class="w-6 h-6 rounded border"
                                                style="background-color: #FF0000" title="Red"></button>
                                            <button type="button" onclick="setTextColor('#00FF00')" class="w-6 h-6 rounded border"
                                                style="background-color: #00FF00" title="Green"></button>
                                            <button type="button" onclick="setTextColor('#0000FF')" class="w-6 h-6 rounded border"
                                                style="background-color: #0000FF" title="Blue"></button>
                                            <button type="button" onclick="setTextColor('#FFFF00')" class="w-6 h-6 rounded border"
                                                style="background-color: #FFFF00" title="Yellow"></button>
                                            <button type="button" onclick="setTextColor('#FF00FF')" class="w-6 h-6 rounded border"
                                                style="background-color: #FF00FF" title="Magenta"></button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Background Color -->
                                <div class="relative">
                                    <button type="button" onclick="toggleBgColorPicker()" class="toolbar-btn" title="Background Color">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4z"></path>
                                        </svg>
                                    </button>
                                    <div id="bgColorPicker" class="hidden absolute top-8 left-0 bg-white border rounded-lg p-2 z-10 shadow-lg">
                                        <div class="grid grid-cols-6 gap-1">
                                            <button type="button" onclick="setBgColor('transparent')" class="w-6 h-6 rounded border bg-white" title="No Background"></button>
                                            <button type="button" onclick="setBgColor('#FFFF00')" class="w-6 h-6 rounded border" style="background-color: #FFFF00" title="Yellow"></button>
                                            <button type="button" onclick="setBgColor('#00FF00')" class="w-6 h-6 rounded border" style="background-color: #00FF00" title="Green"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2: Structure -->
                            <div class="flex flex-wrap gap-1 mb-2">
                                <select onchange="formatHeading(this.value)" class="text-xs px-2 py-1 border rounded bg-white">
                                    <option value="">Heading</option>
                                    <option value="H1">Heading 1</option>
                                    <option value="H2">Heading 2</option>
                                    <option value="H3">Heading 3</option>
                                </select>

                                <div class="border-l border-gray-400 mx-1"></div>

                                <button type="button" onclick="formatText('insertUnorderedList')" class="toolbar-btn" title="Bullet List">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                </button>
                                <button type="button" onclick="formatText('insertOrderedList')" class="toolbar-btn" title="Numbered List">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </button>

                                <div class="border-l border-gray-400 mx-1"></div>
                                
                                <button type="button" onclick="formatText('justifyLeft')" class="toolbar-btn" title="Align Left">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"></path></svg>
                                </button>
                                <button type="button" onclick="formatText('justifyCenter')" class="toolbar-btn" title="Align Center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M8 12h8M4 18h16"></path></svg>
                                </button>
                                <button type="button" onclick="formatText('justifyRight')" class="toolbar-btn" title="Align Right">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 6H4m16 6h-8m8 6H4"></path></svg>
                                </button>
                            </div>

                            <!-- Row 3: Media & Advanced -->
                            <div class="flex flex-wrap gap-1">
                                <button type="button" onclick="insertLink()" class="toolbar-btn" title="Insert Link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </button>
                                <button type="button" onclick="formatText('unlink')" class="toolbar-btn" title="Remove Link">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>

                                <div class="border-l border-gray-400 mx-1"></div>

                                <label for="contentImageInput" class="toolbar-btn cursor-pointer" title="Insert Image">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <input type="file" id="contentImageInput" accept="image/*" class="hidden" onchange="insertImage(this)">
                                </label>
                                
                                <div class="border-l border-gray-400 mx-1"></div>

                                <button type="button" onclick="formatText('undo')" class="toolbar-btn" title="Undo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                </button>
                                <button type="button" onclick="formatText('redo')" class="toolbar-btn" title="Redo">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2m18-10l-6 6m6-6l-6-6"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Rich Text Editor -->
                        <div id="editorContainer" class="border border-gray-300 border-t-0 rounded-b-lg">
                            <div id="editor" contenteditable="true"
                                class="w-full min-h-96 px-4 py-3 border-0 bg-white focus:ring-0 focus:outline-none"
                                style="max-height: 500px; overflow-y: auto;"
                                data-placeholder="Write your blog content here...">{!! old('content', $blog->content) !!}</div>
                            <textarea id="content" name="content" class="hidden" required>{{ old('content', $blog->content) }}</textarea>
                        </div>

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
                                        {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
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
                                Author
                            </label>
                            <select id="member_id" name="member_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200">
                                <option value="{{ auth()->id() }}" {{ old('member_id', $blog->author_id) == auth()->id() ? 'selected' : '' }}>Current User ({{ auth()->user()->name }})</option>
                                @foreach ($members ?? [] as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id', $blog->author_id) == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
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
                                value="{{ old('published_date', \Carbon\Carbon::parse($blog->published_date)->format('Y-m-d')) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200">
                        </div>

                        <!-- Is Featured Toggle -->
                        <div class="space-y-2">
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="checkbox" name="is_featured" value="1"
                                    {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}
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
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}"
                                maxlength="60"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200"
                                placeholder="SEO optimized title">
                            <div class="flex justify-between text-xs mt-1">
                                <p class="text-gray-500">Leave empty to use blog title</p>
                                <div id="metaTitleCounter" class="text-gray-400">0/60 chars</div>
                            </div>
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
                                placeholder="Brief description for search engines...">{{ old('meta_description', $blog->meta_description) }}</textarea>
                            <div class="flex justify-between text-xs mt-1">
                                <p class="text-gray-500">Leave empty to use excerpt</p>
                                <div id="metaDescCounter" class="text-gray-400">0/160 chars</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between p-6 bg-gray-50 rounded-xl border border-gray-200">
            <a href="{{ route('blog.index') }}"
                class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <div class="flex items-center space-x-3">
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
                    style="background-color: var(--primary);">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                    Update Blog
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
        .toolbar-btn {
            padding: 6px 8px; border: 1px solid #d1d5db; background: white; border-radius: 4px; cursor: pointer; transition: all 0.2s ease;
            color: #374151; font-size: 12px; display: flex; align-items: center; justify-content: center; min-width: 32px; height: 32px;
        }
        .toolbar-btn:hover { background: #f3f4f6; border-color: #9ca3af; }
        .toolbar-btn:active, .toolbar-btn.active { background: var(--primary-blue); color: white; border-color: var(--light-blue); }
        #editor { outline: none; }
        #editor:empty::before { content: attr(data-placeholder); color: #9ca3af; font-style: italic; }
        #editor h1, #editor h2, #editor h3, #editor h4, #editor h5, #editor h6 { font-weight: bold; margin: 16px 0 8px 0; }
        #editor h1 { font-size: 2em; } #editor h2 { font-size: 1.5em; } #editor h3 { font-size: 1.3em; }
        #editor ul, #editor ol { margin: 8px 0; padding-left: 24px; }
        #editor li { margin: 4px 0; } #editor a { color: #3b82f6; text-decoration: underline; }
        #editor p { margin: 8px 0; }
        .tag-item { background: linear-gradient(135deg, var(--primary-blue), var(--light-blue)); color: white; padding: 4px 12px;
            border-radius: 20px; font-size: 12px; display: flex; align-items: center; gap: 6px; }
        .tag-remove { cursor: pointer; background: rgba(255, 255, 255, 0.3); border-radius: 50%; width: 16px; height: 16px;
            display: flex; align-items: center; justify-content: center; font-size: 10px; }
        .tag-remove:hover { background: rgba(255, 255, 255, 0.5); }
        .dropzone { border: 2px dashed #60a5fa; border-radius: 12px; transition: all 0.3s ease; }
        .dropzone:hover { border-color: var(--primary-blue); background: linear-gradient(135deg, rgba(0, 73, 155, 0.05), rgba(30, 91, 184, 0.05)); }
        .form-section { animation: fadeInUp 0.6s ease-out; animation-fill-mode: both; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        #editor img { max-width: 100%; height: auto; border-radius: 8px; margin: 16px auto; display: block; cursor: pointer;
            transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); }
        #editor img:hover { transform: scale(1.02); box-shadow: 0 4px 16px rgba(0, 73, 155, 0.2); }
        #editor img.selected { outline: 3px solid #00499b; outline-offset: 2px; }
        #editor table { border-collapse: collapse; width: 100%; margin: 20px 0; background: white; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 8px; overflow: hidden; }
        #editor table th { background: linear-gradient(135deg, #00499b, #1e5bb8); color: white; padding: 12px; text-align: left; font-weight: 600; }
        #editor table td { padding: 12px; border: 1px solid #e5e7eb; }
        #editor pre { background: #1e293b; color: #e2e8f0; padding: 20px; border-radius: 8px; overflow-x: auto;
            font-family: 'Courier New', monospace; font-size: 14px; line-height: 1.5; margin: 20px 0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); }
        #editor blockquote { border-left: 4px solid #00499b; background: linear-gradient(to right, #f0f7ff, #ffffff);
            padding: 16px 24px; margin: 20px 0; font-style: italic; border-radius: 0 8px 8px 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); }
        #imageToolbar .toolbar-btn { min-width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
        #imageToolbar .toolbar-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0, 73, 155, 0.2); }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==========================================
            // GLOBAL HELPER FUNCTIONS
            // ==========================================
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 z-50 max-w-md animate-slide-in';
                const bgColor = { 'success': 'bg-green-500', 'error': 'bg-red-500', 'warning': 'bg-yellow-500', 'info': 'bg-blue-500' }[type] || 'bg-blue-500';
                const icons = { 'success': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>', 'error': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>', 'warning': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>', 'info': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>' };
                notification.innerHTML = `<div class="${bgColor} text-white p-4 rounded-lg shadow-lg flex items-center"><svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icons[type]}</svg><span class="flex-1">${message}</span><button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200 flex-shrink-0"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>`;
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 5000);
            }

            function showConfirmationModal(title, message, onConfirm) {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-[9999]';
                modal.innerHTML = `<div class="bg-white rounded-lg shadow-xl p-6 max-w-sm mx-auto animate-scale-in"><h3 class="text-lg font-semibold text-gray-900 mb-4">${title}</h3><p class="text-gray-700 mb-6">${message}</p><div class="flex justify-end space-x-3"><button id="cancelBtn" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</button><button id="confirmBtn" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">Confirm</button></div></div>`;
                document.body.appendChild(modal);
                document.getElementById('cancelBtn').addEventListener('click', () => modal.remove());
                document.getElementById('confirmBtn').addEventListener('click', () => { onConfirm(); modal.remove(); });
            }

            function showPromptModal(title, message, onConfirm) {
                let savedRange = null;
                if (window.getSelection) { const sel = window.getSelection(); if (sel.getRangeAt && sel.rangeCount) { savedRange = sel.getRangeAt(0); } }
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-[9999]';
                modal.innerHTML = `<div class="bg-white rounded-lg shadow-xl p-6 max-w-sm mx-auto" style="animation: scaleIn 0.2s ease-out;"><h3 class="text-lg font-semibold text-gray-900 mb-4">${title}</h3><p class="text-gray-700 mb-2">${message}</p><input id="promptInput" type="url" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 mb-6" placeholder="https://example.com"><div class="flex justify-end space-x-3"><button id="cancelBtn" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Cancel</button><button id="confirmBtn" type="button" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">Confirm</button></div></div>`;
                document.body.appendChild(modal);
                const inputField = document.getElementById('promptInput'); inputField.focus();
                const closeModal = () => modal.remove();
                const confirmAction = () => { if (savedRange && window.getSelection) { const sel = window.getSelection(); sel.removeAllRanges(); sel.addRange(savedRange); } onConfirm(inputField.value); closeModal(); };
                inputField.addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); confirmAction(); } });
                document.getElementById('cancelBtn').addEventListener('click', closeModal);
                document.getElementById('confirmBtn').addEventListener('click', confirmAction);
            }

            // ==========================================
            // RICH TEXT EDITOR FUNCTIONS
            // ==========================================
            window.formatText = (command, value = null) => { document.execCommand(command, false, value); editor.focus(); };
            window.formatHeading = (tag) => { if (tag) formatText('formatBlock', tag); };
            window.changeFontSize = (size) => { if (size) formatText('fontSize', size); };
            window.insertLink = () => { showPromptModal('Insert Link', 'Enter URL:', (url) => { if (url) { if (!url.startsWith('http')) url = 'https://' + url; formatText('createLink', url); } }); };
            window.toggleColorPicker = () => document.getElementById('colorPicker').classList.toggle('hidden');
            window.toggleBgColorPicker = () => document.getElementById('bgColorPicker').classList.toggle('hidden');
            window.setTextColor = (color) => { formatText('foreColor', color); document.getElementById('colorPicker').classList.add('hidden'); };
            window.setBgColor = (color) => { formatText('hiliteColor', color); document.getElementById('bgColorPicker').classList.add('hidden'); };

            window.insertImage = function(input) {
                const file = input.files[0];
                if (!file) return;
                if (!file.type.startsWith('image/')) return showNotification('Please select an image file', 'error');
                if (file.size > 5 * 1024 * 1024) return showNotification('Image must be less than 5MB', 'error');

                const imageId = 'img_' + Date.now();
                const tempSrc = URL.createObjectURL(file);
                const imgHtml = `<p><img src="${tempSrc}" id="${imageId}" class="editor-image uploading" style="max-width: 100%; height: auto; opacity: 0.5;" alt="Uploading..."></p>`;
                document.execCommand('insertHTML', false, imgHtml);

                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('blog.uploadContentImage') }}', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        const imgElement = document.getElementById(imageId);
                        if (data.url && imgElement) {
                            imgElement.src = data.url;
                            imgElement.style.opacity = 1;
                            imgElement.classList.remove('uploading');
                            contentInput.value = editor.innerHTML;
                        } else {
                            imgElement.parentElement.remove();
                            showNotification(data.error || 'Upload failed', 'error');
                        }
                    }).catch(() => {
                        document.getElementById(imageId)?.parentElement.remove();
                        showNotification('Upload failed', 'error');
                    });
                input.value = '';
            };

            let selectedImage = null; let currentToolbar = null;
            function showImageToolbar(imgElement) {
                if (currentToolbar) currentToolbar.remove();
                const toolbar = document.createElement('div');
                toolbar.id = 'imageToolbar';
                toolbar.className = 'image-toolbar-popup';
                toolbar.style.cssText = `position: fixed; background: white; border-radius: 12px; padding: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.25); display: flex; gap: 8px; z-index: 10000; animation: slideDown 0.3s ease;`;
                toolbar.innerHTML = `<div style="display: flex; gap: 4px;"><button type="button" onclick="resizeImage('${imgElement.id}', 'small')" class="toolbar-btn">S</button><button type="button" onclick="resizeImage('${imgElement.id}', 'medium')" class="toolbar-btn">M</button><button type="button" onclick="resizeImage('${imgElement.id}', 'large')" class="toolbar-btn">L</button></div><div style="display: flex; gap: 4px;"><button type="button" onclick="alignImage('${imgElement.id}', 'left')" class="toolbar-btn">Left</button><button type="button" onclick="alignImage('${imgElement.id}', 'center')" class="toolbar-btn">Center</button><button type="button" onclick="alignImage('${imgElement.id}', 'right')" class="toolbar-btn">Right</button></div><button type="button" onclick="deleteImage('${imgElement.id}')" class="toolbar-btn" style="color:red;">Delete</button>`;
                document.body.appendChild(toolbar);
                currentToolbar = toolbar;
                const rect = imgElement.getBoundingClientRect();
                let top = rect.top - toolbar.offsetHeight - 10;
                let left = rect.left + rect.width / 2 - toolbar.offsetWidth / 2;
                if (top < 10) top = rect.bottom + 10;
                if (left < 10) left = 10;
                if (left + toolbar.offsetWidth > window.innerWidth - 10) left = window.innerWidth - toolbar.offsetWidth - 10;
                toolbar.style.top = `${top}px`;
                toolbar.style.left = `${left}px`;
            }
            window.resizeImage = (id, size) => { const img = document.getElementById(id); if(img) { img.style.width = {small:'25%',medium:'50%',large:'100%'}[size]; contentInput.value = editor.innerHTML; setTimeout(() => showImageToolbar(img), 50); }};
            window.alignImage = (id, align) => { const img = document.getElementById(id); if(img) { const p = img.closest('p'); if(p) p.style.textAlign = align; contentInput.value = editor.innerHTML; }};
            window.deleteImage = (id) => { showConfirmationModal('Delete Image?', 'Are you sure?', () => { const img = document.getElementById(id); if(img) { img.closest('p')?.remove(); if(currentToolbar) currentToolbar.remove(); contentInput.value = editor.innerHTML; } }); };
            document.addEventListener('click', (e) => { if(!e.target.closest('.editor-image') && !e.target.closest('#imageToolbar')) { if(currentToolbar) currentToolbar.remove(); document.querySelectorAll('.editor-image.selected').forEach(el => el.classList.remove('selected')); }});

            // ==========================================
            // INITIALIZATION
            // ==========================================
            const form = document.getElementById('blogForm');
            const fileInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
            const tagsInput = document.getElementById('tagsInput');
            const tagsHidden = document.getElementById('tags');
            const tagContainer = document.getElementById('tagContainer');
            const editor = document.getElementById('editor');
            const contentInput = document.getElementById('content');

            // Image Preview
            fileInput.addEventListener('change', e => { if(e.target.files[0]) { const reader = new FileReader(); reader.onload = e => imagePreview.src = e.target.result; reader.readAsDataURL(e.target.files[0]); }});

            // Slug generation
            titleInput.addEventListener('input', () => { slugInput.value = titleInput.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').slice(0, 200); });

            // Tags
            let tags = tagsHidden.value ? tagsHidden.value.split(',').filter(Boolean) : [];
            const updateTagDisplay = () => { tagContainer.innerHTML = tags.map(tag => `<div class="tag-item"><span>${tag}</span><span class="tag-remove" onclick="removeTag('${tag}')">&times;</span></div>`).join(''); tagsHidden.value = tags.join(','); };
            window.removeTag = (tag) => { tags = tags.filter(t => t !== tag); updateTagDisplay(); };
            tagsInput.addEventListener('keydown', e => { if(e.key === 'Enter' || e.key === ',') { e.preventDefault(); if(tagsInput.value.trim() && !tags.includes(tagsInput.value.trim())) { tags.push(tagsInput.value.trim()); } tagsInput.value = ''; updateTagDisplay(); }});
            updateTagDisplay();

            // Editor sync and word count
            const updateWordCount = () => {
                const text = editor.innerText.trim();
                const wordCount = text ? text.split(/\s+/).length : 0;
                document.getElementById('wordCount').textContent = wordCount;
                document.getElementById('charCount').textContent = text.length;
                document.getElementById('word_count_hidden').value = wordCount;
                document.getElementById('reading_time_hidden').value = Math.ceil(wordCount / 200) || 1;
            };
            editor.addEventListener('input', () => { contentInput.value = editor.innerHTML; updateWordCount(); });
            if (contentInput.value) { editor.innerHTML = contentInput.value; }
            updateWordCount();

            // Editor image click
            editor.addEventListener('click', (e) => {
                if(e.target.tagName === 'IMG' && e.target.classList.contains('editor-image')){
                    e.stopPropagation();
                    document.querySelectorAll('.editor-image.selected').forEach(el => el.classList.remove('selected'));
                    e.target.classList.add('selected');
                    showImageToolbar(e.target);
                }
            });

            // Form submission
            form.addEventListener('submit', () => { contentInput.value = editor.innerHTML; });
        });
    </script>
@endpush

