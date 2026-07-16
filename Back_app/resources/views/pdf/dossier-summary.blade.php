<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Récapitulatif {{ $application->reference }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 220px 40px 80px; }
        body { font-family: 'Helvetica Neue', Arial, sans-serif; font-size: 11px; color: #333; background: #f5f5f5; line-height: 1.4; }

        /* Absolute header placed in the document so it appears only on the first page. */
        .header-abs {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 200px;
            z-index: 1000;
            overflow: hidden;
        }
        .header-abs .bg {
            position: absolute; inset: 0;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            filter: none;
        }
        .header-abs .overlay {
            position: absolute; inset: 0;
            background: rgba(95, 39, 205, 0.45); /* purple overlay, semi-transparent */
        }
        .header-abs .logo {
            position: absolute;
            left: 40px;
            top: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-weight: 700;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .header-abs .logo img { height: 46px; width: auto; display: block; border-radius: 50%; background: rgba(255,255,255,0.12); padding: 6px; }

        .header-abs .header-content {
            position: absolute;
            left: 40px;
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="utf-8">
                <title>Récapitulatif {{ $application->reference }}</title>
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; }

                    @page {
                        margin: 0;
                        size: A4;
                    }

                    body {
                        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                        font-size: 10px;
                        color: #1a1a2e;
                        background: #ffffff;
                        line-height: 1.5;
                    }

                    /* ─── HEADER ─────────────────────────────────────────────────── */
                    .page-header {
                        width: 100%;
                        height: 190px;
                        background: #1a1a2e;
                        position: relative;
                        overflow: hidden;
                        display: block;
                    }

                    /* diagonal accent stripe */
                    .page-header::before {
                        content: '';
                        position: absolute;
                        top: 0; right: -60px;
                        width: 320px; height: 100%;
                        background: #5f27cd; /* replaced green with brand purple */
                        transform: skewX(-12deg);
                        z-index: 1;
                    }
                    /* second lighter stripe */
                    .page-header::after {
                        content: '';
                        position: absolute;
                        top: 0; right: 180px;
                        width: 18px; height: 100%;
                        background: rgba(95,39,205,0.28); /* lighter purple */
                        transform: skewX(-12deg);
                        z-index: 2;
                    }

                    .header-inner {
                        position: relative;
                        z-index: 10;
                        height: 100%;
                        display: flex;
                        align-items: stretch;
                    }

                    /* Left block – brand + title */
                    .header-left {
                        flex: 1;
                        padding: 28px 32px;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                    }

                    .brand-row {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }
                    .brand-logo {
                        width: 36px; height: 36px;
                        border-radius: 8px;
                        background: rgba(255,255,255,0.12);
                        border: 1px solid rgba(255,255,255,0.22);
                        display: flex; align-items: center; justify-content: center;
                        overflow: hidden;
                    }
                    .brand-logo img { width: 100%; height: 100%; object-fit: contain; }
                    .brand-name {
                        font-size: 11px;
                        font-weight: 700;
                        letter-spacing: 0.18em;
                        text-transform: uppercase;
                        color: rgba(255,255,255,0.75);
                    }

                    .header-doc-type {
                        font-size: 9px;
                        font-weight: 700;
                        letter-spacing: 0.22em;
                        text-transform: uppercase;
                        color: #5f27cd; /* purple */
                        margin-bottom: 4px;
                    }
                    .header-title {
                        font-size: 34px;
                        font-weight: 900;
                        line-height: 1;
                        color: #ffffff;
                        letter-spacing: -0.01em;
                    }
                    .header-title span {
                        display: block;
                        color: #5f27cd;
                    }

                    /* Right block – reference card */
                    .header-right {
                        width: 230px;
                        display: flex;
                        flex-direction: column;
                        justify-content: flex-end;
                        padding: 0 32px 28px 0;
                        position: relative;
                        z-index: 20;
                    }

                    .ref-card {
                        background: rgba(255,255,255,0.08);
                        border: 1px solid rgba(255,255,255,0.18);
                        border-radius: 10px;
                        padding: 14px 16px;
                    }
                    .ref-card-label {
                        font-size: 7.5px;
                        letter-spacing: 0.2em;
                        text-transform: uppercase;
                        color: rgba(255,255,255,0.6);
                        margin-bottom: 5px;
                    }
                    .ref-card-value {
                        font-size: 15px;
                        font-weight: 800;
                        color: #ffffff;
                        letter-spacing: 0.04em;
                    }
                    .ref-card-sub {
                        margin-top: 10px;
                        padding-top: 10px;
                        border-top: 1px solid rgba(255,255,255,0.14);
                        font-size: 8px;
                        color: rgba(255,255,255,0.55);
                        letter-spacing: 0.04em;
                    }
                    .ref-card-sub strong {
                        color: #5f27cd;
                        font-weight: 700;
                    }

                    /* ─── PAGE BODY ────────────────────────────────────────────────── */
                    .page-body {
                        padding: 28px 32px 40px;
                        background: #f7f8fb;
                        min-height: calc(100% - 190px);
                    }

                    /* ─── SECTION BLOCKS ───────────────────────────────────────────── */
                    .section {
                        background: #ffffff;
                        border-radius: 10px;
                        overflow: hidden;
                        margin-bottom: 18px;
                        border: 1px solid #e2e8f0;
                        box-shadow: 0 2px 8px rgba(16,24,40,0.05);
                    }

                    .section-header {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 11px 18px;
                        border-bottom: 2px solid #5f27cd;
                        background: #ffffff;
                    }
                    .section-icon {
                        width: 28px; height: 28px;
                        border-radius: 7px;
                        background: #f5f3ff;
                        border: 1px solid #e6dbff;
                        display: flex; align-items: center; justify-content: center;
                        font-size: 14px;
                        flex-shrink: 0;
                    }
                    .section-title {
                        font-size: 11px;
                        font-weight: 800;
                        text-transform: uppercase;
                        letter-spacing: 0.16em;
                        color: #1a1a2e;
                    }
                    .section-title-accent {
                        color: #5f27cd;
                    }

                    .section-body {
                        padding: 0;
                    }
                    .section-intro {
                        font-size: 9.5px;
                        color: #64748b;
                        padding: 12px 18px 0;
                        line-height: 1.6;
                        border-bottom: 1px solid #f1f5f9;
                        padding-bottom: 12px;
                    }

                    /* ─── INFO TABLE ───────────────────────────────────────────────── */
                    .info-table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    .info-table tr {
                        border-bottom: 1px solid #f1f5f9;
                    }
                    .info-table tr:last-child {
                        border-bottom: none;
                    }
                    .info-table td {
                        padding: 10px 18px;
                        font-size: 10px;
                        vertical-align: middle;
                    }
                    .info-table td.lbl {
                        font-weight: 700;
                        color: #475569;
                        width: 38%;
                        background: #f8fafc;
                        border-right: 1px solid #e2e8f0;
                        font-size: 9.5px;
                        text-transform: uppercase;
                        letter-spacing: 0.06em;
                    }
                    .info-table td.val {
                        color: #0f172a;
                        font-size: 10.5px;
                        background: #ffffff;
                    }

                    /* highlight rows */
                    .row-hl td.lbl {
                        background: #f5f3ff;
                        color: #5f27cd;
                        border-right-color: #e6dbff;
                    }
                    .row-hl td.val {
                        background: #f5f3ff;
                        color: #3b157a;
                        font-weight: 700;
                        font-size: 11.5px;
                    }

                    /* ─── TWO-COLUMN GRID ──────────────────────────────────────────── */
                    .two-col {
                        display: flex;
                        gap: 18px;
                    }
                    .two-col .section {
                        flex: 1;
                    }

                    /* ─── BADGE ────────────────────────────────────────────────────── */
                    .badge-eligible {
                        display: inline-block;
                        background: #f5f3ff;
                        color: #5f27cd;
                        padding: 3px 9px;
                        border-radius: 20px;
                        font-size: 9px;
                        font-weight: 700;
                        letter-spacing: 0.06em;
                        border: 1px solid #e6dbff;
                    }
                    .badge-pending {
                        display: inline-block;
                        background: #fef9c3;
                        color: #92400e;
                        padding: 3px 9px;
                        border-radius: 20px;
                        font-size: 9px;
                        font-weight: 700;
                        letter-spacing: 0.06em;
                        border: 1px solid #fde68a;
                    }

                    /* ─── FOOTER ───────────────────────────────────────────────────── */
                    .page-footer {
                        width: 100%;
                        padding: 14px 32px;
                        border-top: 2px solid #5f27cd;
                        background: #1a1a2e;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                    }
                    .page-footer .foot-brand {
                        font-size: 9px;
                        font-weight: 700;
                        letter-spacing: 0.14em;
                        text-transform: uppercase;
                        color: rgba(255,255,255,0.6);
                    }
                    .page-footer .foot-ref {
                        font-size: 9px;
                        color: rgba(255,255,255,0.4);
                    }
                    .page-footer .foot-dot {
                        width: 6px; height: 6px;
                        border-radius: 50%;
                        background: #5f27cd;
                    }
                </style>
            </head>
            <body>

                <!-- ═══ HEADER ════════════════════════════════════════════════════ -->
                <div class="page-header">
                    <div class="header-inner">
                        <div class="header-left">
                            <div class="brand-row">
                                <div class="brand-logo">
                                    @if(file_exists(public_path('images/logo.svg')))
                                        <img src="file://{{ str_replace('\\', '/', public_path('images/logo.svg')) }}" alt="{{ $brand }}">
                                    @endif
                                </div>
                                <div class="brand-name">{{ $brand }}</div>
                            </div>
                            <div>
                                <div class="header-doc-type">Récapitulatif de dossier</div>
                                <div class="header-title">
                                    DOSSIER<span>CLIENT</span>
                                </div>
                            </div>
                        </div>
                        <div class="header-right">
                            <div class="ref-card">
                                <div class="ref-card-label">Référence dossier</div>
                                <div class="ref-card-value">{{ $application->reference }}</div>
                                <div class="ref-card-sub">
                                    Statut : <strong>{{ $application->status->label() }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ═══ BODY ══════════════════════════════════════════════════════ -->
                <div class="page-body">

                    <!-- SECTION : Informations générales -->
                    <div class="section">
                        <div class="section-header">
                            <div class="section-icon">📋</div>
                            <div class="section-title">Informations <span class="section-title-accent">générales</span></div>
                        </div>
                        <div class="section-body">
                            <p class="section-intro">Résumé rapide du dossier et de son statut pour permettre une lecture fluide avant de descendre sur les détails.</p>
                            <table class="info-table">
                                <tr>
                                    <td class="lbl">Référence dossier</td>
                                    <td class="val">{{ $application->reference }}</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Statut</td>
                                    <td class="val">{{ $application->status->label() }}</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Date de soumission</td>
                                    <td class="val">{{ $application->submitted_at?->format('d/m/Y à H:i') ?? now()->format('d/m/Y à H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- SECTION : Simulation retenue -->
                    <div class="section">
                        <div class="section-header">
                            <div class="section-icon">💰</div>
                            <div class="section-title">Simulation <span class="section-title-accent">retenue</span></div>
                        </div>
                        <div class="section-body">
                            <p class="section-intro">Chiffres clés de l'offre et calculs liés à la demande de crédit.</p>
                            <table class="info-table">
                                <tr class="row-hl">
                                    <td class="lbl">Montant emprunté</td>
                                    <td class="val">{{ number_format($application->montant, 0, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Durée</td>
                                    <td class="val">{{ $application->duree_mois }} mois</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Taux annuel</td>
                                    <td class="val">{{ $application->taux_annuel }} %</td>
                                </tr>
                                <tr class="row-hl">
                                    <td class="lbl">Mensualité estimée</td>
                                    <td class="val">{{ number_format($application->mensualite, 2, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Coût total du crédit</td>
                                    <td class="val">{{ number_format($application->cout_total, 2, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <td class="lbl">Motif</td>
                                    <td class="val">{{ $application->motif ?? '—' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- TWO-COL : Demandeur + Pro/Financier -->
                    <div class="two-col">

                        <!-- SECTION : Informations du demandeur -->
                        <div class="section">
                            <div class="section-header">
                                <div class="section-icon">👤</div>
                                <div class="section-title">Infos <span class="section-title-accent">demandeur</span></div>
                            </div>
                            <div class="section-body">
                                <p class="section-intro">Données personnelles du client pour l'identification et le contact.</p>
                                <table class="info-table">
                                    <tr>
                                        <td class="lbl">Identité</td>
                                        <td class="val">{{ $application->civilite }} {{ $application->prenom }} {{ $application->nom }}</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">Date de naissance</td>
                                        <td class="val">{{ $application->date_naissance?->format('d/m/Y') ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">E-mail</td>
                                        <td class="val">{{ $application->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">Téléphone</td>
                                        <td class="val">{{ $application->telephone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">Adresse</td>
                                        <td class="val">{{ $application->adresse }}, {{ $application->code_postal }} {{ $application->ville }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- SECTION : Situation professionnelle -->
                        <div class="section">
                            <div class="section-header">
                                <div class="section-icon">💼</div>
                                <div class="section-title">Situation <span class="section-title-accent">pro & finances</span></div>
                            </div>
                            <div class="section-body">
                                <p class="section-intro">Détails de la situation professionnelle, des revenus et des charges.</p>
                                <table class="info-table">
                                    <tr>
                                        <td class="lbl">Situation pro</td>
                                        <td class="val">{{ $application->situation_pro ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">Employeur</td>
                                        <td class="val">{{ $application->employeur ?? '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">Ancienneté</td>
                                        <td class="val">{{ $application->anciennete ?? '—' }}</td>
                                    </tr>
                                    <tr class="row-hl">
                                        <td class="lbl">Revenus nets mensuels</td>
                                        <td class="val">{{ $application->revenu_net !== null ? number_format($application->revenu_net, 0, ',', ' ').' €' : '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">Charges mensuelles</td>
                                        <td class="val">{{ $application->charges_mensuelles !== null ? number_format($application->charges_mensuelles, 0, ',', ' ').' €' : '—' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">Éligibilité préliminaire</td>
                                        <td class="val">
                                            @if($application->is_eligible)
                                                <span class="badge-eligible">Profil éligible</span>
                                            @else
                                                <span class="badge-pending">À étudier</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div><!-- /two-col -->

                    <!-- SECTION : Documents -->
                    <div class="section">
                        <div class="section-header">
                            <div class="section-icon">📄</div>
                            <div class="section-title">Documents <span class="section-title-accent">fournis</span></div>
                        </div>
                        <div class="section-body">
                            <p class="section-intro">Liste des pièces jointes fournies dans le dossier.</p>
                            <table class="info-table">
                            @forelse($application->documents as $document)
                                <tr>
                                    <td class="lbl">{{ $document->type->label() }}</td>
                                    <td class="val">{{ $document->original_filename }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" style="padding: 20px; text-align: center; color: #94a3b8; font-style: italic;">Aucun document enregistré.</td>
                                </tr>
                            @endforelse
                            </table>
                        </div>
                    </div>

                </div><!-- /page-body -->

                <!-- ═══ FOOTER ════════════════════════════════════════════════════ -->
                <div class="page-footer">
                    <span class="foot-brand">{{ $brand }}</span>
                    <div class="foot-dot"></div>
                    <span class="foot-ref">Réf. {{ $application->reference }} — Document confidentiel</span>
                </div>

            </body>
            </html>
