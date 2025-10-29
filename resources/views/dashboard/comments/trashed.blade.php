@extends('admin-panel::dashboard.layouts.app')

@section('title', 'Trashed Comments - Dashboard')
@section('page-title', 'Blog Management')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <span class="text-gray-400 mx-2">/</span>
    <a href="{{ route('comments.index') }}" class="text-gray-500 hover:text-primary transition-colors">Comments</a>
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
                 <h2 class="text-2xl font-bold mb-1">🗑️ Trashed Comments</h2>
                 <p class="text-red-100 text-lg">Permanently delete or restore soft-deleted user comments.</p>
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
    
    <div class="mb-6 flex justify-end">
        <a href="{{ route('comments.index') }}" 
            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Live Comments
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if ($comments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blog Post</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deleted At</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($comments as $comment)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 line-clamp-3" title="{{ $comment->body }}">
                                        {{ Str::limit($comment->body, 100) }}
                                    </div>
                                    @if($comment->parent_id)
                                        <span class="text-xs text-blue-600">(Reply to #{{ $comment->parent_id }})</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $comment->user->name ?? 'Guest' }}</div>
                                    <div class="text-xs text-gray-500">{{ $comment->user->email ?? '-' }}</div>
                                </td>
                                 <td class="px-6 py-4 whitespace-nowrap">
                                    @if($comment->blog)
                                    <a href="{{ route('frontend.blog.show', $comment->blog->slug) }}" target="_blank" class="text-sm text-blue-600 hover:underline line-clamp-2" title="{{ $comment->blog->title }}">
                                        {{ Str::limit($comment->blog->title, 40) }}
                                    </a>
                                    @else
                                    <span class="text-sm text-gray-400">Blog Deleted</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="text-xs">
                                        <p class="font-semibold text-gray-900">{{ $comment->deleted_at->format('M d, Y') }}</p>
                                        <p class="text-gray-500">{{ $comment->deleted_at->format('h:i A') }}</p>
                                        <p class="text-red-600 mt-1">{{ $comment->deleted_at->diffForHumans() }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <form action="{{ route('comments.restore', $comment->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-3 py-1.5 rounded-lg text-green-600 bg-green-50 hover:bg-green-100 font-semibold text-xs transition-all"
                                                    title="Restore Comment">
                                                Restore
                                            </button>
                                        </form>
                                        
                                        <form id="force-delete-form-{{ $comment->id }}" action="{{ route('comments.force-delete', $comment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                    class="force-delete-btn px-3 py-1.5 rounded-lg text-red-600 bg-red-50 hover:bg-red-100 font-semibold text-xs transition-all"
                                                    data-form-id="force-delete-form-{{ $comment->id }}"
                                                    data-comment-id="{{ $comment->id }}"
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
             <div class="px-6 py-4 border-t border-gray-200">
                {{ $comments->appends(request()->query())->links() }}
            </div>
        @else
             <div class="text-center py-12">
                 <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                 </svg>
                 <h3 class="mt-2 text-sm font-medium text-gray-900">Trash is empty</h3>
                 <p class="mt-1 text-sm text-gray-500">
                     No soft-deleted comments found.
                 </p>
             </div>
        @endif
    </div>

    @include('admin-panel::dashboard.partials.delete_modal', ['modalId' => 'forceDeleteCommentModal'])

@endsection

@push('scripts')
<script>
    // Force delete confirmation modal script
    document.addEventListener('DOMContentLoaded', function() {
        const forceDeleteModal = document.getElementById('deleteModal'); // Assuming general delete modal is re-used
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const cancelModalBtn = document.getElementById('cancelModalBtn');
        const deleteButtons = document.querySelectorAll('.force-delete-btn');
        let formToSubmit = null;

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                formToSubmit = this.getAttribute('data-form-id');
                // You might need to adjust the content of the deleteModal here if needed
                if (forceDeleteModal) {
                    forceDeleteModal.classList.remove('hidden');
                }
            });
        });

        if (confirmDeleteBtn) {
             confirmDeleteBtn.addEventListener('click', function() {
                if (formToSubmit) {
                    document.getElementById(formToSubmit).submit();
                }
            });
        }
       
        if (cancelModalBtn) {
            cancelModalBtn.addEventListener('click', () => {
                if (forceDeleteModal) forceDeleteModal.classList.add('hidden');
                formToSubmit = null;
            });
        }
        
        if (forceDeleteModal) {
            forceDeleteModal.addEventListener('click', e => {
                if (e.target === forceDeleteModal) {
                    forceDeleteModal.classList.add('hidden');
                    formToSubmit = null;
                }
            });
        }
    });
</script>
@endpush