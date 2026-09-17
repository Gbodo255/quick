@extends('admin.layout')
@section('title', 'Profil Client — QuickCredit Admin')

@section('content')

{!! '<style>
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .breadcrumb { font-size: 0.8rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; }
    .breadcrumb a { color: #64748b; text-decoration: none; transition: color 0.2s; }
    .breadcrumb a:hover { color: #0f172a; }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #0f172a; line-height: 1.2; letter-spacing: -0.02em; }
    
    .btn-outline {
        padding: 0.6rem 1.2rem; background: #fff; color: #334155; font-size: 0.85rem; font-weight: 600;
        border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-dark {
        padding: 0.6rem 1.2rem; background: #000; color: #fff; font-size: 0.85rem; font-weight: 600;
        border: none; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    }

    /* ---- Layout ---- */
    .client-layout { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start; }

    /* ---- Card ---- */
    .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 1.5rem; margin-bottom: 1.5rem; }
    .card-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; }
    
    /* ---- Profile Info ---- */
    .profile-info { display: flex; gap: 1.5rem; align-items: flex-start; justify-content: space-between; }
    .profile-left { display: flex; gap: 1.5rem; align-items: center; }
    .avatar-lg {
        width: 80px; height: 80px; border-radius: 12px; background: #1e293b; color: #fff;
        display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800;
    }
    .client-name { font-size: 1.4rem; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .client-meta { font-size: 0.85rem; color: #64748b; margin-bottom: 8px; }
    .badge-verified {
        display: inline-flex; align-items: center; gap: 4px; font-size: 0.75rem; font-weight: 700;
        color: #16a34a; background: #dcfce7; padding: 0.2rem 0.6rem; border-radius: 12px;
    }
    .score-box { text-align: center; }
    .score-title { font-size: 0.65rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px; }
    .score-val { background: #000; color: #10b981; font-size: 1.5rem; font-weight: 800; padding: 0.5rem 1rem; border-radius: 8px; min-width: 80px; }
    
    /* ---- Summary Stats ---- */
    .summary-stats { display: flex; justify-content: space-between; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; }
    .stat-item { flex: 1; }
    .stat-label { font-size: 0.75rem; color: #64748b; font-weight: 600; margin-bottom: 4px; }
    .stat-val { font-size: 1.2rem; font-weight: 700; color: #0f172a; }
    .stat-val span { font-size: 0.9rem; color: #10b981; font-weight: 600; margin-left: 4px; }

    /* ---- History List ---- */
    .history-item {
        display: flex; justify-content: space-between; align-items: center;
        padding: 1rem; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 1rem; background: #f8fafc;
    }
    .history-item:last-child { margin-bottom: 0; }
    .history-icon {
        width: 40px; height: 40px; border-radius: 8px; background: #e2e8f0; color: #64748b;
        display: flex; align-items: center; justify-content: center;
    }
    .history-icon.green { background: #dcfce7; color: #16a34a; }
    .history-left { display: flex; gap: 12px; align-items: center; }
    .history-title { font-size: 0.9rem; font-weight: 700; color: #0f172a; }
    .history-sub { font-size: 0.75rem; color: #64748b; margin-top: 2px; }
    .history-right { text-align: right; }
    .history-val { font-size: 0.9rem; font-weight: 700; color: #0f172a; }
    .history-status { font-size: 0.75rem; font-weight: 700; margin-top: 2px; }
    .status-completed { color: #16a34a; }
    .status-processing { color: #2563eb; }

    /* ---- Notes ---- */
    .note-item { display: flex; gap: 12px; margin-bottom: 1.25rem; }
    .note-avatar { width: 32px; height: 32px; border-radius: 50%; background: #000; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; }
    .note-content { flex: 1; }
    .note-header { display: flex; justify-content: space-between; margin-bottom: 4px; }
    .note-author { font-size: 0.8rem; font-weight: 700; color: #0f172a; }
    .note-time { font-size: 0.7rem; color: #94a3b8; }
    .note-box { background: #f1f5f9; padding: 0.75rem; border-radius: 8px; font-size: 0.85rem; color: #334155; line-height: 1.4; border-bottom-left-radius: 0; }
    
    .note-input-wrap { display: flex; gap: 10px; margin-top: 1rem; }
    .note-input { flex: 1; padding: 0.75rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; font-size: 0.85rem; }
    .note-btn { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; width: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #0f172a; }
</style>' !!}

<div class="page-header">
    <div>

        <div class="page-title">Client {{ $clientInfo->prenom }} {{ $clientInfo->nom }}</div>
    </div>
    <div style="display:flex; gap:10px;">
        <form method="POST" action="{{ route('admin.clients.block', $clientInfo->email) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn-outline" style="color: {{ $clientInfo->status->is_blocked ? '#10b981' : '#ef4444' }}; border-color: currentColor;">
                {{ $clientInfo->status->is_blocked ? 'Débloquer' : 'Bloquer' }}
            </button>
        </form>
        <form method="POST" action="{{ route('admin.clients.archive', $clientInfo->email) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn-outline">
                {{ $clientInfo->status->is_archived ? 'Désarchiver' : 'Archiver' }}
            </button>
        </form>
    </div>
</div>

<div class="client-layout">
    <div class="layout-main">
        {{-- Profile Card --}}
        <div class="card">
            <div class="profile-info">
                <div class="profile-left">
                    <div class="avatar-lg">
                        {{ strtoupper(substr($clientInfo->prenom ?? 'X', 0, 1).substr($clientInfo->nom ?? 'X', 0, 1)) }}
                    </div>
                    <div>
                        <div class="client-name">{{ $clientInfo->prenom }} {{ $clientInfo->nom }}</div>
                        <div class="client-meta">Client depuis {{ \Carbon\Carbon::parse($clientInfo->first_seen)->translatedFormat('F Y') }} • {{ $clientInfo->email }}</div>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <span class="badge-verified">
                                <svg style="width:12px;height:12px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                Vérifié
                            </span>
                            @if($clientInfo->status->is_blocked)
                            <span style="font-size:0.75rem; color:#ef4444; display:flex; align-items:center; gap:4px; font-weight:600; background:#fef2f2; padding:0.2rem 0.5rem; border-radius:4px;">
                                Bloqué
                            </span>
                            @endif
                            @if($clientInfo->status->is_archived)
                            <span style="font-size:0.75rem; color:#f59e0b; display:flex; align-items:center; gap:4px; font-weight:600; background:#fffbeb; padding:0.2rem 0.5rem; border-radius:4px;">
                                Archivé
                            </span>
                            @endif
                            <span style="font-size:0.75rem; color:#64748b; display:flex; align-items:center; gap:4px;">
                                <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                                France
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="summary-stats">
                <div class="stat-item">
                    <div class="stat-label">Total Crédits Demandés</div>
                    <div class="stat-val">€{{ number_format($clientInfo->total_credits, 2, '.', ' ') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Dossiers Soumis</div>
                    <div class="stat-val">{{ $dossiers->count() }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Dernière Activité</div>
                    <div class="stat-val">{{ \Carbon\Carbon::parse($clientInfo->first_seen)->diffForHumans() }}</div>
                </div>
            </div>
        </div>

        {{-- History Card --}}
        <div class="card">
            <div class="card-title">Historique des Dossiers</div>
            <div>
                @foreach($dossiers as $d)
                <div class="history-item">
                    <div class="history-left">
                        <div class="history-icon {{ $d->status->value === 'completed' ? 'green' : '' }}">
                            @if($d->status->value === 'completed')
                                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            @else
                                <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('admin.dossiers.show', $d) }}" class="history-title" style="text-decoration:none;">Dossier #QC-{{ str_pad($d->id, 4, '0', STR_PAD_LEFT) }}</a>
                            <div class="history-sub">Créé le {{ $d->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="history-right">
                        <div class="history-val">€{{ number_format($d->montant, 0, '.', ' ') }}</div>
                        <div class="history-status {{ $d->status->value === 'completed' ? 'status-completed' : 'status-processing' }}">
                            {{ match($d->status->value) { 'completed' => 'Approuvé', 'processing' => 'En cours', 'submitted' => 'Soumis', default => 'Brouillon' } }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="layout-sidebar">
        {{-- Notes Card --}}
        <div class="card">
            <div class="card-title">
                Notes Internes
                <span style="font-size:0.7rem; font-weight:600; background:#f1f5f9; padding:0.2rem 0.6rem; border-radius:12px; color:#64748b;">{{ $notes->count() }} Message{{ $notes->count() > 1 ? 's' : '' }}</span>
            </div>
            
            <div style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                @forelse($notes as $note)
                <div class="note-item">
                    <div class="note-avatar">{{ strtoupper(substr($note->user->name ?? 'Utilisateur supprimé', 0, 2)) }}</div>
                    <div class="note-content">
                        <div class="note-header">
                            <div class="note-author">{{ $note->user->name ?? 'Utilisateur supprimé' }}</div>
                            <div class="note-time">{{ $note->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="note-box">
                            {{ $note->note }}
                        </div>
                    </div>
                </div>
                @empty
                <div style="font-size: 0.85rem; color: #94a3b8; text-align: center; margin-bottom: 1rem;">
                    Aucune note interne pour ce client.
                </div>
                @endforelse
            </div>

            <form action="{{ route('admin.clients.notes.store', $clientInfo->email) }}" method="POST" class="note-input-wrap">
                @csrf
                <input type="text" name="note" class="note-input" placeholder="Ajouter une note..." required>
                <button type="submit" class="note-btn">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.125A59.769 59.769 0 0121.485 12 59.768 59.768 0 013.27 20.875L5.999 12zm0 0h7.5" /></svg>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
