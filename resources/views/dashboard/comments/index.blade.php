@extends('admin-panel::dashboard.layouts.app')

@section('title', 'Comments - Dashboard')
@section('page-title', 'Blog Management')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-primary transition-colors">Dashboard</a>
    <span class="text-gray-400 mx-2">/</span>
    <span class="text-primary font-medium">Comments</span>
@endsection

@section('content')
    <div style="background-color: var(--primary);" class="mb-8 bg-gradient-to-r   rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center space-x-4">
             <div >
                 <a href="{{ route('comments.trashed') }}"  class="w-16 h-16 bg-red-600 text-white  rounded-full flex items-center justify-center"
            >
             <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
             </svg>
               
        </a>
             </div>
             <div>
                 <h2 class="text-2xl font-bold mb-1">💬 Comment Management</h2>
                 <p class="text-blue-100 text-lg">Approve, reject, or delete user comments</p>
             </div>
         </div>
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 mb-6">
         <form method="GET" action="{{ route('comments.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-center md:space-x-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200"
                       style="focus:ring-color: #00499b;" placeholder="Search by comment, user, or blog title...">
            </div>

            <div class="md:w-48">
                <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent transition-all duration-200">
                    <option value="pending" {{ request('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="">All Statuses</option>
                </select>
            </div>

            <div class="flex space-x-2">
                 <button type="submit" class="flex items-center px-4 py-3 text-sm font-medium text-white rounded-lg transition-colors hover:bg-opacity-90" style="background-color: var(--primary);">
                    Filter
                 </button>
                 <a href="{{ route('comments.index') }}" class="flex items-center px-4 py-3 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                    Reset
                 </a>
            </div>
         </form>
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
        @if ($comments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blog Post</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($comment->status == 'approved') bg-green-100 text-green-800
                                        @elseif($comment->status == 'rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($comment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $comment->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        @if($comment->status != 'approved')
                                        <form action="{{ route('comments.approve', $comment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Approve">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </form>
                                        @endif
                                        @if($comment->status != 'rejected')
                                        <form action="{{ route('comments.reject', $comment->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="Reject">
                                                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                 </svg>
                 <h3 class="mt-2 text-sm font-medium text-gray-900">No comments found</h3>
                 <p class="mt-1 text-sm text-gray-500">
                     @if(request()->hasAny(['search', 'status']))
                         No comments match your current filters.
                     @else
                         There are currently no comments with the status '{{ request('status', 'pending') }}'.
                     @endif
                 </p>
             </div>
        @endif
    </div>

@endsection