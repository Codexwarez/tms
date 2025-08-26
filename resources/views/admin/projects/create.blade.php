@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-semibold mb-4">Create Project</h1>
    <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data"
        class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow space-y-4">
        @csrf
        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Name</label>
            <input name="name"
                class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                required />
        </div>
        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="description"
                class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"></textarea>
        </div>
        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Assign to Staff</label>
            <select name="assigned_user_id"
                class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                <option value="">— None —</option>
                @foreach ($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Start At</label>
                <input type="datetime-local" name="start_at"
                    class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            </div>
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Due At</label>
                <input type="datetime-local" name="due_at"
                    class="w-full rounded-lg border px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            </div>
        </div>
        <div>
            <label class="block text-sm mb-1">Priority</label>
            <select name="priority" class="w-full rounded-lg border px-3 py-2" required>
                <option value="Low">Low</option>
                <option value="Medium" selected>Medium</option>
                <option value="High">High</option>
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">Upload Files</label>
            <input type="file" name="files[]" multiple
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
        </div>
        <button class="px-4 py-2 bg-gray-900 text-white rounded-lg">Save</button>
    </form>
@endsection
