@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Staff Requests</h1>
<div class="space-y-3">
@foreach($requests as $req)
  <div class="bg-white p-4 rounded-2xl shadow">
    <div class="flex items-center justify-between">
      <div class="font-medium">{{ $req->project->name }} • {{ $req->user->name }} • {{ ucfirst(str_replace('_',' ', $req->type)) }}</div>
      <div class="text-sm text-gray-600">Status: {{ ucfirst($req->status) }}</div>
    </div>
    <div class="mt-2 text-sm">
      <div><span class="font-semibold">Reason:</span> {{ $req->reason }}</div>
      @if($req->proposed_due_at)
        <div><span class="font-semibold">Proposed Due:</span> {{ $req->proposed_due_at->toDayDateTimeString() }}</div>
      @endif
    </div>
    <form method="POST" action="{{ route('requests.updateStatus', $req) }}" class="mt-3 flex items-center gap-2">
      @csrf @method('PUT')
      <select name="status" class="rounded-lg border px-3 py-1.5">
        @foreach(['pending','approved','rejected'] as $st)
          <option value="{{ $st }}" @selected($req->status==$st)>{{ ucfirst($st) }}</option>
        @endforeach
      </select>
      <input name="admin_response" placeholder="Response (optional)" class="rounded-lg border px-3 py-1.5 flex-1"/>
      <button class="px-3 py-1.5 rounded-lg bg-gray-900 text-white">Update</button>
    </form>
  </div>
@endforeach
</div>
<div class="mt-4">{{ $requests->links() }}</div>
@endsection
