@extends('admin.layout')
@section('title', 'Suivi des dossiers — QuickCredit Admin')

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
<form method="GET" action="{{ route('admin.dossiers.index') }}" class="filters-section" id="filterForm">
    <div class="filter-group">
        <label class="filter-label">Rechercher</label>
        <input type="text" name="search" class="filter-input" placeholder="ID, nom, email..." value="{{ request('search') }}">
    </div>
    
    <div class="filter-group">
        <label class="filter-label">Statut</label>
        <select name="status" class="filter-select">
            <option value="">Tous les statuts</option>
            <option value="a_qualifier" {{ request('status') === 'a_qualifier' ? 'selected' : '' }}>À Qualifier</option>
            <option value="dossier_conforme" {{ request('status') === 'dossier_conforme' ? 'selected' : '' }}>Dossier Conforme</option>
            <option value="mandat_envoye" {{ request('status') === 'mandat_envoye' ? 'selected' : '' }}>Mandat envoyé</option>
            <option value="offre_emise" {{ request('status') === 'offre_emise' ? 'selected' : '' }}>Offre Émise</option>
            <option value="fonds_decaisses" {{ request('status') === 'fonds_decaisses' ? 'selected' : '' }}>Fonds Décaissés</option>
            <option value="cloture_succes" {{ request('status') === 'cloture_succes' ? 'selected' : '' }}>Clôturé - Succès</option>
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
            <a href="{{ route('admin.dossiers.index') }}" class="btn-reset">
                <svg style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Réinitialiser
            </a>
        @endif
    </div>
</form>

{{-- ===== FLOATING BULK ACTION BAR ===== --}}
<div id="bulk-bar" style="
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%) translateY(120%);
    z-index: 500;
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s ease;
    opacity: 0;
    pointer-events: none;
">
    <form id="bulk-form" method="POST" action="{{ route('admin.dossiers.bulk') }}">
        @csrf
        <div style="
            background: #0f172a;
            border-radius: 16px;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.35), 0 0 0 1px rgba(255,255,255,0.08);
            min-width: 480px;
        ">
            {{-- Counter badge --}}
            <div style="
                background: #4f46e5;
                color: #fff;
                font-size: 0.75rem;
                font-weight: 700;
                padding: 0.3rem 0.65rem;
                border-radius: 8px;
                white-space: nowrap;
                display: flex;
                align-items: center;
                gap: 6px;
            ">
                <svg style="width:13px;height:13px;stroke:currentColor;flex-shrink:0;" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span id="bulk-count">0</span> sélectionnés
            </div>

            {{-- Divider --}}
            <div style="width:1px; height:28px; background:rgba(255,255,255,0.12);"></div>

            {{-- Label --}}
            <span style="font-size:0.8rem; font-weight:600; color:rgba(255,255,255,0.55); white-space:nowrap;">Changer le statut :</span>

            {{-- Select --}}
            <select name="status" required style="
                flex: 1;
                padding: 0.45rem 0.75rem;
                font-size: 0.82rem;
                font-weight: 500;
                border: 1px solid rgba(255,255,255,0.15);
                border-radius: 9px;
                background: rgba(255,255,255,0.08);
                color: #fff;
                outline: none;
                cursor: pointer;
                appearance: none;
                background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23ffffff80' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E\");
                background-repeat: no-repeat;
                background-position: right 10px center;
                padding-right: 30px;
            ">
                <option value="" style="background:#1e293b; color:#fff;">-- Sélectionner --</option>
                <option value="a_qualifier" style="background:#1e293b; color:#fff;">À Qualifier</option>
                <option value="dossier_conforme" style="background:#1e293b; color:#fff;">Dossier Conforme</option>
                <option value="mandat_envoye" style="background:#1e293b; color:#fff;">Mandat envoyé</option>
                <option value="offre_emise" style="background:#1e293b; color:#fff;">Offre Émise</option>
                <option value="fonds_decaisses" style="background:#1e293b; color:#fff;">Fonds Décaissés</option>
                <option value="cloture_succes" style="background:#1e293b; color:#fff;">Clôturé - Succès</option>
                <option value="draft" style="background:#1e293b; color:#fff;">Brouillon</option>
            </select>

            {{-- Submit --}}
            <button type="submit" style="
                background: #4f46e5;
                color: #fff;
                border: none;
                padding: 0.5rem 1.1rem;
                border-radius: 9px;
                font-weight: 700;
                font-size: 0.82rem;
                cursor: pointer;
                white-space: nowrap;
                transition: background 0.2s;
                display: flex;
                align-items: center;
                gap: 6px;
            " onmouseover="this.style.background='#4338ca'" onmouseout="this.style.background='#4f46e5'">
                <svg style="width:14px;height:14px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                Appliquer
            </button>

            {{-- Dismiss --}}
            <button type="button" onclick="clearSelection()" style="
                background: rgba(255,255,255,0.08);
                color: rgba(255,255,255,0.6);
                border: 1px solid rgba(255,255,255,0.12);
                width: 32px; height: 32px;
                border-radius: 8px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transition: all 0.2s;
            " onmouseover="this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.background='rgba(255,255,255,0.08)'" title="Désélectionner tout">
                <svg style="width:14px;height:14px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </form>
</div>

