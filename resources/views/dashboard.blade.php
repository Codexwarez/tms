@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- My Projects -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-4">My Projects</h3>
        <ul>
            @forelse($my_projects as $project)
            <li class="py-2 border-b last:border-0">
                {{ $project->title }} - 
                <span class="text-sm text-gray-500">{{ $project->status_readable }}</span>
            </li>
            @empty
            <p>No assigned projects.</p>
            @endforelse
        </ul>
    </div>

    <!-- Notifications -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-4">Notifications</h3>
        <ul>
            @forelse($notifications as $notif)
            <li class="py-2 border-b last:border-0">
                {{ $notif->data['message'] ?? 'Notification' }}
            </li>
            @empty
            <p>No notifications yet.</p>
            @endforelse
        </ul>
    </div>
</div>
@endsection
