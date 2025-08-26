@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-semibold mb-4">Edit Project</h1>
    <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data"
        class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Name</label>
            <input name="name"
                class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200" required
                value="{{ $project->name }}" />
        </div>
        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description"
                class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ $project->description }}</textarea>
        </div>
        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Assign to Staff</label>
            <select name="assigned_user_id"
                class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                <option value="">— None —</option>
                @foreach ($users as $u)
                    <option value="{{ $u->id }}" @selected($project->assigned_user_id == $u->id)>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Status</label>
                <select name="status"
                    class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                    @foreach (['incomplete', 'in_progress', 'completed'] as $st)
                        <option value="{{ $st }}" @selected($project->status == $st)>
                            {{ ucfirst(str_replace('_', ' ', $st)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Start At</label>
                <input type="datetime-local" name="start_at"
                    class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                    value="{{ optional($project->start_at)->format('Y-m-d\TH:i') }}">
            </div>
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Due At</label>
                <input type="datetime-local" name="due_at"
                    class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                    value="{{ optional($project->due_at)->format('Y-m-d\TH:i') }}">
            </div>
        </div>
        <div>
            <label class="block text-sm mb-1">Priority</label>
            <select name="priority" class="w-full rounded-lg border px-3 py-2">
                @foreach (['Low', 'Medium', 'High'] as $p)
                    <option value="{{ $p }}" @selected($project->priority == $p)>{{ $p }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1">Progress (%)</label>
            <input type="number" name="progress" min="0" max="100" value="{{ $project->progress }}"
                class="w-full rounded-lg border px-3 py-2">
        </div>

        {{-- <div>
    <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Upload New Files</label>
    <input type="file" name="files[]" multiple
           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
  </div> --}}
        <button class="px-4 py-2 bg-gray-900 text-white rounded-lg">Update</button>
    </form>

    {{-- Existing Files --}}
    @if ($project->files->count())
        <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <h2 class="font-semibold text-gray-800 dark:text-gray-100 mb-2">Existing Files</h2>
            <ul class="list-disc list-inside text-sm text-gray-700 dark:text-gray-300">
                @foreach ($project->files as $file)
                    <li>
                        <a href="{{ Storage::url($file->file_path) }}" target="_blank"
                            class="text-blue-600 dark:text-blue-400 underline">
                            {{ $file->file_name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
