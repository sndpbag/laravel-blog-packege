@extends('admin-panel::dashboard.layouts.app')

@section('title', 'Trashed Categories - Dashboard')
@section('page-title', 'Blog Management')

@section('content')
    <div class="flex items-center gap-2 mb-6 text-sm">
        <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">Home</a>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <a href="{{ route('blog-categories.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">Blog Categories</a>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 dark:text-gray-100 font-semibold">Trash</span>
    </div>

    <div class="relative bg-white dark:bg-gray-900 rounded-3xl shadow-xl overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-500 via-red-500 to-pink-500"></div>

        <div class="p-8 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">Trashed Categories</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage deleted blog categories - restore or permanently delete</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('blog-categories.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 font-semibold transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back to Categories
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mx-8 mt-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-l-4 border-green-500 rounded-xl shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-green-800 dark:text-green-300 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-8 mt-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-l-4 border-red-500 rounded-xl shadow-sm">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-red-800 dark:text-red-300 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($categories->total() > 0)
            <div class="p-8 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/10 dark:to-red-900/10 border-b border-orange-200 dark:border-orange-800">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <p class="text-sm font-semibold text-orange-900 dark:text-orange-300">Items in trash will be permanently deleted after 30 days</p>
                        <p class="text-xs text-orange-700 dark:text-orange-400 mt-1">You can restore or permanently delete items before that time.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 border-y border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Category Info</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Slug</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Total Blogs</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Deleted At</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white font-bold text-sm ring-2 ring-gray-200 dark:ring-gray-700 opacity-60">
                                        {{ strtoupper(substr($category->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm text-gray-900 dark:text-gray-100">{{ $category->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">ID: #{{ str_pad($category->id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">{{ $category->slug }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $category->blogs_count ?? 0 }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-xs">
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $category->deleted_at->format('M d, Y') }}</p>
                                    <p class="text-gray-500 dark:text-gray-400">{{ $category->deleted_at->format('h:i A') }}</p>
                                    <p class="text-orange-600 dark:text-orange-400 mt-1">{{ $category->deleted_at->diffForHumans() }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1.5">
                                    <form action="{{ route('blog-categories.restore', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="px-3 py-1.5 rounded-lg text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 font-semibold text-xs transition-all">
                                            Restore
                                        </button>
                                    </form>
                                    <form id="force-delete-form-{{ $category->id }}" action="{{ route('blog-categories.force-delete', $category->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="force-delete-btn px-3 py-1.5 rounded-lg text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 font-semibold text-xs transition-all"
                                                data-form-id="force-delete-form-{{ $category->id }}"
                                                data-category-name="{{ $category->name }}">
                                            Delete Forever
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <p class="font-bold text-xl text-gray-700 dark:text-gray-300">Trash is Empty</p>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">No deleted categories found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="p-8 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Force Delete Confirmation Modal -->
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
                    Are you sure you want to permanently delete "<span id="categoryNameDisplay" class="font-semibold text-gray-900 dark:text-gray-100"></span>"? 
                    <strong class="text-red-600 dark:text-red-400 block mt-2">This action cannot be undone!</strong>
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
    // Force delete confirmation modal script
    document.addEventListener('DOMContentLoaded', function() {
        const forceDeleteModal = document.getElementById('forceDeleteModal');
        const cancelForceDeleteBtn = document.getElementById('cancelForceDeleteBtn');
        const confirmForceDeleteBtn = document.getElementById('confirmForceDeleteBtn');
        const categoryNameDisplay = document.getElementById('categoryNameDisplay');
        const forceDeleteButtons = document.querySelectorAll('.force-delete-btn');
        let formToSubmit = null;

        forceDeleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                formToSubmit = this.getAttribute('data-form-id');
                const categoryName = this.getAttribute('data-category-name');
                categoryNameDisplay.textContent = categoryName;
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