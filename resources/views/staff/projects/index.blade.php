@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">My Projects</h1>

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-gray-50 dark:bg-gray-700">
      <tr>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Name</th>
        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Status</th>
        <th class="px-4 py-2"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($projects as $project)
      <tr class="border-t dark:border-gray-600">
        <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $project->name }}</td>
        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
          {{ ucfirst(str_replace('_',' ', $project->status)) }}
        </td>
        <td class="px-4 py-2 text-right">
          <a href="{{ route('projects.show', $project) }}"
             class="px-3 py-1.5 rounded-lg bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900">
            View
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $projects->links() }}</div>
@endsection
