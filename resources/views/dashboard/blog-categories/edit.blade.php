@extends('admin-panel::dashboard.layouts.app')

@section('title', 'Edit Category - Dashboard')
@section('page-title', 'Blog Category Management')

@section('content')
<div class="flex items-center gap-2 mb-6 text-sm">
    <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">Home</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('blog-categories.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">Blog Categories</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-gray-900 dark:text-gray-100 font-semibold">Edit Category</span>
</div>

<div class="relative bg-white dark:bg-gray-900 rounded-3xl shadow-xl overflow-hidden">
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-800 via-indigo-500 to-indigo-800"></div>
    
    <div class="p-8 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl  flex items-center justify-center shadow-lg" style="background-color: var(--primary);">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Edit Category</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update category information</p>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="mx-8 mt-6 p-5 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-l-4 border-red-500 rounded-xl shadow-sm">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="flex-1">
                    <h4 class="text-red-800 dark:text-red-300 font-semibold mb-2">Please fix the following errors:</h4>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-700 dark:text-red-400 text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('blog-categories.update', $blogCategory->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="p-8">
            <div class="max-w-2xl mx-auto">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border-2 border-gray-200 dark:border-gray-700">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-5">Category Details</h4>
                    
                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $blogCategory->name) }}" 
                                   class="block w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100" 
                                   placeholder="e.g., Technology, Lifestyle, Business" required>
                        </div>
                        
                        <div>
                            <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $blogCategory->slug) }}" 
                                   class="block w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100" 
                                   placeholder="e.g., technology, lifestyle, business" required>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">URL-friendly version of the name (auto-generated).</p>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" class="block w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100">
                                <option value="Active" @if(old('status', $blogCategory->status) == 'Active') selected @endif>Active</option>
                                <option value="Inactive" @if(old('status', $blogCategory->status) == 'Inactive') selected @endif>Inactive</option>
                            </select>
                        </div>

                        @if($blogCategory->blogs_count > 0)
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-300">This category has {{ $blogCategory->blogs_count }} blog(s) associated with it.</p>
                                    <p class="text-xs text-blue-700 dark:text-blue-400 mt-1">Changing the category details will affect all associated blogs.</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                        <div>
                            <span class="font-semibold">Created:</span> {{ $blogCategory->created_at->format('M d, Y - h:i A') }}
                        </div>
                        <div>
                            <span class="font-semibold">Last Updated:</span> {{ $blogCategory->updated_at->format('M d, Y - h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
            <a href="{{ route('blog-categories.index') }}" class="px-6 py-3 rounded-xl text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 font-semibold transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl text-white font-semibold   hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl" style="background-color: var(--primary);">
                Update Category
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        let manualSlugEdit = false;

        // Check if user manually edited the slug
        slugInput.addEventListener('input', function() {
            manualSlugEdit = true;
        });

        nameInput.addEventListener('keyup', function () {
            // Only auto-generate slug if user hasn't manually edited it
            if (!manualSlugEdit) {
                const nameValue = this.value.trim();
                slugInput.value = nameValue
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-')         // Replace spaces with hyphens
                    .replace(/-+/g, '-');         // Replace multiple hyphens with one
            }
        });
    });
</script>
@endpush