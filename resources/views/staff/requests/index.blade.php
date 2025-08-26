@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">My Requests</h1>
<div class="space-y-3">
@foreach($requests as $req)
  <div class="bg-white p-4 rounded-2xl shadow">
    <div class="flex items-center justify-between">
      <div class="font-medium">{{ $req->project->name }} • {{ ucfirst(str_replace('_',' ', $req->type)) }}</div>
      <div class="text-sm text-gray-600">Status: {{ ucfirst($req->status) }}</div>
    </div>
    <div class="mt-2 text-sm">
      <div><span class="font-semibold">Reason:</span> {{ $req->reason }}</div>
      @if($req->proposed_due_at)
        <div><span class="font-semibold">Proposed Due:</span> {{ $req->proposed_due_at->toDayDateTimeString() }}</div>
      @endif
      @if($req->admin_response)
        <div><span class="font-semibold">Admin Response:</span> {{ $req->admin_response }}</div>
      @endif
    </div>
  </div>
@endforeach
</div>
<div class="mt-4">{{ $requests->links() }}</div>
@endsection
