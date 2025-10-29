@extends('admin-panel::dashboard.layouts.app')

@section('title', 'Blog Categories - Dashboard')
@section('page-title', 'Blog Management')




@section('content')
    <div class="flex items-center gap-2 mb-6 text-sm">
        <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">Home</a>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        <span class="text-gray-900 dark:text-gray-100 font-semibold">Blog Categories</span>
    </div>

    <div class="relative bg-white dark:bg-gray-900 rounded-3xl shadow-xl overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

        <div class="p-8 border-b border-gray-100 dark:border-gray-800">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">Blog Category Management</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage all blog categories and their content</p>
                </div>
                <div class="flex flex-col md:flex-row gap-2">
                    <a href="{{ route('blog-categories.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl text-white font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200   hover:from-indigo-700 hover:to-purple-700" style="background-color: var(--primary);">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                        Add New Category
                    </a>
                    <a href="{{ route('blog-categories.trashed') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-xl bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 hover:bg-orange-100 dark:hover:bg-orange-900/30 font-medium transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        View Trash
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

        <div class="p-8 bg-gradient-to-b from-gray-50 to-white dark:from-gray-800 dark:to-gray-900">
            <form action="{{ route('blog-categories.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-8 relative">
                    <input type="text" name="search" placeholder="Search by name or slug..." 
                           class="w-full pl-4 pr-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100" 
                           value="{{ request('search') }}">
                </div>
                <div class="md:col-span-4 relative">
                    <select name="status" class="w-full px-4 py-3.5 border-2 border-gray-200 dark:border-gray-700 rounded-2xl appearance-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100">
                        <option value="all">All Statuses</option>
                        <option value="Active" @if (request('status') == 'Active') selected @endif>Active</option>
                        <option value="Inactive" @if (request('status') == 'Inactive') selected @endif>Inactive</option>
                    </select>
                </div>
                <div class="md:col-span-12 flex justify-end gap-3">
                    <a href="{{ route('blog-categories.index') }}" class="px-6 py-3 rounded-xl text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 font-semibold transition-colors">Clear Filters</a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white font-semibold   hover:from-indigo-700 hover:to-purple-700 transition-all" style="background-color: var(--primary);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 border-y border-gray-200 dark:border-gray-700">
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Category Info</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Slug</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Total Blogs</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl   flex items-center justify-center text-white font-bold text-sm ring-2 ring-indigo-100 dark:ring-indigo-900" style="background-color: var(--primary);">
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
                                <form action="{{ route('blog-categories.toggleStatus', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all
                                        @if ($category->status == 'Active') 
                                            bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30
                                        @else 
                                            bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700
                                        @endif">
                                        <span class="w-1.5 h-1.5 rounded-full @if($category->status == 'Active') bg-green-500 @else bg-gray-400 @endif"></span>
                                        {{ $category->status }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('blog-categories.edit', $category->id) }}" 
                                       class="px-3 py-1.5 rounded-lg text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 font-semibold text-xs transition-all">
                                        Edit
                                    </a>
                                    <form id="delete-form-{{ $category->id }}" action="{{ route('blog-categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="delete-btn px-3 py-1.5 rounded-lg text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 font-semibold text-xs transition-all"
                                                data-form-id="delete-form-{{ $category->id }}">
                                            Delete
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <p class="font-bold text-xl text-gray-700 dark:text-gray-300">No Categories Found</p>
                                    <p class="text-gray-500 dark:text-gray-400 mt-1">Try adjusting your filters or add a new category.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
            {{ $categories->withQueryString()->links() }}
        </div>
    </div>

    @include('admin-panel::dashboard.partials.delete_modal')
@endsection

@push('scripts')
<script>
    // Delete confirmation modal script
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        const cancelModalBtn = document.getElementById('cancelModalBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteButtons = document.querySelectorAll('.delete-btn');
        let formToSubmit = null;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                formToSubmit = this.getAttribute('data-form-id');
                deleteModal.classList.remove('hidden');
            });
        });

        confirmDeleteBtn.addEventListener('click', function() {
            if (formToSubmit) {
                document.getElementById(formToSubmit).submit();
            }
        });

        cancelModalBtn.addEventListener('click', () => deleteModal.classList.add('hidden'));
        deleteModal.addEventListener('click', e => {
            if (e.target === deleteModal) deleteModal.classList.add('hidden');
        });
    });
</script>
@endpush