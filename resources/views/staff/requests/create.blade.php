@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">New Request - {{ $project->name }}</h1>
<form method="POST" action="{{ route('requests.store', $project) }}" class="bg-white p-4 rounded-2xl shadow space-y-4">
  @csrf
  <div>
    <label class="block text-sm mb-1">Type</label>
    <select name="type" class="w-full rounded-lg border px-3 py-2">
      <option value="time_extension">Time Extension</option>
      <option value="project_review">Project Review</option>
    </select>
  </div>
  <div>
    <label class="block text-sm mb-1">Reason</label>
    <textarea name="reason" class="w-full rounded-lg border px-3 py-2" rows="3"></textarea>
  </div>
  <div>
    <label class="block text-sm mb-1">Proposed Due At (optional)</label>
    <input type="datetime-local" name="proposed_due_at" class="w-full rounded-lg border px-3 py-2">
  </div>
  <button class="px-4 py-2 bg-gray-900 text-white rounded-lg">Submit</button>
</form>
@endsection
