@php
    $logoPath = public_path('images/logo_brand.png');
    $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';

    $logoEuPath = public_path('images/logo_eu.png');
    $logoEuBase64 = file_exists($logoEuPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoEuPath)) : '';

    $logoFrPath = public_path('images/logo_fr.png');
    $logoFrBase64 = file_exists($logoFrPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoFrPath)) : '';

    $frais = $fraisDossier ?? config('credit.frais_dossier', 250);
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Offre de Contrat de Prêt — {{ $application->reference }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* ─── MARGES DE SÉCURITÉ NOTARIALES LARGES ───────────────────────── */
        @page {
            size: A4 portrait;
            margin: 20mm 22mm 26mm 22mm;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Arial, sans-serif;
            font-size: 9pt;
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

        /* ─── SAUTS DE PAGE CLEAN ───────────────────────────────────────────── */
        .page-section {
            page-break-after: always;
            width: 100%;
        }

        .page-section:last-child {
            page-break-after: avoid;
        }

        /* ─── ZONE DE LECTURE CENTRÉE AVEC ESPACE BLANC ───────────────────── */
        .reading-zone {
            width: 96%;
            margin: 0 auto;
            padding: 0 2px;
        }

        /* ─── EN-TÊTE ÉLÉGANT HAUT DE GAMME ───────────────────────────────── */
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
            letter-spacing: 0.6px;
            margin-top: 3px;
        }

        .header-ref {
            font-size: 8pt;
            color: #475569;
            text-align: right;
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

        /* ─── BANDEAU ET TITRE DE L'OFFRE ────────────────────────────────── */
        .title-section {
            text-align: center;
            margin: 18px 0 20px;
            padding: 16px 20px;
            border: 1.5px solid #0A2240;
            border-radius: 8px;
            background: #F8FAFC;
        }

        .doc-type {
            font-size: 8pt;
            font-weight: bold;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #2563EB;
            margin-bottom: 6px;
        }

        .doc-title {
            font-size: 12.5pt;
            font-weight: bold;
            color: #0A2240;
            line-height: 1.4;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* ─── TITRES DE SECTIONS ───────────────────────────────────────────── */
        .section-title {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #0A2240;
            border-left: 4px solid #2563EB;
            padding-left: 12px;
            margin: 20px 0 14px;
        }

        /* ─── ENCADRÉS & DÉSIGNATION ───────────────────────────────────────── */
        .ref-box {
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 18px;
            background: #F8FAFC;
        }

        .ref-item label {
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748B;
            margin-right: 8px;
        }

        .ref-item span {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0F172A;
        }

        .status-badge {
            display: inline-block;
            background: #DCFCE7;
            color: #15803D;
            font-size: 8pt;
            font-weight: bold;
            padding: 3px 10px;
            border-radius: 12px;
            border: 1px solid #BBF7D0;
        }

        .party-box {
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 14px 16px;
            background: #FAFAFA;
            min-height: 120px;
        }

        .party-label {
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #2563EB;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .party-info p {
            font-size: 9pt;
            line-height: 1.65;
            color: #334155;
        }

        .party-info strong {
            color: #0A2240;
            font-size: 9.5pt;
        }

        /* ─── TABLEAUX SPACIEUX DÉGAGÉS DES BORDURES ─────────────────────── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #E2E8F0;
        }

        .data-table th {
            background: #0A2240;
            color: #FFFFFF;
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px 12px;
            text-align: left;
            letter-spacing: 0.05em;
        }

        .data-table td {
            padding: 10px 12px;
            font-size: 9pt;
            border-bottom: 1px solid #E2E8F0;
        }

        .data-table tr:nth-child(even) {
            background: #F8FAFC;
        }

        .amort-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            overflow: hidden;
        }

        .amort-table th {
            background: #1E293B;
            color: #FFFFFF;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: center;
            letter-spacing: 0.04em;
        }

        .amort-table td {
            padding: 7px 10px;
            font-size: 8.5pt;
            border-bottom: 1px solid #E2E8F0;
            text-align: right;
        }

        .amort-table td:first-child {
            text-align: center;
            font-weight: bold;
        }

        /* ─── PARAGRAPHES & CLAUSES JURIDIQUES CONFORTABLES ───────────────── */
        .clause {
            margin-bottom: 14px;
            page-break-inside: avoid;
        }

        .clause-title {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0A2240;
            margin-bottom: 4px;
        }

        .clause p {
            font-size: 8.5pt;
            color: #475569;
            line-height: 1.65;
        }

        .clause-highlight {
            border-left: 4px solid #2563EB;
            padding: 10px 14px;
            background: #EFF6FF;
            border-radius: 0 6px 6px 0;
            margin-top: 6px;
            font-size: 8.5pt;
            color: #1E40AF;
            line-height: 1.65;
        }

        .info-note {
            font-size: 8.5pt;
            color: #92400E;
            line-height: 1.6;
            background: #FEF3C7;
            border: 1px solid #FCD34D;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 14px 0;
        }

        /* ─── CARTOUCHES DE SIGNATURE NOTARIALE SPACIEUX ──────────────────── */
        .sig-box {
            border: 1.5px solid #CBD5E1;
            border-radius: 8px;
            padding: 14px 16px;
            background: #FFFFFF;
            page-break-inside: avoid;
        }

        .sig-label {
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #0A2240;
            margin-bottom: 10px;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 6px;
        }

        .sig-area {
            height: 65px;
            border: 1px dashed #CBD5E1;
            border-radius: 6px;
            background: #FAFAFA;
            text-align: center;
            line-height: 65px;
            font-size: 8.5pt;
            color: #94A3B8;
            position: relative;
        }

        .sig-area.signed {
            background: #EFF6FF;
            border-color: #93C5FD;
            font-size: 13pt;
            font-style: italic;
            color: #1E40AF;
            line-height: 65px;
        }

        .sig-date {
            font-size: 8pt;
            color: #64748B;
            margin-top: 8px;
            text-align: right;
            line-height: 1.4;
        }

        .mentions-box {
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            padding: 14px 16px;
            background: #F8FAFC;
            margin: 16px 0;
            font-size: 8.5pt;
            color: #334155;
            page-break-inside: avoid;
        }

        .mentions-title {
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748B;
            margin-bottom: 8px;
        }

        .mention-line {
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 8px;
            background: #FFFFFF;
            font-size: 8.5pt;
            color: #1E293B;
            font-style: italic;
            line-height: 1.5;
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
         PAGINATION AUTOMATIQUE RESPECTANT LES MARGES
    ═══════════════════════════════════════════ --}}
    <script type="text/php">
        if (isset($pdf)) {
            $text = "{{ config('credit.brand') }} · Offre de Contrat de Prêt " . "{{ $application->reference }}" . " · Page {PAGE_NUM} sur {PAGE_COUNT}";
            $font = $fontMetrics->get_font("DejaVu Sans, sans-serif", "normal");
            $size = 7.5;
            $color = array(0.4, 0.45, 0.55);
            $pdf->page_text(62, 792, $text, $font, $size, $color);
        }
    </script>

    <div class="reading-zone">

        {{-- ============================================================ --}}
        {{-- PAGE 1 : PRÉSENTATION DE L'OFFRE & VUE D'ENSEMBLE            --}}
        {{-- ============================================================ --}}
        <div class="page-section">

            {{-- EN-TÊTE SPACIEUX DE MARQUE --}}
            <table class="header-table">
                <tr>
                    <td style="vertical-align: middle; width: 62%;">
                        <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                @if($logoBase64)
                                <td style="vertical-align: middle; padding-right: 12px;">
                                    <img src="{{ $logoBase64 }}" width="40" height="40" style="border-radius: 6px; display: block;" alt="{{ config('credit.brand') }}">
                                </td>
                                @endif
                                @if($logoEuBase64)
                                <td style="vertical-align: middle; padding-right: 8px;">
                                    <img src="{{ $logoEuBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="EU">
                                </td>
                                @endif
                                @if($logoFrBase64)
                                <td style="vertical-align: middle; padding-right: 12px;">
                                    <img src="{{ $logoFrBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="MinFin">
                                </td>
                                @endif
                                <td style="vertical-align: middle; border-left: 2px solid #CBD5E1; padding-left: 12px;">
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
                    <td style="vertical-align: middle;" class="header-ref">
                        <div>Document Contractuel Officiel</div>
                        <div style="margin: 4px 0;">
                            Réf : <span class="ref-badge">{{ $application->reference }}</span>
                        </div>
                        <div style="font-size: 7.5pt; color: #64748B;">
                            Émis le {{ $generatedAt->format('d/m/Y') }}
                        </div>
                    </td>
                </tr>
            </table>

            {{-- TITRE PRINCIPAL DE L'OFFRE --}}
            <div class="title-section">
                <div class="doc-type">Offre Préalable de Crédit à la Consommation</div>
                <div class="doc-title">
                    CONTRAT DE PRÊT SOUS SEING PRIVÉ
                </div>
            </div>

            {{-- ENCADRÉ RÉFÉRENCE ET STATUT --}}
            <div class="ref-box">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 50%;" class="ref-item">
                            <label>Dossier N° :</label>
                            <span>{{ $application->reference }}</span>
                        </td>
                        <td style="width: 50%;" class="ref-item">
                            <label>Établissement prêteur :</label>
                            <span>{{ config('credit.brand') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 10px;" class="ref-item">
                            <label>Date de l'offre :</label>
                            <span>{{ $generatedAt->format('d/m/Y') }}</span>
                        </td>
                        <td style="padding-top: 10px;" class="ref-item">
                            <label>Statut du contrat :</label>
                            <span class="status-badge">Validé par le Comité d'Engagement</span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="info-note">
                ⚠️ <strong>Délai légal de réflexion :</strong> Conformément à l'article L.312-19 du Code de la consommation, l'emprunteur dispose d'un délai légal de <strong>14 jours calendaires</strong> révolus pour se rétracter à compter de l'acceptation de la présente offre.
            </div>

            {{-- OBJET DU CONTRAT --}}
            <div class="section-title">1. Objet du Contrat &amp; Cadre Réglémentaire</div>
            <p style="font-size: 9pt; color: #475569; line-height: 1.7; margin-bottom: 16px;">
                La présente offre a pour objet de formaliser les conditions financières et juridiques du prêt accordé par l'établissement <strong>{{ config('credit.brand') }}</strong> (ci-après désigné « le Prêteur ») à l'Emprunteur désigné au présent contrat.
                Le présent contrat est régi par le Code de la consommation français et par la Directive Européenne 2014/17/UE relative aux contrats de crédit aux consommateurs.
            </p>

            {{-- PARTIES PRENANTES --}}
            <div class="section-title">2. Désignation des Parties</div>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 16px;">
                <tr>
                    <td style="width: 48%; vertical-align: top;">
                        <div class="party-box">
                            <div class="party-label">Le Prêteur &amp; Organisme de Crédit</div>
                            <div class="party-info">
                                <p>
                                    <strong>{{ config('credit.brand') }}</strong><br>
                                    Service Client &amp; Engagement<br>
                                    📞 +33 7 80 96 12 16<br>
                                    ✉️ support@crediteco.app<br>
                                    🌐 crediteco.app
                                </p>
                            </div>
                        </div>
                    </td>
                    <td style="width: 4%;"></td>
                    <td style="width: 48%; vertical-align: top;">
                        <div class="party-box">
                            <div class="party-label">L'Emprunteur</div>
                            <div class="party-info">
                                <p>
                                    <strong>{{ $application->civilite }} {{ $application->prenom }} {{ $application->nom }}</strong><br>
                                    {{ $application->adresse ?? 'Adresse non communiquée' }}<br>
                                    {{ $application->code_postal }} {{ $application->ville }}<br>
                                    📞 {{ $application->telephone }}<br>
                                    ✉️ {{ $application->email }}
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

        </div>

        <div class="page-break"></div>

        {{-- ============================================================ --}}
        {{-- PAGE 2 : CARACTÉRISTIQUES DU PRÊT & TABLEAU D'AMORTISSEMENT  --}}
        {{-- ============================================================ --}}
        <div class="page-section">

            {{-- EN-TÊTE SPACIEUX DE MARQUE --}}
            <table class="header-table">
                <tr>
                    <td style="vertical-align: middle; width: 62%;">
                        <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                @if($logoBase64)
                                <td style="vertical-align: middle; padding-right: 12px;">
                                    <img src="{{ $logoBase64 }}" width="40" height="40" style="border-radius: 6px; display: block;" alt="{{ config('credit.brand') }}">
                                </td>
                                @endif
                                @if($logoEuBase64)
                                <td style="vertical-align: middle; padding-right: 8px;">
                                    <img src="{{ $logoEuBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="EU">
                                </td>
                                @endif
                                @if($logoFrBase64)
                                <td style="vertical-align: middle; padding-right: 12px;">
                                    <img src="{{ $logoFrBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="MinFin">
                                </td>
                                @endif
                                <td style="vertical-align: middle; border-left: 2px solid #CBD5E1; padding-left: 12px;">
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
                    <td style="vertical-align: middle;" class="header-ref">
                        <div>Modalités Financières &amp; Échéancier</div>
                        <div style="margin: 4px 0;">
                            Réf : <span class="ref-badge">{{ $application->reference }}</span>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- CARACTÉRISTIQUES DU PRÊT --}}
            <div class="section-title">3. Caractéristiques Financières du Prêt</div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Capital Prêté</th>
                        <th>TAEG Fixe</th>
                        <th>Durée</th>
                        <th>Mensualité Nette</th>
                        <th>Date 1er Prélèvement</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: bold; color: #0A2240; font-size: 10pt;">{{ number_format($application->montant, 2, ',', ' ') }} €</td>
                        <td style="font-weight: bold;">{{ $application->taux_annuel }} %</td>
                        <td>{{ $application->duree_mois }} mois</td>
                        <td style="font-weight: bold; color: #2563EB; font-size: 10pt;">{{ number_format($application->mensualite, 2, ',', ' ') }} €</td>
                        <td>05 / {{ str_pad((date('n') % 12) + 1, 2, '0', STR_PAD_LEFT) }} / {{ date('n') == 12 ? date('Y') + 1 : date('Y') }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- AMORTISSEMENT --}}
            <div class="section-title">4. Tableau d'Amortissement Déclaratif (Extrait des premières échéances)</div>
            <table class="amort-table">
                <thead>
                    <tr>
                        <th>N° Échéance</th>
                        <th>Mensualité (€)</th>
                        <th>Intérêts (€)</th>
                        <th>Capital Amorti (€)</th>
                        <th>Capital Restant Dû (€)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(array_slice($amortization, 0, 8) as $row)
                    <tr>
                        <td>{{ $row['mois'] }}</td>
                        <td>{{ number_format($row['mensualite'], 2, ',', ' ') }}</td>
                        <td>{{ number_format($row['interets'], 2, ',', ' ') }}</td>
                        <td>{{ number_format($row['part_capital'], 2, ',', ' ') }}</td>
                        <td>{{ number_format($row['capital_restant'], 2, ',', ' ') }}</td>
                    </tr>
                    @endforeach
                    @if(count($amortization) > 8)
                    <tr>
                        <td colspan="5" style="text-align: center; font-style: italic; color: #64748B; font-size: 8pt; padding: 8px; background: #F8FAFC;">
                            · · · {{ count($amortization) - 8 }} échéances intermédiaires régulières — tableau d'amortissement complet joint · · ·
                        </td>
                    </tr>
                    @endif
                    @php $last = end($amortization); @endphp
                    <tr style="background: #F0FDF4 !important;">
                        <td style="color: #166534; font-weight: bold;">{{ $last['mois'] }} (Dernière)</td>
                        <td style="color: #166534;">{{ number_format($last['mensualite'], 2, ',', ' ') }}</td>
                        <td style="color: #166534;">{{ number_format($last['interets'], 2, ',', ' ') }}</td>
                        <td style="color: #166534;">{{ number_format($last['part_capital'], 2, ',', ' ') }}</td>
                        <td style="color: #166534; font-weight: bold;">0,00 €</td>
                    </tr>
                </tbody>
            </table>

            <div style="font-size: 8pt; color: #64748B; font-style: italic; margin-bottom: 18px;">
                Les mensualités sont calculées selon la méthode à amortissement constant au taux mensuel de {{ round($application->taux_annuel / 12, 4) }} %.
            </div>

        </div>

        <div class="page-break"></div>

        {{-- ============================================================ --}}
        {{-- PAGE 3 : CLAUSES CONTRACTUELLES & CONDITIONS GÉNÉRALES        --}}
        {{-- ============================================================ --}}
        <div class="page-section">

            {{-- EN-TÊTE SPACIEUX DE MARQUE --}}
            <table class="header-table">
                <tr>
                    <td style="vertical-align: middle; width: 62%;">
                        <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                @if($logoBase64)
                                <td style="vertical-align: middle; padding-right: 12px;">
                                    <img src="{{ $logoBase64 }}" width="40" height="40" style="border-radius: 6px; display: block;" alt="{{ config('credit.brand') }}">
                                </td>
                                @endif
                                @if($logoEuBase64)
                                <td style="vertical-align: middle; padding-right: 8px;">
                                    <img src="{{ $logoEuBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="EU">
                                </td>
                                @endif
                                @if($logoFrBase64)
                                <td style="vertical-align: middle; padding-right: 12px;">
                                    <img src="{{ $logoFrBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="MinFin">
                                </td>
                                @endif
                                <td style="vertical-align: middle; border-left: 2px solid #CBD5E1; padding-left: 12px;">
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
                    <td style="vertical-align: middle;" class="header-ref">
                        <div>Conditions Générales du Contrat</div>
                        <div style="margin: 4px 0;">
                            Réf : <span class="ref-badge">{{ $application->reference }}</span>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="section-title">5. Conditions Générales &amp; Engagements Juridiques</div>

            <div class="clause">
                <div class="clause-title">Article 1 – Mise à disposition des fonds</div>
                <p>Le Prêteur s'engage à virer la somme de <strong>{{ number_format($application->montant, 2, ',', ' ') }} €</strong> sur le compte bancaire désigné par l'Emprunteur après vérification finale de conformité du dossier et réception de la présente offre dument signée.</p>
            </div>

            <div class="clause">
                <div class="clause-title">Article 2 – Modalités de remboursement &amp; Prélèvements</div>
                <p>Le remboursement s'effectue par prélèvements mensuels automatiques d'un montant de <strong>{{ number_format($application->mensualite, 2, ',', ' ') }} €</strong> le 5 de chaque mois, sur une durée de <strong>{{ $application->duree_mois }} mois</strong>.</p>
            </div>

            <div class="clause">
                <div class="clause-title">Article 3 – Droit de rétractation</div>
                <div class="clause-highlight">
                    Conformément aux articles L.312-19 et suivants du Code de la consommation, l'Emprunteur peut se rétracter sans motif dans un délai de <strong>14 jours calendaires</strong> à compter du jour de la signature du contrat.
                </div>
            </div>

            <div class="clause">
                <div class="clause-title">Article 4 – Remboursement anticipé</div>
                <p>L'Emprunteur peut à tout moment rembourser par anticipation tout ou partie du prêt sans pénalité sur les crédits d'un montant inférieur à 10 000 €, conformément à la législation en vigueur.</p>
            </div>

            <div class="clause">
                <div class="clause-title">Article 5 – Défaut de paiement</div>
                <p>En cas de retard de paiement, des intérêts de retard au taux légal pourront être appliqués après mise en demeure restée sans effet.</p>
            </div>

            <div class="clause">
                <div class="clause-title">Article 6 – Validation de dossier &amp; Sécurisation des opérations</div>
                <p>Afin d'assurer la conformité bancaire de l'enveloppe de prêt accordée, des frais de constitution et de traitement de dossier fixés à <strong>{{ number_format($frais, 0, ',', ' ') }} €</strong> sont rattachés à la validation finale du dossier d'emprunt.</p>
            </div>

        </div>

        <div class="page-break"></div>

        {{-- ============================================================ --}}
        {{-- PAGE 4 : BLOC DES SIGNATURES & CORRESPONDANCE MANUSCRITE      --}}
        {{-- ============================================================ --}}
        <div class="page-section">

            {{-- EN-TÊTE SPACIEUX DE MARQUE --}}
            <table class="header-table">
                <tr>
                    <td style="vertical-align: middle; width: 62%;">
                        <table cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
                            <tr>
                                @if($logoBase64)
                                <td style="vertical-align: middle; padding-right: 12px;">
                                    <img src="{{ $logoBase64 }}" width="40" height="40" style="border-radius: 6px; display: block;" alt="{{ config('credit.brand') }}">
                                </td>
                                @endif
                                @if($logoEuBase64)
                                <td style="vertical-align: middle; padding-right: 8px;">
                                    <img src="{{ $logoEuBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="EU">
                                </td>
                                @endif
                                @if($logoFrBase64)
                                <td style="vertical-align: middle; padding-right: 12px;">
                                    <img src="{{ $logoFrBase64 }}" width="44" height="30" style="border: 1px solid #CBD5E1; border-radius: 4px; padding: 1px; background: #FFFFFF;" alt="MinFin">
                                </td>
                                @endif
                                <td style="vertical-align: middle; border-left: 2px solid #CBD5E1; padding-left: 12px;">
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
                    <td style="vertical-align: middle;" class="header-ref">
                        <div>Validation &amp; Signatures</div>
                        <div style="margin: 4px 0;">
                            Réf : <span class="ref-badge">{{ $application->reference }}</span>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="section-title">6. Acceptation des Conditions &amp; Signatures des Parties</div>

            <p style="font-size: 9pt; color: #475569; line-height: 1.7; margin-bottom: 16px;">
                En signant la présente offre, l'Emprunteur déclare accepter sans réserve l'ensemble des conditions générales et particulières du contrat.
            </p>

            {{-- MENTIONS MANUSCRITES --}}
            <div class="mentions-box">
                <div class="mentions-title">Mention manuscrite obligatoire à recopier par l'Emprunteur :</div>
                <div class="mention-line">
                    « Lu et approuvé, bon pour accord pour un prêt de {{ number_format($application->montant, 2, ',', ' ') }} € remboursable en {{ $application->duree_mois }} mensualités de {{ number_format($application->mensualite, 2, ',', ' ') }} €. »
                </div>
            </div>

            {{-- SIGNATURES --}}
            <table style="width: 100%; border-collapse: collapse; margin-top: 18px;">
                <tr>
                    <td style="width: 48%; vertical-align: top;">
                        <div class="sig-box">
                            <div class="sig-label">Pour le Prêteur — {{ config('credit.brand') }}</div>
                            <div class="sig-area signed">
                                <span style="font-weight: bold; font-family: sans-serif; font-size: 11pt;">VALIDE &amp; APPROUVÉ</span>
                            </div>
                            <div class="sig-date">
                                {{ config('credit.brand') }} · Service Engagement<br>
                                Signé le {{ $generatedAt->format('d/m/Y') }}
                            </div>
                        </div>
                    </td>
                    <td style="width: 4%;"></td>
                    <td style="width: 48%; vertical-align: top;">
                        <div class="sig-box">
                            <div class="sig-label">L'Emprunteur</div>
                            <div class="sig-area">
                                Signature de {{ $application->prenom }} {{ $application->nom }}
                            </div>
                            <div class="sig-date">
                                Fait à : ............................................<br>
                                Le : .......... / .......... / 2026
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

        </div>

    </div>

</body>
</html>
