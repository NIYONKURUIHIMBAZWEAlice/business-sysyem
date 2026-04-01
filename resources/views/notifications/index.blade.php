
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
        <h1 class="text-3xl">🔔 Notifications</h1>
        @if($notifications->count() > 0)
            <form action="{{ route('notifications.destroyAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" style="background:#ef4444;color:white;padding:8px 16px;border-radius:8px;border:none;cursor:pointer">
                    Clear All
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:12px;border-radius:8px;margin-bottom:16px">
            {{ session('success') }}
        </div>
    @endif

    @if($notifications->count() === 0)
        <p style="color:#6b7280">No notifications yet.</p>
    @else
        @foreach($notifications as $notification)
            <div style="background:{{ $notification->is_read ? '#f9fafb' : '#f0fdf4' }};border:1px solid {{ $notification->is_read ? '#e5e7eb' : '#86efac' }};padding:16px;border-radius:10px;margin-bottom:12px;display:flex;justify-content:space-between;align-items:center">
                <div>
                    <strong>{{ $notification->title }}</strong>
                    @if(!$notification->is_read)
                        <span style="background:#22c55e;color:white;font-size:11px;padding:2px 8px;border-radius:999px;margin-left:8px">New</span>
                    @endif
                    <p style="margin-top:4px;color:#374151">{{ $notification->message }}</p>
                    <small style="color:#9ca3af">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="margin-left:16px">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:#ef4444;color:white;padding:6px 12px;border-radius:6px;border:none;cursor:pointer">
                        Delete
                    </button>
                </form>
            </div>
        @endforeach
    @endif
</div>
@endsection