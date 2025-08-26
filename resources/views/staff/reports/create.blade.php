@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Submit Report - {{ $project->name }}</h1>
<form method="POST" action="{{ route('reports.store', $project) }}" class="bg-white p-4 rounded-2xl shadow space-y-4">
  @csrf
  <div>
    <label class="block text-sm mb-1">Work Done</label>
    <textarea name="work_done" class="w-full rounded-lg border px-3 py-2" rows="3"></textarea>
  </div>
  <div>
    <label class="block text-sm mb-1">Challenges</label>
    <textarea name="challenges" class="w-full rounded-lg border px-3 py-2" rows="3"></textarea>
  </div>
  <div>
    <label class="block text-sm mb-1">Suggestions</label>
    <textarea name="suggestions" class="w-full rounded-lg border px-3 py-2" rows="3"></textarea>
  </div>
  <button class="px-4 py-2 bg-gray-900 text-white rounded-lg">Submit</button>
</form>
@endsection
