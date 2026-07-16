@extends('admin.layout')
@section('title', 'Dossier '.$application->reference)

@section('content')

{!! '<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
    .breadcrumb { font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; }
    .breadcrumb a { color: #64748b; text-decoration: none; transition: color 0.2s; }
    .breadcrumb a:hover { color: #0f172a; }
    .page-title { font-size: 1.6rem; font-weight: 800; color: #0f172a; }
    
    .btn-outline {
        padding: 0.5rem 1rem; background: #fff; color: #334155; font-size: 0.85rem; font-weight: 600;
        border: 1px solid #e2e8f0; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
    }
    .btn-outline:hover { background: #f8fafc; }

    .status-bar {
        display: flex; align-items: center; justify-content: space-between;
        background: #fff; padding: 1rem 1.5rem; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 1.5rem;
    }
    
    .status-badge {
        display: inline-flex; align-items: center; gap: 6px; padding: 0.3rem 0.8rem;
        border-radius: 8px; font-size: 0.75rem; font-weight: 700; border: 1px solid transparent;
    }
    .status-badge.submitted { background: #fffbeb; color: #b45309; border-color: #fde68a; }
    .status-badge.processing { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
    .status-badge.completed { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
    .status-badge.draft { background: #f8fafc; color: #475569; border-color: #e2e8f0; }

    .dossier-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start; }
    .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 1.5rem; }
    .card-header { padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 10px; }
    .card-title { font-size: 0.95rem; font-weight: 700; color: #0f172a; }
    .card-body { padding: 1.5rem; }
    
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .info-item .label { font-size: 0.7rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px; }
    .info-item .value { font-size: 0.9rem; font-weight: 600; color: #0f172a; }

    .doc-list { list-style: none; margin: 0; padding: 0; }
    .doc-item {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9;
    }
    .doc-item:last-child { border-bottom: none; }
    .doc-item:hover { background: #f8fafc; }
    .doc-left { display: flex; align-items: center; gap: 12px; }
    .doc-icon { width: 36px; height: 36px; border-radius: 8px; background: #eef2ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; }
    .doc-name { font-size: 0.85rem; font-weight: 600; color: #0f172a; }
    .doc-meta { font-size: 0.7rem; color: #64748b; margin-top: 2px; }
    .btn-download {
        background: #0f172a; color: #fff; padding: 0.4rem 0.8rem; border-radius: 6px;
        font-size: 0.75rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    }
    
    .detail-row { display: flex; justify-content: space-between; margin-bottom: 1rem; align-items: center; }
    .detail-row:last-child { margin-bottom: 0; }
    .detail-label { font-size: 0.8rem; color: #64748b; }
    .detail-val { font-size: 0.9rem; font-weight: 700; color: #0f172a; }

    .status-btn {
        padding: 0.4rem 1rem; border-radius: 6px; border: none; background: transparent;
        font-size: 0.75rem; font-weight: 700; color: #64748b; cursor: pointer; transition: all 0.2s;
    }
    .status-btn:hover:not([class*="active-"]) { background: #e2e8f0; color: #0f172a; }
    
    .status-btn.active-submitted { background: #fff; color: #d97706; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .status-btn.active-processing { background: #fff; color: #2563eb; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .status-btn.active-approved   { background: #fff; color: #16a34a; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .status-btn.active-completed  { background: #fff; color: #475569; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .status-badge.approved { background: #dcfce7; color: #15803d; border-color: #86efac; }
</style>' !!}

<div class="page-header">
    <div>
        <div class="page-title">{{ $application->reference }}</div>
    </div>
</div>

@php
    $statusValue = $application->status->value;
    $statusConfig = [
        'a_qualifier'       => ['label' => 'À Qualifier',       'class' => 'submitted'],
        'dossier_conforme'  => ['label' => 'Dossier Conforme',  'class' => 'processing'],
        'mandat_envoye'     => ['label' => 'Mandat Envoyé',     'class' => 'processing'],
        'offre_emise'       => ['label' => 'Offre Émise',       'class' => 'approved'],
        'fonds_decaisses'   => ['label' => 'Fonds Décaissés',   'class' => 'approved'],
        'cloture_succes'    => ['label' => 'Clôturé',           'class' => 'completed'],
        'draft'             => ['label' => 'Brouillon',         'class' => 'draft'],
    ];
    $sc = $statusConfig[$statusValue] ?? ['label' => $statusValue, 'class' => 'draft'];
@endphp

<div class="status-bar">
    <div style="display:flex; align-items:center; gap:15px;">
        <span class="status-badge {{ $sc['class'] }}">
            <span style="width:6px;height:6px;border-radius:50%;background:currentColor;"></span>
            {{ $sc['label'] }}
        </span>
        <span style="font-size:0.8rem; color:#64748b;">Soumis le {{ $application->submitted_at?->format('d/m/Y à H:i') ?? $application->created_at->format('d/m/Y à H:i') }}</span>
    </div>
    
    @if (Auth::user()->isAdmin())
    <div style="display:flex; align-items:center; gap:12px;">
        <div style="display:flex; background:#f1f5f9; padding:4px; border-radius:8px; gap:4px; border:1px solid #e2e8f0;">
            <form method="POST" action="{{ route('admin.dossiers.status.update', $application) }}" style="margin:0;">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="a_qualifier">
                <button type="submit" class="status-btn {{ $statusValue === 'a_qualifier' ? 'active-submitted' : '' }}">À Qualifier</button>
            </form>
            <form method="POST" action="{{ route('admin.dossiers.status.update', $application) }}" style="margin:0;">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="dossier_conforme">
                <button type="submit" class="status-btn {{ $statusValue === 'dossier_conforme' ? 'active-processing' : '' }}">Dossier Conforme</button>
            </form>
            <a href="{{ route('admin.dossiers.approve.preview', $application) }}" class="status-btn {{ in_array($statusValue, ['offre_emise', 'fonds_decaisses']) ? 'active-approved' : '' }}" style="text-decoration:none; display:inline-flex; align-items:center;" title="Aperçu et approbation finale du contrat">
                ✓ Générer Offre
            </a>
            <form method="POST" action="{{ route('admin.dossiers.status.update', $application) }}" style="margin:0;">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="cloture_succes">
                <button type="submit" class="status-btn {{ $statusValue === 'cloture_succes' ? 'active-completed' : '' }}">Clôturé</button>
            </form>
        </div>
    </div>
    @endif
</div>

<div class="dossier-grid">
    <div class="col-left">
        <div class="card">
            <div class="card-header">
                <div style="width:28px;height:28px;background:#eef2ff;color:#4f46e5;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                </div>
                <div class="card-title">Informations personnelles</div>
            </div>
            <div class="card-body info-grid">
                <div class="info-item">
                    <div class="label">Nom complet</div>
                    <div class="value">{{ trim($application->prenom.' '.$application->nom) ?: '—' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Email</div>
                    <div class="value">
                        @if($application->email)
                            <a href="mailto:{{ $application->email }}" style="color:#4f46e5; text-decoration:none;">{{ $application->email }}</a>
                        @else — @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="label">Téléphone</div>
                    <div class="value">{{ $application->telephone ?: '—' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Date de naissance</div>
                    <div class="value">{{ $application->date_naissance ? \Carbon\Carbon::parse($application->date_naissance)->format('d/m/Y') : '—' }}</div>
                </div>
                <div class="info-item" style="grid-column: span 2;">
                    <div class="label">Adresse</div>
                    <div class="value">{{ $application->adresse ? $application->adresse . ', ' . $application->code_postal . ' ' . $application->ville : '—' }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Situation professionnelle</div>
                    <div class="value">{{ $application->situation_pro ?: '—' }}</div>
                </div>
            </div>
        </div>

        @if (Auth::user()->isAdmin())
        <div class="card">
            <div class="card-header" style="justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:28px;height:28px;background:#f1f5f9;color:#475569;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                        <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    </div>
                    <div class="card-title">Documents fournis</div>
                </div>
                <span style="font-size:0.75rem;font-weight:700;color:#64748b;background:#f8fafc;padding:0.2rem 0.6rem;border-radius:12px;border:1px solid #e2e8f0;">
                    {{ $application->documents->count() }} fichier(s)
                </span>
            </div>
            
            @if ($application->documents->isEmpty())
                <div style="padding:2.5rem 1.5rem; text-align:center;">
                    <div style="width:48px;height:48px;background:#f1f5f9;color:#94a3b8;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                        <svg style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    </div>
                    <p style="font-size:0.85rem;color:#64748b;">Aucun document fourni pour ce dossier.</p>
                </div>
            @else
                <ul class="doc-list">
                    @foreach ($application->documents as $document)
                    <li class="doc-item">
                        <div class="doc-left">
                            <div class="doc-icon">
                                <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                            </div>
                            <div>
                                <div class="doc-name">{{ $document->type instanceof \App\Enums\DocumentType ? $document->type->label() : ucfirst(str_replace('_', ' ', $document->type)) }}</div>
                                <div class="doc-meta">{{ $document->original_filename }} • {{ number_format($document->size_bytes / 1024, 1, ',', ' ') }} KB</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.documents.download', [$application, $document]) }}" class="btn-download">
                            <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                            Télécharger
                        </a>
                    </li>
                    @endforeach
                </ul>
            @endif
        </div>
        @endif
        
        {{-- ===== SECTION NOTES ===== --}}
        <div class="card" style="margin-top: 1.5rem;">
            <div class="card-header">
                <div class="card-title">Notes internes (Dossier)</div>
            </div>
            <div class="card-body">
                <div style="max-height:300px; overflow-y:auto; padding-right:10px; margin-bottom:15px; display:flex; flex-direction:column; gap:12px;">
                    @forelse($application->notes as $note)
                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:12px;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                            <span style="font-weight:600; font-size:0.8rem; color:#0f172a;">{{ $note->user->name ?? 'Admin' }}</span>
                            <span style="font-size:0.75rem; color:#64748b;">{{ $note->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div style="font-size:0.85rem; color:#334155; line-height:1.5;">
                            {{ $note->note }}
                        </div>
                    </div>
                    @empty
                    <div style="text-align:center; color:#94a3b8; font-size:0.85rem; padding:1rem 0;">Aucune note pour ce dossier.</div>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('admin.dossiers.notes.store', $application) }}" style="display:flex; gap:10px; margin-top:10px;">
                    @csrf
                    <input type="text" name="note" placeholder="Ajouter une note..." style="flex:1; padding:0.6rem; border:1px solid #e2e8f0; border-radius:8px; outline:none; font-size:0.85rem;" required>
                    <button type="submit" style="background:#4f46e5; color:#fff; border:none; padding:0 1rem; border-radius:8px; font-weight:600; cursor:pointer;">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-right">
        <!-- NOUVEL ENCART DE CHANGEMENT DE STATUT -->
        <div class="card" style="border: 2px solid #eef2ff;">
            <div class="card-header" style="background:#eef2ff;">
                <div style="width:28px;height:28px;background:#4f46e5;color:#fff;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                </div>
                <div class="card-title" style="color:#3730a3;">Changer le statut</div>
            </div>
            <div class="card-body" style="display:flex; flex-direction:column; gap:8px;">
                <form method="POST" action="{{ route('admin.dossiers.status.update', $application) }}" style="margin:0;">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="a_qualifier">
                    <button type="submit" style="width:100%; text-align:left; padding:10px; border-radius:8px; border:1px solid {{ $statusValue === 'a_qualifier' ? '#d97706' : '#e2e8f0' }}; background:{{ $statusValue === 'a_qualifier' ? '#fffbeb' : '#fff' }}; color:{{ $statusValue === 'a_qualifier' ? '#d97706' : '#64748b' }}; font-weight:600; cursor:pointer; transition:all 0.2s;">
                        À Qualifier
                    </button>
                </form>
                
                <form method="POST" action="{{ route('admin.dossiers.status.update', $application) }}" style="margin:0;">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="dossier_conforme">
                    <button type="submit" style="width:100%; text-align:left; padding:10px; border-radius:8px; border:1px solid {{ $statusValue === 'dossier_conforme' ? '#2563eb' : '#e2e8f0' }}; background:{{ $statusValue === 'dossier_conforme' ? '#eff6ff' : '#fff' }}; color:{{ $statusValue === 'dossier_conforme' ? '#1d4ed8' : '#64748b' }}; font-weight:600; cursor:pointer; transition:all 0.2s;">
                        Dossier Conforme
                    </button>
                </form>

                <a href="{{ route('admin.dossiers.approve.preview', $application) }}" style="display:block; width:100%; text-align:left; padding:10px; border-radius:8px; border:1px solid {{ in_array($statusValue, ['offre_emise', 'fonds_decaisses']) ? '#16a34a' : '#e2e8f0' }}; background:{{ in_array($statusValue, ['offre_emise', 'fonds_decaisses']) ? '#ecfdf5' : '#fff' }}; color:{{ in_array($statusValue, ['offre_emise', 'fonds_decaisses']) ? '#15803d' : '#64748b' }}; font-weight:600; cursor:pointer; transition:all 0.2s; text-decoration:none;">
                    ✓ Générer Offre / Approuver
                </a>

                <form method="POST" action="{{ route('admin.dossiers.status.update', $application) }}" style="margin:0;">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="cloture_succes">
                    <button type="submit" style="width:100%; text-align:left; padding:10px; border-radius:8px; border:1px solid {{ $statusValue === 'cloture_succes' ? '#475569' : '#e2e8f0' }}; background:{{ $statusValue === 'cloture_succes' ? '#f8fafc' : '#fff' }}; color:{{ $statusValue === 'cloture_succes' ? '#475569' : '#64748b' }}; font-weight:600; cursor:pointer; transition:all 0.2s;">
                        Clôturé - Succès
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div style="width:28px;height:28px;background:#dcfce7;color:#16a34a;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </div>
                <div class="card-title">Détails du crédit</div>
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <span class="detail-label">Montant</span>
                    <span class="detail-val">{{ $application->montant ? number_format($application->montant, 0, ',', ' ') . ' €' : '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Durée</span>
                    <span class="detail-val">{{ $application->duree_mois ? $application->duree_mois . ' mois' : '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Taux annuel</span>
                    <span class="detail-val">{{ $application->taux_annuel ? number_format($application->taux_annuel, 2, ',', ' ') . ' %' : '—' }}</span>
                </div>
                <div class="detail-row" style="margin-top:1rem; padding-top:1rem; border-top:1px solid #f1f5f9;">
                    <span class="detail-label" style="font-weight:700;">Mensualité</span>
                    <span class="detail-val" style="font-size:1.1rem; color:#4f46e5;">{{ $application->mensualite ? number_format($application->mensualite, 2, ',', ' ') . ' €' : '—' }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div style="width:28px;height:28px;background:#f1f5f9;color:#64748b;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>
                </div>
                <div class="card-title">Informations système</div>
            </div>
            <div class="card-body">
                <div style="margin-bottom:1rem;">
                    <div style="font-size:0.75rem;color:#64748b;margin-bottom:2px;">Référence</div>
                    <div style="font-size:0.85rem;font-weight:700;font-family:monospace;color:#0f172a;">{{ $application->reference }}</div>
                </div>
                <div style="margin-bottom:1rem;">
                    <div style="font-size:0.75rem;color:#64748b;margin-bottom:2px;">Étape de traitement</div>
                    <div style="font-size:0.85rem;font-weight:600;color:#0f172a;">{{ $application->processing_step ?: '—' }}</div>
                </div>
                <div style="margin-bottom:1rem;">
                    <div style="font-size:0.75rem;color:#64748b;margin-bottom:4px;">Consentements</div>
                    <div style="display:flex;flex-wrap:wrap;gap:6px;">
                        @foreach([1,2,3] as $i)
                            @if($application->{'consent_'.$i})
                                <span style="font-size:0.7rem;font-weight:600;color:#047857;background:#ecfdf5;border:1px solid #a7f3d0;padding:0.2rem 0.5rem;border-radius:6px;">Consent. {{ $i }}</span>
                            @endif
                        @endforeach
                        @if(!$application->consent_1 && !$application->consent_2 && !$application->consent_3)
                            <span style="font-size:0.75rem;color:#64748b;">Aucun</span>
                        @endif
                    </div>
                </div>
                <div style="margin-top:1rem; padding-top:1rem; border-top:1px solid #f1f5f9;">
                    <div style="margin-bottom:0.5rem;">
                        <div style="font-size:0.75rem;color:#64748b;">Date de soumission</div>
                        <div style="font-size:0.85rem;font-weight:600;color:#0f172a;">{{ $application->submitted_at?->format('d/m/Y à H:i') ?: '—' }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.75rem;color:#64748b;">Date de création</div>
                        <div style="font-size:0.85rem;font-weight:600;color:#0f172a;">{{ $application->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
