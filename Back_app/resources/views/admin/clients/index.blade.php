@extends('admin.layout')
@section('title', 'Gestion des Utilisateurs — QuickCredit Admin')

@section('content')

{!! '<style>
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .page-title { font-size: 1.8rem; font-weight: 800; color: #0f172a; line-height: 1.2; letter-spacing: -0.02em; }
    .page-sub   { font-size: 0.85rem; color: #64748b; margin-top: 6px; max-width: 600px; line-height: 1.4; }
    
    .header-actions { display: flex; gap: 10px; }
    .btn-outline {
        padding: 0.6rem 1.2rem; background: #fff; color: #334155; font-size: 0.85rem; font-weight: 600;
        border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-dark {
        padding: 0.6rem 1.2rem; background: #000; color: #fff; font-size: 0.85rem; font-weight: 600;
        border: none; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    }

    /* ---- Stats Cards ---- */
    .stats-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem;
    }
    .stat-card {
        background: #fff; padding: 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }
    .stat-title { font-size: 0.65rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
    .stat-value { font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; }
    .stat-sub { font-size: 0.75rem; color: #10b981; font-weight: 600; display: flex; align-items: center; gap: 4px; }
    .stat-sub.red { color: #ef4444; }

    .stat-card.dark { background: #0f172a; color: #fff; border: none; }
    .stat-card.dark .stat-title { color: #10b981; }
    .stat-card.dark .stat-value { color: #fff; }
    .stat-card.dark .stat-sub { color: #94a3b8; font-weight: 400; }

    /* ---- Table ---- */
    .table-container {
        background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden;
    }
    .table-header-box { padding: 1.25rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
    .table-title { font-size: 1.1rem; font-weight: 700; color: #0f172a; }
    
    .dash-table { width: 100%; border-collapse: collapse; }
    .dash-table th {
        padding: 0.8rem 1.25rem; text-align: left;
        font-size: 0.65rem; font-weight: 700; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.07em;
    }
    .dash-table td { padding: 1rem 1.25rem; border-top: 1px solid #f1f5f9; vertical-align: middle; }
    .dash-table tr:hover td { background: #f8fafc; }

    .user-avatar {
        height: 36px; width: 36px; border-radius: 50%; background: #e2e8f0;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.8rem; font-weight: 700; color: #475569; overflow: hidden;
    }
    .badge { font-size: 0.65rem; font-weight: 700; padding: 0.25rem 0.6rem; border-radius: 12px; text-transform: uppercase; }
    .badge-active { background: #dcfce7; color: #16a34a; }
    .badge-suspended { background: #f3f4f6; color: #6b7280; }
    .badge-blocked { background: #fee2e2; color: #dc2626; }

    .action-icon { color: #94a3b8; cursor: pointer; transition: color 0.2s; }
    .action-icon:hover { color: #0f172a; }
    .action-icon.red:hover { color: #dc2626; }
    .action-icon.green:hover { color: #16a34a; }

    /* ---- Filters ---- */
    .filters-section {
        background: #fff; padding: 1.25rem; border-radius: 12px; border: 1px solid #e2e8f0;
        margin-bottom: 1.5rem; display: flex; gap: 1rem; align-items: flex-end;
    }
    .filter-group { flex: 1; }
    .filter-label { font-size: 0.75rem; font-weight: 600; color: #475569; margin-bottom: 6px; display: block; }
    .filter-input, .filter-select {
        width: 100%; padding: 0.6rem 0.8rem; font-size: 0.85rem; border: 1px solid #e2e8f0;
        border-radius: 8px; background: #fff; color: #0f172a; outline: none; transition: border-color 0.2s;
    }
    .btn-search {
        padding: 0.6rem 1.2rem; background: #0f172a; color: #fff; font-size: 0.85rem; font-weight: 600;
        border: none; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-search:hover { background: #334155; }
    .btn-reset {
        padding: 0.6rem 1.2rem; background: #f1f5f9; color: #475569; font-size: 0.85rem; font-weight: 600;
        border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
        text-decoration: none; margin-left: 8px;
    }
    .btn-reset:hover { background: #e2e8f0; color: #0f172a; }

    .pagination-container {
        display: flex; justify-content: space-between; align-items: center;
        padding: 1rem 1.25rem; border-top: 1px solid #f1f5f9; background: #fff;
        font-size: 0.8rem; color: #64748b;
    }
    .per-page-select {
        padding: 0.3rem 0.6rem; font-size: 0.8rem;
        border: 1px solid #e2e8f0; border-radius: 6px;
        background: #fff; color: #0f172a; outline: none;
    }
</style>' !!}

<div class="page-header">
    <div>
        <!-- Titles removed as requested -->
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.clients.export') }}" class="btn-outline">
            <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
            Exporter CSV
        </a>
    </div>
</div>

{{-- ===== FILTERS ===== --}}
<form method="GET" action="{{ route('admin.clients.index') }}" class="filters-section" id="filterForm">
    <div class="filter-group">
        <label class="filter-label">Rechercher</label>
        <input type="text" name="search" class="filter-input" placeholder="Nom, email..." value="{{ request('search') }}">
    </div>
    
    <div class="filter-group">
        <label class="filter-label">Statut</label>
        <select name="status" class="filter-select">
            <option value="">Tous les statuts</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
            <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Bloqué</option>
        </select>
    </div>
    
    <input type="hidden" name="per_page" value="{{ $perPage ?? 10 }}">

    <div>
        <button type="submit" class="btn-search">
            <svg style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            Filtrer
        </button>
        <a href="{{ route('admin.clients.index') }}" class="btn-reset">
            Réinitialiser
        </a>
    </div>
</form>

<div class="table-container">
    <div class="table-header-box">
        <div class="table-title">Répertoire Utilisateurs</div>
        <div>
            <svg style="width:20px;height:20px;color:#64748b;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" /></svg>
        </div>
    </div>
    <table class="dash-table">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Statut</th>
                <th>Total Crédits</th>
                <th>Date Inscription</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clients as $client)
            @php
                $colors = ['#e0e7ff:#4f46e5', '#dcfce7:#16a34a', '#fef3c7:#d97706', '#ffe4e6:#e11d48'];
                $ci = $loop->index % 4;
                [$bg, $fg] = explode(':', $colors[$ci]);
            @endphp
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div class="user-avatar" style="background:{{$bg}};color:{{$fg}};">
                            {{ strtoupper(substr($client->prenom ?? 'X', 0, 1).substr($client->nom ?? 'X', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:0.9rem;font-weight:600;color:#0f172a;">{{ $client->prenom ?? '' }} {{ $client->nom ?? '' }}</div>
                            <div style="font-size:0.75rem;color:#64748b;">{{ $client->email }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($client->is_blocked)
                        <span class="badge badge-blocked">BLOQUÉ</span>
                    @elseif($client->is_archived)
                        <span class="badge badge-suspended">ARCHIVÉ</span>
                    @else
                        <span class="badge badge-active">ACTIF</span>
                    @endif
                </td>
                <td><span style="font-size:0.85rem;font-weight:600;color:#0f172a;">€{{ number_format($client->total_credits, 2, '.', ',') }}</span></td>
                <td><span style="font-size:0.85rem;color:#475569;">{{ \Carbon\Carbon::parse($client->first_seen)->format('d M Y') }}</span></td>
                <td style="text-align:right;">
                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:12px;">
                        <a href="{{ route('admin.clients.show', ['email' => $client->email]) }}" class="action-icon" title="Voir">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                        </a>
                        <button type="button" onclick="openClientArchiveModal('{{ str_replace(['@', '.'], '_', $client->email) }}', '{{ addslashes($client->prenom . ' ' . $client->nom) }}')" class="action-icon red" title="Archiver" style="background:transparent;border:none;">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H2.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" /></svg>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if($clients->total() > 0)
    <div class="pagination-container">
        <div style="display:flex; align-items:center; gap:10px;">
            Afficher 
            <select id="perPageSelect" class="per-page-select">
                <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ ($perPage ?? 10) == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ ($perPage ?? 10) == 30 ? 'selected' : '' }}>30</option>
                <option value="40" {{ ($perPage ?? 10) == 40 ? 'selected' : '' }}>40</option>
            </select>
            sur {{ $clients->total() }} résultats
        </div>
        
        <div class="pagination-links">
            {{ $clients->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @else
    <div style="padding: 2rem; text-align: center; color: #64748b; font-size: 0.9rem;">
        Aucun utilisateur trouvé pour ces critères.
    </div>
    @endif
</div>

@foreach($clients as $client)
<form id="archive-client-form-{{ str_replace(['@', '.'], '_', $client->email) }}" action="{{ route('admin.clients.archive', ['email' => $client->email]) }}" method="POST" style="display:none;">
    @csrf @method('PATCH')
</form>
@endforeach

{{-- Archive Modal --}}
<div id="archiveClientModal" class="modal-overlay" style="display:none;">
    <div class="modal-box fade-in-up">
        <div class="modal-icon-wrapper">
            <div class="modal-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H2.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </div>
        </div>
        <h3 class="modal-title">Archiver l'utilisateur</h3>
        <p class="modal-desc">Voulez-vous vraiment archiver l'utilisateur <strong id="modalClientRef" style="color:#0f172a;"></strong> ?<br>Cette action le déplacera vers vos archives.</p>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeClientArchiveModal()">Annuler</button>
            <button type="button" class="btn-confirm-archive" onclick="submitClientArchiveForm()">Oui, Archiver</button>
        </div>
    </div>
</div>

{!! '<script>
    let currentClientArchiveId = null;

    function openClientArchiveModal(id, ref) {
        currentClientArchiveId = id;
        document.getElementById("modalClientRef").innerText = ref;
        document.getElementById("archiveClientModal").style.display = "flex";
    }

    function closeClientArchiveModal() {
        currentClientArchiveId = null;
        document.getElementById("archiveClientModal").style.display = "none";
    }

    function submitClientArchiveForm() {
        if(currentClientArchiveId) {
            document.getElementById("archive-client-form-" + currentClientArchiveId).submit();
        }
    }

    document.getElementById("perPageSelect")?.addEventListener("change", function() {
        let form = document.getElementById("filterForm");
        if(form) {
            form.querySelector("input[name=\'per_page\']").value = this.value;
            form.submit();
        }
    });
</script>' !!}

{!! '<style>
    /* Pagination Tweaks */
    .pagination { display: flex; list-style: none; padding: 0; margin: 0; gap: 4px; }
    .page-item .page-link, .page-item span {
        padding: 0.3rem 0.6rem; font-size: 0.8rem; font-weight: 600;
        color: #475569; background: #fff; border: 1px solid #e2e8f0; border-radius: 4px; text-decoration: none;
    }
    .page-item .page-link:hover { background: #f8fafc; color: #0f172a; }
    .page-item.active span { background: #000; color: #fff; border-color: #000; }

    /* Modal Styles */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        z-index: 1000; padding: 1rem;
    }
    .modal-box {
        background: #fff; width: 100%; max-width: 400px;
        border-radius: 20px; padding: 2rem;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        text-align: center;
    }
    .modal-icon-wrapper {
        display: flex; justify-content: center; margin-bottom: 1.2rem;
    }
    .modal-icon {
        width: 56px; height: 56px; background: #fef2f2; color: #dc2626;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        border: 4px solid #fff1f2;
    }
    .modal-icon svg { width: 28px; height: 28px; }
    .modal-title { font-size: 1.2rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
    .modal-desc { font-size: 0.85rem; color: #64748b; line-height: 1.5; margin-bottom: 1.5rem; }
    .modal-actions {
        display: flex; gap: 10px;
    }
    .modal-actions button {
        flex: 1; padding: 0.7rem; border-radius: 10px; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s;
    }
    .btn-cancel { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .btn-cancel:hover { background: #e2e8f0; color: #0f172a; }
    .btn-confirm-archive { background: #dc2626; color: #fff; border: none; }
    .btn-confirm-archive:hover { background: #b91c1c; }
    
    .fade-in-up {
        animation: fadeInUp 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>' !!}

@endsection
