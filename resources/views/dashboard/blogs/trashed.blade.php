@extends('admin-panel::dashboard.layouts.app')

@section('title', 'Trashed Blog Posts - Dashboard')
@section('page-title', 'Blog Management')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <span class="text-gray-400 mx-2">/</span>
    <a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-primary transition-colors">Blog Posts</a>
    <span class="text-gray-400 mx-2">/</span>
    <span class="text-primary font-medium">Trash</span>
@endsection

@section('content')
    <div class="mb-8 bg-gradient-to-r from-red-600 to-orange-600 rounded-xl p-6 text-white shadow-lg">
         <div class="flex items-center space-x-4">
             <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                 <svg class="w-8 h-8 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                 </svg>
             </div>
             <div>
                 <h2 class="text-2xl font-bold mb-1">🗑️ Trashed Blog Posts</h2>
                 <p class="text-red-100 text-lg">Manage deleted blog posts - restore or permanently delete</p>
             </div>
         </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Deleted Posts (Soft-Deleted)</h3>
            <a href="{{ route('blog.index') }}" 
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                 Back to Live Posts
             </a>
        </div>

        @if ($blogs->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Post Details</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category & Author</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deleted At</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($blogs as $blog)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            @if ($blog->image)
                                                <img class="h-16 w-24 rounded-lg object-cover border border-gray-200 opacity-50"
                                                    src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}"
                                                    loading="lazy">
                                            @else
                                                <div
                                                    class="h-16 w-24 rounded-lg bg-gray-200 flex items-center justify-center border border-gray-200 opacity-50">
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
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-gray-900 line-clamp-2" title="{{ $blog->title }}">
                                                {{ $blog->title }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Slug: {{ $blog->slug }}
                                            </p>
                                            <div class="flex items-center space-x-3 text-xs text-gray-500 mt-2">
                                                <span>Views: {{ $blog->views }}</span>
                                                <span>|</span>
                                                <span>Likes: {{ $blog->likes()->count() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <div class="text-sm text-gray-900">{{ $blog->category->name ?? 'Uncategorized' }}</div>
                                        <div class="text-xs text-gray-500">{{ $blog->author->name ?? 'Unknown Author' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="space-y-1">
                                         <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $blog->deleted_at->format('M d, Y') }}</p>
                                         <p class="text-gray-500 dark:text-gray-400">{{ $blog->deleted_at->format('h:i A') }}</p>
                                         <p class="text-red-600 mt-1">{{ $blog->deleted_at->diffForHumans() }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <form action="{{ route('blog.restore', $blog->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-3 py-1.5 rounded-lg text-green-600 bg-green-50 hover:bg-green-100 font-semibold text-xs transition-all"
                                                    title="Restore Post">
                                                Restore
                                            </button>
                                        </form>

                                        <form id="force-delete-form-{{ $blog->id }}" action="{{ route('blog.force-delete', $blog->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="force-delete-btn px-3 py-1.5 rounded-lg text-red-600 bg-red-50 hover:bg-red-100 font-semibold text-xs transition-all"
                                                    data-form-id="force-delete-form-{{ $blog->id }}"
                                                    data-post-title="{{ $blog->title }}"
                                                    title="Permanently Delete">
                                                Delete Forever
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

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
                             {{ $blogs->links() }}
                         </div>
                     </div>
                 </div>
             @endif
        @else
             <div class="text-center py-12">
                 <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                 </svg>
                 <h3 class="mt-2 text-sm font-medium text-gray-900">Trash is empty</h3>
                 <p class="mt-1 text-sm text-gray-500">
                    No blog posts have been soft-deleted yet.
                 </p>
             </div>
        @endif
    </div>

    <div id="forceDeleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full animate-scale-in">
            <div class="p-6">
                <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 text-center mb-2">Permanent Delete</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-6">
                    Are you sure you want to permanently delete post "<span id="postTitleDisplay" class="font-semibold text-gray-900 dark:text-gray-100"></span>"? 
                    <strong class="text-red-600 dark:text-red-400 block mt-2">This action cannot be undone and the featured image will be deleted!</strong>
                </p>
                
                <div class="flex gap-3">
                    <button type="button" id="cancelForceDeleteBtn" 
                            class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 font-semibold transition-colors">
                        Cancel
                    </button>
                    <button type="button" id="confirmForceDeleteBtn" 
                            class="flex-1 px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 font-semibold transition-all shadow-lg">
                        Delete Forever
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Force delete confirmation modal script (Adapted from category logic)
    document.addEventListener('DOMContentLoaded', function() {
        const forceDeleteModal = document.getElementById('forceDeleteModal');
        const cancelForceDeleteBtn = document.getElementById('cancelForceDeleteBtn');
        const confirmForceDeleteBtn = document.getElementById('confirmForceDeleteBtn');
        const postTitleDisplay = document.getElementById('postTitleDisplay');
        const forceDeleteButtons = document.querySelectorAll('.force-delete-btn');
        let formToSubmit = null;

        forceDeleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                formToSubmit = this.getAttribute('data-form-id');
                const postTitle = this.getAttribute('data-post-title');
                postTitleDisplay.textContent = postTitle;
                forceDeleteModal.classList.remove('hidden');
            });
        });

        confirmForceDeleteBtn.addEventListener('click', function() {
            if (formToSubmit) {
                document.getElementById(formToSubmit).submit();
            }
        });

        cancelForceDeleteBtn.addEventListener('click', () => {
            forceDeleteModal.classList.add('hidden');
            formToSubmit = null;
        });

        forceDeleteModal.addEventListener('click', e => {
            if (e.target === forceDeleteModal) {
                forceDeleteModal.classList.add('hidden');
                formToSubmit = null;
            }
        });
    });
</script>
@endpush