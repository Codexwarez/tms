@extends('layouts.app')
@section('content')
    <div class="space-y-6">

        {{-- Project Header --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                {{ $project->name }}
            </h1>
            <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $project->description }}</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-semibold text-gray-700 dark:text-gray-200">Assigned To:</span>
                    <span class="text-gray-800 dark:text-gray-300">{{ $project->assignedUser?->name ?? '—' }}</span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700 dark:text-gray-200">Status:</span>
                    <span class="px-2 py-1 text-xs rounded bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200">
                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                    </span>
                </div>
                <div>
                    <span class="font-semibold text-gray-700 dark:text-gray-200">Due At:</span>
                    <span
                        class="text-gray-800 dark:text-gray-300">{{ optional($project->due_at)->format('M d, Y H:i') ?? '—' }}</span>
                </div>
            </div>
        </div>
        <div class="mb-4">
            <p><strong>Priority:</strong>
                <span class="px-2 py-1 rounded {{ $project->priority_badge_class }}">
                    {{ $project->priority }}
                </span>
            </p>
        </div>

        <div class="mb-4">
            <p><strong>Progress:</strong></p>
            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                <div class="h-2 rounded-full bg-blue-500" style="width: {{ $project->progress }}%"></div>
            </div>
            <span class="text-xs text-gray-500">{{ $project->progress_percent }}</span>
        </div>


        {{-- File Upload + List --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">Project Files</h2>

            {{-- Upload Form --}}
            <form action="{{ route('project-files.store') }}" method="POST" enctype="multipart/form-data"
                class="mb-4 flex items-center gap-3">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <input type="file" name="file" required
                    class="block w-full text-sm text-gray-900 dark:text-gray-200
                    file:mr-3 file:py-2 file:px-3
                    file:rounded-lg file:border-0
                    file:text-sm file:font-semibold
                    file:bg-gray-900 file:text-white
                    hover:file:bg-gray-700
                    dark:file:bg-gray-200 dark:file:text-gray-900">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
                    Upload
                </button>
            </form>

            {{-- File List --}}
            @if ($project->files->count())
                <ul class="space-y-2">
                    @foreach ($project->files as $file)
                        <li class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <span class="text-gray-800 dark:text-gray-200">{{ $file->file_name }}</span>
                            <a href="{{ route('project-files.download', $file) }}"
                                class="px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Download
                            </a>
                            {{-- Delete (only for admin or uploader) --}}
                            @if (auth()->user()->role === 'admin' || auth()->id() === $file->user_id)
                                <form method="POST" action="{{ route('project-files.destroy', $file) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this file?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 dark:text-gray-400">No files uploaded.</p>
            @endif
        </div>

        {{-- Comments --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">Comments</h2>

            {{-- New Comment Form --}}
            <form action="{{ route('comments.store') }}" method="POST" class="mb-4 space-y-3">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <textarea name="comment" rows="3" placeholder="Write a comment..."
                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"></textarea>
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
                    Post Comment
                </button>
            </form>

            {{-- Existing Comments --}}
            <div class="space-y-3">
                @forelse($project->comments as $comment)
                    <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-gray-900 dark:text-gray-100">{{ $comment->comment }}</p>
                        <small class="text-gray-500 dark:text-gray-400">
                            By {{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}
                        </small>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">No comments yet.</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection
