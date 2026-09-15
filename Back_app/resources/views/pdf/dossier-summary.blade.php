@php
    $logoPath = public_path('images/logo_brand.png');
    $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';

    $logoEuPath = public_path('images/logo_eu.png');
    $logoEuBase64 = file_exists($logoEuPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoEuPath)) : '';

    $logoFrPath = public_path('images/logo_fr.png');
    $logoFrBase64 = file_exists($logoFrPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoFrPath)) : '';
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Récapitulatif de Dossier {{ $application->reference }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* ─── MARGES DE SÉCURITÉ NOTARIALES ───────────────────────── */
        @page {
            size: A4 portrait;
            margin: 20mm 22mm 26mm 22mm;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Arial, sans-serif;
            font-size: 9.5pt;
            color: #1E293B;
            background: #FFFFFF;
            line-height: 1.65;
        }

        /* ─── BANDEAU CONFIDENTIEL FIXE SUR TOUTES LES PAGES ─────────────── */
        .fixed-footer-banner {
            position: fixed;
            bottom: 2px;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
            z-index: 1000;
        }

        .confid-banner {
            background: #0A2240;
            color: #FFFFFF;
            text-align: center;
            font-size: 7.5pt;
            font-weight: bold;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 8px 12px;
            border-radius: 5px;
            width: 100%;
        }

        /* ─── ZONE DE LECTURE OPTIMISÉE ────────────────────────────────────── */
        .reading-zone {
            width: 96%;
            margin: 0 auto;
            padding: 0 2px;
        }

        /* ─── EN-TÊTE ─────────────────────────────────────────────────── */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #0A2240;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header-title-brand {
            font-size: 16pt;
            font-weight: bold;
            color: #0A2240;
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .header-title-accent {
            color: #2563EB;
        }

        .header-subtitle {
            font-size: 7.5pt;
            color: #64748B;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 3px;
        }

        .header-ref-box {
            text-align: right;
            font-size: 8pt;
            color: #475569;
            line-height: 1.5;
        }

        .ref-badge {
            font-family: monospace;
            font-size: 9.5pt;
            font-weight: bold;
            color: #0A2240;
            background: #F1F5F9;
            padding: 3px 8px;
            border-radius: 4px;
            border: 1px solid #CBD5E1;
            display: inline-block;
        }

        /* ─── HERO BANNER ────────────────────────────────────────────────── */
        .hero-banner {
            background: #0A2240;
            color: #FFFFFF;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }

        .hero-title {
            font-size: 12.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #FFFFFF;
            margin-bottom: 4px;
        }

        .hero-sub {
            font-size: 8.5pt;
            color: #93C5FD;
        }

        /* ─── SECTIONS ────────────────────────────────────────────────── */
        .section-box {
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            margin-bottom: 18px;
            background: #FFFFFF;
            page-break-inside: avoid;
        }

        .section-header {
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            padding: 10px 16px;
            font-size: 9.5pt;
            font-weight: bold;
            color: #0A2240;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-header span {
            color: #2563EB;
            margin-right: 8px;
        }

        /* ─── TABLES ──────────────────────────────────────────────────── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table tr {
            border-bottom: 1px solid #F1F5F9;
        }

        .data-table tr:last-child {
            border-bottom: none;
        }

        .data-table td {
            padding: 10px 16px;
            font-size: 9pt;
            vertical-align: middle;
        }

        .data-table td.lbl {
            width: 42%;
            font-weight: bold;
            color: #475569;
            background: #FAFAFA;
            border-right: 1px solid #F1F5F9;
        }

        .data-table td.val {
            color: #0F172A;
            font-weight: 500;
        }

        .val-highlight {
            font-weight: bold;
            color: #0A2240;
            font-size: 10.5pt;
        }

        /* ─── STATUS BADGES ───────────────────────────────────────────── */
        .status-pill {
            display: inline-block;
            background: #EFF6FF;
            color: #1D4ED8;
            border: 1px solid #BFDBFE;
            font-size: 8pt;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 12px;
        }

        .doc-badge {
            display: inline-block;
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid #BBF7D0;
            font-size: 8pt;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* ─── FOOTER & SIGNATURE ───────────────────────────────────────── */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 22px;
            page-break-inside: avoid;
        }

        .sig-box {
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            padding: 14px 16px;
            background: #FAFAFA;
            min-height: 90px;
        }

        .sig-title {
            font-size: 8.5pt;
            font-weight: bold;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 6px;
        }
    </style>
</head>
<body>

    {{-- ═══════════════════════════════════════════
         BANDEAU CONFIDENTIEL FIXE VISIBLE EN BAS DE TOUTES LES PAGES
    ═══════════════════════════════════════════ --}}
    <div class="fixed-footer-banner">
        <div class="reading-zone">
            <div class="confid-banner">
                DOCUMENT STRICTEMENT CONFIDENTIEL SOUMIS AU SECRET BANCAIRE ET AUX RÈGLES RGPD.
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
         RUNNING FOOTER
    ═══════════════════════════════════════════ --}}
    <script type="text/php">
        if (isset($pdf)) {
            $text = "{{ config('credit.brand') }} · Récapitulatif de Dossier " . "{{ $application->reference }}" . " · Page {PAGE_NUM} sur {PAGE_COUNT}";
            $font = $fontMetrics->get_font("DejaVu Sans, sans-serif", "normal");
            $size = 7.5;
            $color = array(0.4, 0.45, 0.55);
            $pdf->page_text(62, 792, $text, $font, $size, $color);
        }
    </script>

    <div class="reading-zone">

        {{-- ═══════════════════════════════════════════
             HEADER
        ═══════════════════════════════════════════ --}}
        <table class="header-table">
            <tr>
                <td style="vertical-align: middle; width: 62%;">
                    <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                        <tr>
                            @if($logoBase64)
                            <td style="vertical-align: middle; padding-right: 10px;">
                                <img src="{{ $logoBase64 }}" width="38" height="38" style="border-radius: 6px; display: block;" alt="{{ config('credit.brand') }}">
                            </td>
                            @endif
                            @if($logoEuBase64)
                            <td style="vertical-align: middle; padding-right: 6px;">
                                <img src="{{ $logoEuBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="EU">
                            </td>
                            @endif
                            @if($logoFrBase64)
                            <td style="vertical-align: middle; padding-right: 10px;">
                                <img src="{{ $logoFrBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="MinFin">
                            </td>
                            @endif
                            <td style="vertical-align: middle; border-left: 2px solid #CBD5E1; padding-left: 10px;">
                                <div class="header-title-brand">
                                    {{ config('credit.brand') }}
                                </div>
                                <div class="header-subtitle">
                                    Financement dédié aux étudiants
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: middle;" class="header-ref-box">
                    <div>Document Synthèse de Dossier</div>
                    <div style="margin: 3px 0;">
                        Réf : <span class="ref-badge">{{ $application->reference }}</span>
                    </div>
                    <div style="font-size: 7.5pt; color: #64748B;">
                        Généré le {{ now()->format('d/m/Y à H:i') }}
                    </div>
                </td>
            </tr>
        </table>

        {{-- ═══════════════════════════════════════════
             HERO TITLE BANNER
        ═══════════════════════════════════════════ --}}
        <div class="hero-banner">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td>
                        <div class="hero-title">Récapitulatif Officiel de Demande de Financement</div>
                        <div class="hero-sub">Dossier d'emprunt enregistré auprès des services {{ config('credit.brand') }}</div>
                    </td>
                    <td style="text-align: right; vertical-align: middle;">
                        <span class="status-pill">Dossier Transmis · Analyse en cours</span>
                    </td>
                </tr>
            </table>
        </div>

        {{-- ═══════════════════════════════════════════
             SECTION 1 : FINANCEMENT
        ═══════════════════════════════════════════ --}}
        <div class="section-box">
            <div class="section-header">
                <span>💶</span> 1. Caractéristiques du Financement Souhaité
            </div>
            <table class="data-table">
                <tr>
                    <td class="lbl">Montant du prêt :</td>
                    <td class="val val-highlight">{{ number_format($application->montant, 0, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <td class="lbl">Durée de remboursement :</td>
                    <td class="val">{{ $application->duree_mois }} mois ({{ round($application->duree_mois / 12, 1) }} ans)</td>
                </tr>
                <tr>
                    <td class="lbl">Mensualité estimée :</td>
                    <td class="val val-highlight" style="color: #2563EB;">{{ number_format($application->mensualite, 2, ',', ' ') }} € / mois</td>
                </tr>
                <tr>
                    <td class="lbl">Taux Annuel Effectif Global (TAEG) :</td>
                    <td class="val"><strong>{{ $application->taux_annuel }} %</strong> (Fixe)</td>
                </tr>
                <tr>
                    <td class="lbl">Coût total du crédit :</td>
                    <td class="val">{{ number_format($application->cout_total, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <td class="lbl">Objet / Motif du projet :</td>
                    <td class="val">{{ match ($application->motif) {
                        'travaux' => 'Frais de scolarité',
                        'auto' => 'Logement étudiant',
                        'tresorerie' => 'Matériel & fournitures',
                        'vacances' => 'Permis de conduire',
                        'autre' => 'Autre projet étudiant',
                        default => 'Non renseigné',
                    } }}</td>
                </tr>
            </table>
        </div>

        {{-- ═══════════════════════════════════════════
             SECTION 2 : ÉTAT CIVIL & COORDONNÉES
        ═══════════════════════════════════════════ --}}
        <div class="section-box">
            <div class="section-header">
                <span>👤</span> 2. État Civil &amp; Coordonnées de l'Emprunteur
            </div>
            <table class="data-table">
                <tr>
                    <td class="lbl">Identité complète :</td>
                    <td class="val"><strong>{{ $application->civilite }} {{ $application->nom }} {{ $application->prenom }}</strong></td>
                </tr>
                <tr>
                    <td class="lbl">Adresse e-mail :</td>
                    <td class="val">{{ $application->email }}</td>
                </tr>
                <tr>
                    <td class="lbl">Téléphone de contact :</td>
                    <td class="val">{{ $application->telephone }}</td>
                </tr>
                <tr>
                    <td class="lbl">Date &amp; Lieu de naissance :</td>
                    <td class="val">
                        {{ $application->date_naissance ? \Carbon\Carbon::parse($application->date_naissance)->format('d/m/Y') : 'Non renseignée' }}
                        @if($application->lieu_naissance) ({{ $application->lieu_naissance }}) @endif
                    </td>
                </tr>
                <tr>
                    <td class="lbl">Adresse de résidence :</td>
                    <td class="val">
                        {{ $application->adresse ?? 'Non communiquée' }}
                        @if($application->code_postal || $application->ville)
                            <br>{{ $application->code_postal }} {{ $application->ville }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        {{-- ═══════════════════════════════════════════
             SECTION 3 : SITUATION FINANCIÈRE
        ═══════════════════════════════════════════ --}}
        <div class="section-box">
            <div class="section-header">
                <span>📊</span> 3. Situation Financière &amp; Professionnelle
            </div>
            <table class="data-table">
                <tr>
                    <td class="lbl">Statut professionnel :</td>
                    <td class="val">{{ match ($application->situation_pro) {
                        'cdi', 'salarie_cdi' => 'Salarié CDI / Fonctionnaire',
                        'cdd', 'salarie_cdd' => 'Salarié CDD / Intérim',
                        'fonctionnaire' => 'Fonctionnaire',
                        'independant' => 'Indépendant / Chef d\'entreprise',
                        'retraite' => 'Retraité',
                        default => $application->situation_pro ? 'Autre' : 'Non renseigné',
                    } }}</td>
                </tr>
                <tr>
                    <td class="lbl">Revenus mensuels nets :</td>
                    <td class="val">{{ $application->revenu_net !== null ? number_format($application->revenu_net, 0, ',', ' ') . ' € / mois' : 'Non renseigné' }}</td>
                </tr>
                <tr>
                    <td class="lbl">Charges mensuelles (crédits en cours) :</td>
                    <td class="val">{{ $application->charges_mensuelles !== null ? number_format($application->charges_mensuelles, 0, ',', ' ') . ' € / mois' : 'Non renseigné' }}</td>
                </tr>
            </table>
        </div>

        {{-- ═══════════════════════════════════════════
             SECTION 4 : PIÈCES JUSTIFICATIVES
        ═══════════════════════════════════════════ --}}
        <div class="section-box">
            <div class="section-header">
                <span>📁</span> 4. Pièces Justificatives Associées au Dossier
            </div>
            <table class="data-table">
                @if($application->documents && $application->documents->count() > 0)
                    @foreach($application->documents as $doc)
                    <tr>
                        <td class="lbl">{{ $doc->type->label() }} :</td>
                        <td class="val">
                            <span class="doc-badge">✓ Reçu</span>
                            <span style="font-size: 8.5pt; color: #64748B; margin-left: 8px;">{{ $doc->original_filename }} ({{ round($doc->size_bytes / 1024, 1) }} KB)</span>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="lbl">Pièces justificatives :</td>
                        <td class="val" style="color: #64748B; font-style: italic;">
                            Pièces en cours de téléversement / Réception par le conseiller.
                        </td>
                    </tr>
                @endif
            </table>
        </div>

        {{-- ═══════════════════════════════════════════
             SIGNATURES BLOCK
        ═══════════════════════════════════════════ --}}
        <table class="signature-table">
            <tr>
                <td style="width: 48%; vertical-align: top;">
                    <div class="sig-box">
                        <div class="sig-title">L'Emprunteur</div>
                        <div style="font-size: 9pt; color: #334155; margin-bottom: 25px;">
                            Signature de : <strong>{{ $application->prenom }} {{ $application->nom }}</strong><br>
                            <span style="font-size: 8pt; color: #64748B;">Date et mention manuscrite « Lu et approuvé »</span>
                        </div>
                    </div>
                </td>
                <td style="width: 4%;"></td>
                <td style="width: 48%; vertical-align: top;">
                    <div class="sig-box">
                        <div class="sig-title">Pour l'Établissement {{ config('credit.brand') }}</div>
                        <div style="font-size: 9pt; color: #334155; margin-bottom: 6px;">
                            <strong>{{ config('credit.brand') }}</strong>
                        </div>
                        <div style="font-size: 8pt; color: #64748B; line-height: 1.5;">
                            Service Client &amp; Engagement<br>
                            📞 +33 7 80 96 12 16 · ✉️ support@crediteco.app
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
