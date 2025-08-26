@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

{{-- Top metrics --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
  <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
    <p class="text-gray-500 dark:text-gray-400">Projects</p>
    <p class="text-2xl font-semibold">{{ $projects_count }}</p>
  </div>
  <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
    <p class="text-gray-500 dark:text-gray-400">Staff</p>
    <p class="text-2xl font-semibold">{{ $staff_count }}</p>
  </div>
  <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
    <p class="text-gray-500 dark:text-gray-400">Pending Requests</p>
    <p class="text-2xl font-semibold">{{ $requests_count }}</p>
  </div>
  <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
    <p class="text-gray-500 dark:text-gray-400">Reports</p>
    <p class="text-2xl font-semibold">{{ $reports_count }}</p>
  </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
  <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
    <h2 class="text-lg font-semibold mb-2">Project Status</h2>
    <canvas id="statusChart"></canvas>
  </div>
  <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
    <h2 class="text-lg font-semibold mb-2">Staff Performance</h2>
    <canvas id="staffChart"></canvas>
  </div>
</div>

{{-- Overdue --}}
<div class="p-4 bg-red-100 dark:bg-red-900 rounded-2xl shadow mb-8">
  <p class="text-lg font-semibold text-red-800 dark:text-red-200">
    Overdue Projects: {{ $overdueCount }}
  </p>
</div>

{{-- Recent Reports --}}
<div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow mb-8">
  <h2 class="text-lg font-semibold mb-2">Recent Reports</h2>
  <ul class="divide-y divide-gray-200 dark:divide-gray-700">
    @foreach($recent_reports as $report)
      <li class="py-2">
        <span class="font-medium">{{ $report->user->name }}</span> 
        reported on <span class="text-gray-500">{{ $report->project->name }}</span>
      </li>
    @endforeach
  </ul>
</div>

{{-- Recent Requests --}}
<div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow">
  <h2 class="text-lg font-semibold mb-2">Recent Requests</h2>
  <ul class="divide-y divide-gray-200 dark:divide-gray-700">
    @foreach($recent_requests as $req)
      <li class="py-2">
        Request from <span class="font-medium">{{ $req->user->name ?? 'Unknown' }}</span> 
        ({{ ucfirst($req->status) }})
      </li>
    @endforeach
  </ul>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Status chart
  new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
      labels: @json(array_keys($statusCounts->toArray())),
      datasets: [{
        data: @json(array_values($statusCounts->toArray())),
        backgroundColor: ['#f87171', '#facc15', '#34d399', '#60a5fa']
      }]
    }
  });

  // Staff performance chart
  new Chart(document.getElementById('staffChart'), {
    type: 'bar',
    data: {
      labels: @json($staffPerformance->pluck('name')),
      datasets: [{
        label: 'Completed',
        data: @json($staffPerformance->pluck('completed')),
        backgroundColor: '#34d399'
      },{
        label: 'Total',
        data: @json($staffPerformance->pluck('total')),
        backgroundColor: '#60a5fa'
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
</script>
@endsection
