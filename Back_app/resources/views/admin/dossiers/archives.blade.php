@extends('admin.layout')
@section('title', 'Dossiers Archivés — QuickCredit Admin')

@section('content')

{!! '<style>
    /* ---- Header & Actions ---- */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        margin-bottom: 1.5rem;
    }
    .page-title { font-size: 1.6rem; font-weight: 800; color: #0f172a; line-height: 1.2; }
    .page-sub   { font-size: 0.8rem; color: #94a3b8; margin-top: 4px; }
    
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
    .table-container {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;
    }
    .dash-table { width: 100%; border-collapse: collapse; }
    .dash-table th {
        padding: 0.8rem 1.25rem; text-align: left;
        font-size: 0.65rem; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.07em;
        background: #f8fafc; border-bottom: 1px solid #f1f5f9;
    }
    .dash-table td { padding: 1rem 1.25rem; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
    .dash-table tr:last-child td { border-bottom: none; }
    .dash-table tr:hover td { background: #fafbfc; }
    .ref-code { font-size: 0.75rem; font-weight: 700; color: #4f46e5; font-family: monospace; }
    .client-avatar {
        height: 32px; width: 32px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.7rem; font-weight: 700;
    }

    /* ---- Badges ---- */
    .badge { font-size: 0.7rem; font-weight: 600; padding: 0.25rem 0.6rem; border-radius: 6px; white-space: nowrap; }
    .badge-green  { background:#f0fdf4; color:#166534; }
    .badge-amber  { background:#fffbeb; color:#92400e; }
    .badge-blue   { background:#eff6ff; color:#1d4ed8; }
    .badge-red    { background:#fef2f2; color:#b91c1c; }
    .badge-slate  { background:#f8fafc; color:#475569; border:1px solid #e2e8f0; }

    /* ---- Pagination UI ---- */
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

{{-- ===== FILTERS ===== --}}
<form method="GET" action="{{ route('admin.dossiers.archives') }}" class="filters-section" id="filterForm">
    <div class="filter-group">
        <label class="filter-label">Rechercher</label>
        <input type="text" name="search" class="filter-input" placeholder="ID, nom, email..." value="{{ request('search') }}">
    </div>
    
    <div class="filter-group">
        <label class="filter-label">Statut</label>
        <select name="status" class="filter-select">
            <option value="">Tous les statuts</option>
            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>En attente</option>
            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>En cours de traitement</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Approuvé</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
        </select>
    </div>
    
    <input type="hidden" name="per_page" value="{{ $perPage }}">

    <div>
        <button type="submit" class="btn-search">
            <svg style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            Rechercher
        </button>
        @if(request()->hasAny(['search', 'status']))
            <a href="{{ route('admin.dossiers.archives') }}" class="btn-reset">
                <svg style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Réinitialiser
            </a>
        @endif
    </div>
</form>

<div class="table-container">

        <div style="overflow-x:auto;">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>ID</th>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dossiers as $d)
                <tr>
                    @php
                        $sv = $d->status->value;
                        $badgeClass = match($sv) {
                            'submitted'  => 'badge-amber',
                            'processing' => 'badge-blue',
                            'completed'  => 'badge-green',
                            default      => 'badge-slate',
                        };
                        $badgeLabel = match($sv) {
                            'submitted'  => 'En attente',
                            'processing' => 'En cours',
                            'completed'  => 'Approuvé',
                            'draft'      => 'Brouillon',
                            default      => $sv,
                        };
                        $colors = ['#e0e7ff:#4f46e5', '#dcfce7:#16a34a', '#fef3c7:#d97706', '#ffe4e6:#e11d48'];
                        $ci = $loop->index % 4;
                        [$bg, $fg] = explode(':', $colors[$ci]);
                    @endphp
                    <td>
                        <div class="ref-code">DOS-{{ substr($d->created_at->format('Y'), -2) }}-{{ str_pad($d->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div class="client-avatar" style="background:{{ $bg }};color:{{ $fg }};">
                                {{ strtoupper(substr($d->prenom ?? 'X', 0, 1).substr($d->nom ?? 'X', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:0.85rem;font-weight:600;color:#0f172a;">{{ $d->prenom ?? '' }} {{ $d->nom ?? '' }}</div>
                                <div style="font-size:0.75rem;color:#64748b;">{{ $d->email ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span style="font-size:0.85rem;font-weight:700;color:#0f172a;">{{ $d->montant ? number_format($d->montant, 0, ',', ' ').' €' : '—' }}</span></td>
                    <td>
                        <div style="font-size:0.8rem; color:#0f172a;">{{ $d->created_at->format('d/m/y H:i') }}</div>
                    </td>
                    <td><span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span></td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <a href="{{ route('admin.dossiers.show', $d) }}" title="Ouvrir le dossier" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; background:#eef2ff; color:#4f46e5; border-radius:6px; border:1px solid #c7d2fe; transition:background 0.2s;">
                                <svg style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                            </a>
                            <button type="button" onclick="event.preventDefault(); if(confirm('Voulez-vous vraiment restaurer ce dossier ?')) document.getElementById('archive-form-{{$d->id}}').submit();" title="Restaurer le dossier" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; background:#f0fdf4; color:#16a34a; border-radius:6px; border:1px solid #bbf7d0; cursor:pointer; transition:background 0.2s;">
                                <svg style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:3rem;color:#94a3b8;font-size:0.9rem;">Aucun dossier archivé.</td></tr>
                @endforelse
            </tbody>
            </table>
        </div>
        </div>
    
    {{-- Pagination Footer --}}
    @if($dossiers->total() > 0)
    <div class="pagination-container">
        <div style="display:flex; align-items:center; gap:10px;">
            Afficher 
            <select id="perPageSelect" class="per-page-select">
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>30</option>
                <option value="40" {{ $perPage == 40 ? 'selected' : '' }}>40</option>
            </select>
            sur {{ $dossiers->total() }} résultats
        </div>
        
        <div class="pagination-links">
            {{ $dossiers->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif
</div>

@foreach($dossiers as $d)
<form id="archive-form-{{ $d->id }}" action="{{ route('admin.dossiers.unarchive', $d) }}" method="POST" style="display:none;">
    @csrf @method('PATCH')
</form>
@endforeach

{!! '<script>
    document.getElementById("perPageSelect").addEventListener("change", function() {
        let form = document.getElementById("filterForm");
        form.querySelector("input[name=\'per_page\']").value = this.value;
        form.submit();
    });
</script>' !!}

{!! '<style>
    /* Styling laravel bootstrap-4 pagination cleanly */
    .pagination { display: flex; list-style: none; padding: 0; margin: 0; gap: 4px; }
    .page-item .page-link, .page-item span {
        padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 600;
        color: #475569; background: #fff;
        border: 1px solid #e2e8f0; border-radius: 6px; text-decoration: none;
        transition: background 0.15s;
    }
    .page-item .page-link:hover { background: #f1f5f9; color: #0f172a; }
    .page-item.active span { background: #4f46e5; color: #fff; border-color: #4f46e5; }
    .page-item.disabled span { opacity: 0.5; cursor: not-allowed; }
</style>' !!}

@endsection