{{-- ===== TABLE ===== --}}
<div class="table-container">
    <div>

        <div style="overflow-x:auto;">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th style="width:40px;"><input type="checkbox" id="selectAll" onclick="toggleSelectAll()"></th>
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
                    <td><input type="checkbox" name="ids[]" value="{{ $d->id }}" class="dossier-checkbox"></td>
                    @php
                        $sv = $d->status->value;
                        $badgeClass = match($sv) {
                            'a_qualifier'       => 'badge-amber',
                            'dossier_conforme'  => 'badge-blue',
                            'mandat_envoye'     => 'badge-blue',
                            'offre_emise'       => 'badge-green',
                            'fonds_decaisses'   => 'badge-green',
                            'cloture_succes'    => 'badge-slate',
                            default             => 'badge-slate',
                        };
                        $badgeLabel = match($sv) {
                            'a_qualifier'       => 'À Qualifier',
                            'dossier_conforme'  => 'Dossier Conforme',
                            'mandat_envoye'     => 'Mandat Envoyé',
                            'offre_emise'       => 'Offre Émise',
                            'fonds_decaisses'   => 'Fonds Décaissés',
                            'cloture_succes'    => 'Clôturé',
                            'draft'             => 'Brouillon',
                            default             => $sv,
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
                            <button type="button" onclick="openArchiveModal('{{$d->id}}', 'DOS-{{ substr($d->created_at->format('Y'), -2) }}-{{ str_pad($d->id, 4, '0', STR_PAD_LEFT) }}')" title="Archiver le dossier" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; background:#fef2f2; color:#b91c1c; border-radius:6px; border:1px solid #fecaca; cursor:pointer; transition:background 0.2s;">
                                <svg style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H2.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" /></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;padding:3rem;color:#94a3b8;font-size:0.9rem;">Aucun dossier trouvé pour ces critères.</td></tr>
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
<form id="archive-form-{{ $d->id }}" action="{{ route('admin.dossiers.archive', $d) }}" method="POST" style="display:none;">
    @csrf @method('PATCH')
</form>
@endforeach

{{-- Archive Modal --}}
<div id="archiveModal" class="modal-overlay" style="display:none;">
    <div class="modal-box fade-in-up">
        <div class="modal-icon-wrapper">
            <div class="modal-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H2.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
            </div>
        </div>
        <h3 class="modal-title">Archiver le dossier</h3>
        <p class="modal-desc">Voulez-vous vraiment archiver le dossier <strong id="modalDossierRef" style="color:#0f172a;"></strong> ?<br>Cette action le déplacera vers vos archives.</p>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeArchiveModal()">Annuler</button>
            <button type="button" class="btn-confirm-archive" onclick="submitArchiveForm()">Oui, Archiver</button>
        </div>
    </div>
</div>

{!! '<script>
    let currentArchiveId = null;

    // ---- Bulk bar logic ----
    function updateBulkBar() {
        const checked = document.querySelectorAll(".dossier-checkbox:checked");
        const bar = document.getElementById("bulk-bar");
        const count = checked.length;

        document.getElementById("bulk-count").innerText = count;

        if (count >= 2) {
            bar.style.transform = "translateX(-50%) translateY(0)";
            bar.style.opacity = "1";
            bar.style.pointerEvents = "auto";
        } else {
            bar.style.transform = "translateX(-50%) translateY(120%)";
            bar.style.opacity = "0";
            bar.style.pointerEvents = "none";
        }

        // sync select-all checkbox state
        const all = document.querySelectorAll(".dossier-checkbox");
        const selectAll = document.getElementById("selectAll");
        if (count === 0) {
            selectAll.checked = false;
            selectAll.indeterminate = false;
        } else if (count === all.length) {
            selectAll.checked = true;
            selectAll.indeterminate = false;
        } else {
            selectAll.checked = false;
            selectAll.indeterminate = true;
        }
    }

    function clearSelection() {
        document.querySelectorAll(".dossier-checkbox").forEach(cb => cb.checked = false);
        document.getElementById("selectAll").checked = false;
        document.getElementById("selectAll").indeterminate = false;
        updateBulkBar();
    }

    function toggleSelectAll() {
        const selectAll = document.getElementById("selectAll");
        const checkboxes = document.querySelectorAll(".dossier-checkbox");
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
        updateBulkBar();
    }

    // Attach listeners to each checkbox
    document.querySelectorAll(".dossier-checkbox").forEach(cb => {
        cb.addEventListener("change", updateBulkBar);
    });

    // ---- Archive modal ----
    function openArchiveModal(id, ref) {
        currentArchiveId = id;
        document.getElementById("modalDossierRef").innerText = ref;
        document.getElementById("archiveModal").style.display = "flex";
    }

    function closeArchiveModal() {
        currentArchiveId = null;
        document.getElementById("archiveModal").style.display = "none";
    }

    function submitArchiveForm() {
        if(currentArchiveId) {
            document.getElementById("archive-form-" + currentArchiveId).submit();
        }
    }

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
        padding: 0.3rem 0.6rem; font-size: 0.8rem; font-weight: 600;
        color: #475569; background: #fff; border: 1px solid #e2e8f0; border-radius: 4px; text-decoration: none;
    }
    .page-item .page-link:hover { background: #f8fafc; color: #0f172a; }
    .page-item.active span { background: #000; color: #fff; border-color: #000; }
    .page-item.disabled span { opacity: 0.5; cursor: not-allowed; }

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
