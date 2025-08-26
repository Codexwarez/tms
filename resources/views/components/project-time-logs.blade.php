<div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow mt-4">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Log Time</h2>
    <form action="{{ route('time-logs.store') }}" method="POST" class="space-y-3">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <input type="number" step="0.25" min="0.25" max="24" name="hours"
            class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
            placeholder="Hours worked" required>
        <textarea name="notes" rows="2"
            class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
            placeholder="Notes (optional)"></textarea>
        <button type="submit"
            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow">
            Save Log
        </button>
    </form>

    <div class="mt-4 space-y-2">
        @foreach ($project->timeLogs as $log)
            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <p class="text-gray-900 dark:text-gray-100">{{ $log->hours }} hrs - {{ $log->notes }}</p>
                <small class="text-gray-500 dark:text-gray-400">By {{ $log->user->name }} • {{ $log->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>
</div>
