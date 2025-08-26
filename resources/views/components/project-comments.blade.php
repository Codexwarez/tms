<div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mt-4">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Comments</h2>
    <form action="{{ route('comments.store') }}" method="POST" class="space-y-3">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <textarea name="comment" rows="3"
            class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
            placeholder="Add a comment..." required></textarea>
        <button type="submit"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
            Post Comment
        </button>
    </form>

    <div class="mt-4 space-y-2">
        @foreach ($project->comments as $comment)
            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <p class="text-gray-900 dark:text-gray-100">{{ $comment->comment }}</p>
                <small class="text-gray-500 dark:text-gray-400">By {{ $comment->user->name }} • {{ $comment->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>
</div>
