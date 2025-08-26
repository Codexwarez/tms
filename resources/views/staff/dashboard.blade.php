@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">My Dashboard</h1>

    {{-- Quick stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
            <p class="text-gray-500 dark:text-gray-400">My Projects</p>
            <p class="text-2xl font-semibold">{{ $my_projects->count() }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
            <p class="text-gray-500 dark:text-gray-400">My Reports</p>
            <p class="text-2xl font-semibold">{{ $my_reports->count() }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
            <p class="text-gray-500 dark:text-gray-400">Notifications</p>
            <p class="text-2xl font-semibold">{{ $notifications->count() }}</p>
        </div>
    </div>

    {{-- My Project Status --}}
    <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow mb-8">
        <h2 class="text-lg font-semibold mb-2">Project Status</h2>
        <canvas id="staffStatusChart" width="300" height="300"></canvas>
    </div>

    {{-- Recent Projects --}}
    <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow mb-8">
        <h2 class="text-lg font-semibold mb-2">Recent Projects</h2>
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($my_projects as $project)
                <li class="py-2">
                    {{ $project->name }} — <span class="text-gray-500">{{ ucfirst($project->status_readable) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Recent Reports --}}
    <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
        <h2 class="text-lg font-semibold mb-2">Recent Reports</h2>
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($my_reports as $report)
                <li class="py-2">
                    Reported on <span class="font-medium">{{ $report->project->name }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('staffStatusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json(array_keys($statusCounts->toArray())),
                datasets: [{
                    data: @json(array_values($statusCounts->toArray())),
                    backgroundColor: ['#f87171', '#facc15', '#34d399', '#60a5fa']
                }]
            },
            options: {
                responsive: false, // Important: disables automatic resizing
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
