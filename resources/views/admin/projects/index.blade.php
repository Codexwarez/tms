@extends('layouts.app')
@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="px-4 py-2 bg-gray-900 text-white rounded-lg">New Project</a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium">Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Assigned To</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Priority</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Progress</th>
                    <th class="px-4 py-2 text-left text-sm font-medium">Status</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $project->name }}</td>
                        <td class="px-4 py-2">{{ $project->assignedUser?->name ?? '—' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded  {{ $project->priority_badge_class }}">
                                {{ $project->priority }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full bg-blue-500" style="width: {{ $project->progress }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500">{{ $project->progress_percent }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $project->status_readable }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a class="px-3 py-1.5 rounded-lg border dark:border-gray-600 dark:text-gray-200"
                                href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                            <a class="px-3 py-1.5 rounded-lg border bg-blue-600 text-white"
                                href="{{ route('projects.show', $project) }}">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    <div class="mt-4">{{ $projects->links() }}</div>
@endsection
