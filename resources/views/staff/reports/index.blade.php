@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">My Reports</h1>
<div class="space-y-3">
@foreach($reports as $r)
  <div class="bg-white p-4 rounded-2xl shadow">
    <div class="font-medium">{{ $r->project->name }}</div>
    <div class="text-sm text-gray-600">Submitted: {{ $r->created_at->diffForHumans() }}</div>
    <div class="mt-2 text-sm">
      <div><span class="font-semibold">Work Done:</span> {{ $r->work_done }}</div>
      <div><span class="font-semibold">Challenges:</span> {{ $r->challenges }}</div>
      <div><span class="font-semibold">Suggestions:</span> {{ $r->suggestions }}</div>
    </div>
  </div>
@endforeach
</div>
<div class="mt-4">{{ $reports->links() }}</div>
@endsection
