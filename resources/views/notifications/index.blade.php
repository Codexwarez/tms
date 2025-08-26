@extends('layouts.app')
@section('content')
<h1 class="text-2xl font-semibold mb-4">Notifications</h1>
<div class="space-y-3">
@foreach($notifications as $n)
  <div class="bg-white p-4 rounded-2xl shadow flex items-center justify-between">
    <div>
      <div class="font-medium">{{ $n->data['message'] ?? 'Notification' }}</div>
      <div class="text-xs text-gray-500">{{ $n->created_at->diffForHumans() }}</div>
    </div>
    @if(is_null($n->read_at))
      <form method="POST" action="{{ route('notifications.read', $n->id) }}">@csrf
        <button class="px-3 py-1.5 rounded-lg border">Mark read</button>
      </form>
    @endif
  </div>
@endforeach
</div>
<div class="mt-4">{{ $notifications->links() }}</div>
@endsection
