@extends('admin.layout')
@section('title', 'Aperçu de l\'Approbation - '.$application->reference)

@section('content')

{!! '<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
    .breadcrumb { font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; }
    .breadcrumb a { color: #64748b; text-decoration: none; transition: color 0.2s; }
    .breadcrumb a:hover { color: #0f172a; }
    .page-title { font-size: 1.6rem; font-weight: 800; color: #0f172a; }
    
    .grid-container { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: start; height: calc(100vh - 180px); min-height: 800px; }
    .col-left { display: flex; flex-direction: column; gap: 1.5rem; height: 100%; overflow-y: auto; padding-right: 10px; }
    .col-right { height: 100%; }

    .card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; display: flex; flex-direction: column; }
    .card-header { padding: 1rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 10px; background: #f8fafc; }
    .card-title { font-size: 1rem; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 8px; }
    .card-body { padding: 1.5rem; flex: 1; }

    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 0.5rem; }
    .form-control { width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem; border: 1px solid #cbd5e1; border-radius: 8px; color: #0f172a; transition: border-color 0.2s; font-family: inherit; }
    .form-control:focus { border-color: #4f46e5; outline: none; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
    textarea.form-control { resize: vertical; min-height: 180px; line-height: 1.5; }
    
    .input-group { display: flex; align-items: center; }
    .input-group .form-control { border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; }
    .input-group-append { padding: 0.75rem 1rem; background: #f1f5f9; border: 1px solid #cbd5e1; border-left: none; border-top-right-radius: 8px; border-bottom-right-radius: 8px; color: #64748b; font-weight: 600; font-size: 0.95rem; }

    .btn-submit {
        width: 100%; padding: 1rem; background: #16a34a; color: #fff; border: none; border-radius: 8px;
        font-size: 1rem; font-weight: 700; cursor: pointer; transition: background 0.2s; display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 1.5rem;
    }
    .btn-submit:hover { background: #15803d; }
    .btn-cancel {
        display: inline-flex; justify-content: center; align-items: center; padding: 0.75rem 1rem; color: #64748b; background: #f1f5f9; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.2s; width: 100%; text-align: center; margin-top: 10px;
    }
    .btn-cancel:hover { background: #e2e8f0; color: #334155; }
    
    .summary-box { background: #fef2f2; border: 1px solid #fecaca; padding: 1rem; border-radius: 8px; margin-top: 1.5rem; }
    .summary-title { font-size: 0.85rem; font-weight: 700; color: #991b1b; margin-bottom: 0.5rem; text-transform: uppercase; }
    .summary-value { font-size: 1.25rem; font-weight: 800; color: #7f1d1d; }

    .tabs { display: none; } /* removed tabs */
    .preview-frame { width: 100%; border: none; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0; }
</style>' !!}

<div class="page-header">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.dossiers.index') }}">Dossiers</a> / 
            <a href="{{ route('admin.dossiers.show', $application) }}">{{ $application->reference }}</a> / 
            Approbation
        </div>
        <div class="page-title">Valider l\'Offre de Prêt</div>
    </div>
</div>

<form method="POST" action="{{ route('admin.dossiers.approve.confirm', $application) }}" style="height: 100%;">
    @csrf
    <div class="grid-container">
        
        <!-- Left Column: Form -->
        <div class="col-left">
            <div class="card" style="flex:none;">
                <div class="card-header">
                    <div class="card-title">
                        <svg style="width:20px;height:20px;color:#4f46e5;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Conditions du Contrat
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="montant">Montant du crédit</label>
                        <div class="input-group">
                            <input type="number" id="montant" name="montant" class="form-control" value="{{ old('montant', $application->montant) }}" min="100" step="100" required>
                            <span class="input-group-append">€</span>
                        </div>
                    </div>

                    <div class="form-group" style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div>
                            <label class="form-label" for="duree_mois">Durée</label>
                            <div class="input-group">
                                <input type="number" id="duree_mois" name="duree_mois" class="form-control" value="{{ old('duree_mois', $application->duree_mois) }}" min="1" max="120" required>
                                <span class="input-group-append">mois</span>
                            </div>
                        </div>
                        <div>
                            <label class="form-label" for="taux_annuel">Taux (TAEG)</label>
                            <div class="input-group">
                                <input type="number" id="taux_annuel" name="taux_annuel" class="form-control" value="{{ old('taux_annuel', $application->taux_annuel) }}" min="0" step="0.01" required>
                                <span class="input-group-append">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="summary-box">
                        <div class="summary-title">Mensualité Estimée</div>
                        <div class="summary-value" id="mensualite-preview">{{ number_format($application->mensualite, 2, ',', ' ') }} €</div>
                    </div>
                </div>
            </div>

            <div class="card" style="flex:none;">
                <div class="card-header">
                    <div class="card-title">
                        <svg style="width:20px;height:20px;color:#4f46e5;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Message de l\'E-mail
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group" style="margin-bottom:0;">
                        <textarea id="custom_message" name="custom_message" class="form-control" required>{{ old('custom_message', $defaultMessage) }}</textarea>
                    </div>
                </div>
            </div>

            <div style="margin-top:auto;">
                <button type="submit" class="btn-submit">
                    <svg style="width:20px;height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Confirmer et envoyer
                </button>
                <a href="{{ route('admin.dossiers.show', $application) }}" class="btn-cancel">Annuler</a>
            </div>
        </div>

        <!-- Right Column: Visual Previews -->
        <div class="col-right card" style="height: 100%;">
            <div class="card-header" style="justify-content: space-between;">
                <div class="card-title">Aperçu en direct (E-mail et Contrat)</div>
            </div>
            <div class="card-body" style="padding: 1rem; position: relative; display: flex; flex-direction: column; gap: 1.5rem; overflow-y: auto;">
                
                <div id="loading-overlay" style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.8); display:flex; align-items:center; justify-content:center; z-index:10; border-radius:8px; display:none;">
                    <div style="color:#4f46e5; font-weight:600; display:flex; align-items:center; gap:8px;">
                        <svg style="width:24px;height:24px; animation:spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Mise à jour...
                    </div>
                </div>

                <div style="display: flex; flex-direction: column;">
                    <div style="font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 0.5rem; display:flex; justify-content:space-between; align-items:center;">
                        <span>Prévisualisation de l'E-mail</span>
                    </div>
                    <iframe id="frame-email" class="preview-frame" style="height: 350px;"></iframe>
                </div>

                <div style="display: flex; flex-direction: column; flex: 1;">
                    <div style="font-size: 0.85rem; font-weight: 700; color: #334155; margin-bottom: 0.5rem; display:flex; justify-content:space-between; align-items:center;">
                        <span>Contrat de Prêt (PDF)</span>
                        <a id="download-pdf-btn" href="#" target="_blank" style="font-size: 0.75rem; background: #eef2ff; color: #4f46e5; padding: 0.3rem 0.6rem; border-radius: 6px; text-decoration: none; font-weight: 600;">Télécharger le brouillon</a>
                    </div>
                    <iframe id="frame-pdf" class="preview-frame" style="height: 500px; flex-shrink: 0;"></iframe>
                </div>
            </div>
        </div>
        
    </div>
</form>

{!! '<style>@keyframes spin { from { transform:rotate(0deg); } to { transform:rotate(360deg); } }</style>' !!}

<script>
    let debounceTimer;
    const applicationId = "{{ $application->id }}";
    const baseURL = "{{ url('/') }}";
    
    function getFormValues() {
        return {
            montant: document.getElementById('montant').value,
            duree_mois: document.getElementById('duree_mois').value,
            taux_annuel: document.getElementById('taux_annuel').value,
            message: document.getElementById('custom_message').value
        };
    }

    // tab logic removed

    function refreshPreviews() {
        const v = getFormValues();
        
        // Calcul mensualité en direct
        const m = parseFloat(v.montant) || 0;
        const d = parseInt(v.duree_mois) || 0;
        const t = parseFloat(v.taux_annuel) || 0;
        let mensualite = 0;
        if (m > 0 && d > 0) {
            if (t > 0) {
                const tx = (t / 100) / 12;
                mensualite = (m * tx) / (1 - Math.pow(1 + tx, -d));
            } else {
                mensualite = m / d;
            }
        }
        document.getElementById('mensualite-preview').innerText = mensualite.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';

        // Actualisation des iframes
        document.getElementById('loading-overlay').style.display = 'flex';
        
        const paramsPdf = new URLSearchParams({ montant: v.montant, duree_mois: v.duree_mois, taux_annuel: v.taux_annuel });
        const paramsEmail = new URLSearchParams({ message: v.message });

        const pdfUrl = `${baseURL}/admin/dossiers/{{ $application->id }}/preview/pdf?${paramsPdf.toString()}`;
        document.getElementById('frame-pdf').src = `${pdfUrl}#toolbar=1&navpanes=0`;
        document.getElementById('download-pdf-btn').href = pdfUrl;
        
        document.getElementById('frame-email').src = `${baseURL}/admin/dossiers/{{ $application->id }}/preview/email?${paramsEmail.toString()}`;
        
        // Hide loader after a short delay assuming iframe started loading
        setTimeout(() => {
            document.getElementById('loading-overlay').style.display = 'none';
        }, 1200);
    }

    function debouncedRefresh() {
        clearTimeout(debounceTimer);
        document.getElementById('loading-overlay').style.display = 'flex';
        debounceTimer = setTimeout(refreshPreviews, 800);
    }

    // Attach listeners
    ['montant', 'duree_mois', 'taux_annuel', 'custom_message'].forEach(id => {
        document.getElementById(id).addEventListener('input', debouncedRefresh);
    });

    // Initial load
    window.addEventListener('DOMContentLoaded', refreshPreviews);
</script>

@endsection
