@extends('admin-panel::dashboard.layouts.app')

@section('title', 'Add New Blog Category - Dashboard')
@section('page-title', 'Blog Category Management')

@section('content')
<div class="flex items-center gap-2 mb-6 text-sm">
    <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">Home</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <a href="{{ route('blog-categories.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">Blog Categories</a>
    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-gray-900 dark:text-gray-100 font-semibold">Add New Category</span>
</div>

<div class="relative bg-white dark:bg-gray-900 rounded-3xl shadow-xl overflow-hidden">
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-800 via-indigo-500 to-indigo-800"></div>
    
    <div class="p-8 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Add New Blog Category</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Create a new blog category with details</p>
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

    <form action="{{ route('blog-categories.store') }}" method="POST">
        @csrf
        
        <div class="p-8">
            <div class="max-w-2xl mx-auto">
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border-2 border-gray-200 dark:border-gray-700">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-5">Category Details</h4>
                    
                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="block w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100" 
                                   placeholder="e.g., Technology, Lifestyle, Business" required>
                        </div>
                        
                        <div>
                            <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Slug <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                                   class="block w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100" 
                                   placeholder="e.g., technology, lifestyle, business" required>
                            <p class="text-xs text-gray-500 mt-1">URL-friendly version of the name (auto-generated).</p>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" class="block w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100">
                                <option value="Active" @if(old('status', 'Active') == 'Active') selected @endif>Active</option>
                                <option value="Inactive" @if(old('status') == 'Inactive') selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
            <a href="{{ route('blog-categories.index') }}" class="px-6 py-3 rounded-xl text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 font-semibold transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 rounded-xl text-white font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                Create Category
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

        nameInput.addEventListener('keyup', function () {
            const nameValue = this.value.trim();
            slugInput.value = nameValue
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-')         // Replace spaces with hyphens
                .replace(/-+/g, '-');         // Replace multiple hyphens with one
        });
    });
</script>
@endpush