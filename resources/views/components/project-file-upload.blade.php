<div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Upload Project File</h2>
    <form action="{{ route('project-files.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <input type="file" name="file"
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 focus:ring focus:ring-blue-500" required>
        <button type="submit"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
            Upload
        </button>
    </form>
</div>
