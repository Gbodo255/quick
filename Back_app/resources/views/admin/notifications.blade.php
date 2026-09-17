@extends('admin.layout')
@section('title', 'Notifications — QuickCredit Admin')

@section('content')

{!! '<style>
    .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 1.5rem; }
    .card-header { padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .card-title { font-size: 0.95rem; font-weight: 700; color: #0f172a; }

    .notif-item {
        display: flex; gap: 14px; align-items: flex-start;
        padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;
        text-decoration: none; transition: background 0.15s;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: #f8fafc; }
    .notif-item.unread { background: #f8fafc; }
    .notif-icon {
        height: 38px; width: 38px; border-radius: 50%; flex-shrink: 0;
        background: #dbeafe; color: #1d4ed8;
        display: flex; align-items: center; justify-content: center;
    }
    .notif-title { font-size: 0.85rem; font-weight: 600; color: #0f172a; }
    .notif-time { font-size: 0.75rem; color: #94a3b8; margin-top: 2px; }
    .notif-dot { width: 8px; height: 8px; border-radius: 50%; background: #4f46e5; flex-shrink: 0; margin-top: 6px; }

    .empty-state { padding: 3rem 1.5rem; text-align: center; color: #94a3b8; font-size: 0.85rem; }
</style>' !!}

<div class="card">
    <div class="card-header">
        <div class="card-title">Toutes les notifications</div>
        <span style="font-size:0.75rem; color:#94a3b8;">{{ $notifications->total() }} au total</span>
    </div>

    @forelse ($notifications as $notification)
        <a href="{{ route('admin.notifications.read', $notification->id) }}" class="notif-item {{ $notification->unread() ? 'unread' : '' }}">
            <div class="notif-icon">
                <svg style="width:18px;height:18px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
            </div>
            <div style="flex:1;">
                <div class="notif-title">{{ $notification->data['message'] ?? 'Nouveau dossier' }} {{ $notification->data['reference'] ?? '' }}</div>
                <div class="notif-time">{{ $notification->created_at->format('d/m/Y à H:i') }} &middot; {{ $notification->created_at->diffForHumans() }}</div>
            </div>
            @if ($notification->unread())
                <div class="notif-dot" title="Non lue"></div>
            @endif
        </a>
    @empty
        <div class="empty-state">Aucune notification pour le moment.</div>
    @endforelse
</div>

@if ($notifications->hasPages())
<div style="display:flex; justify-content:center;">
    {{ $notifications->links() }}
</div>
@endif

@endsection
