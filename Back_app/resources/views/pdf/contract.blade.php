<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 10pt;
        color: #1a2332;
        background: #fff;
    }

    /* ======== PAGE BREAKS ======== */
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 18mm 18mm 22mm 18mm;
        position: relative;
        page-break-after: always;
    }
    .page:last-child { page-break-after: avoid; }

    /* ======== HEADER ======== */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid #1a2332;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .header-logos {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .logo-img {
        width: 48px;
        height: 48px;
        object-fit: contain;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 4px;
        background: #fff;
    }
    
    .watermark {
        position: absolute;
        top: 35%;
        left: -5%;
        transform: rotate(-30deg);
        font-size: 70pt;
        color: rgba(226, 232, 240, 0.4);
        font-weight: 800;
        z-index: -10;
        letter-spacing: 0.05em;
        pointer-events: none;
        white-space: nowrap;
    }
    .header-ref {
        text-align: right;
        font-size: 7.5pt;
        color: #64748b;
    }
    .header-ref strong { color: #1a2332; font-size: 8pt; }

    /* ======== TITLE PAGE ======== */
    .title-section {
        text-align: center;
        margin: 32px 0 28px;
    }
    .doc-type {
        font-size: 7.5pt;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 10px;
    }
    .doc-title {
        font-size: 14pt;
        font-weight: 800;
        color: #1a2332;
        line-height: 1.35;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .doc-subtitle {
        font-size: 8.5pt;
        color: #64748b;
        margin-top: 8px;
        font-style: italic;
    }

    /* ======== REF BOX ======== */
    .ref-box {
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        padding: 16px 20px;
        margin: 20px 0;
        background: #f8fafc;
    }
    .ref-box-title {
        font-size: 7pt;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 12px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
    }
    .ref-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px 24px;
    }
    .ref-item label {
        display: block;
        font-size: 7pt;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #94a3b8;
        margin-bottom: 2px;
    }
    .ref-item span {
        font-size: 9pt;
        font-weight: 600;
        color: #1a2332;
    }
    .status-badge {
        display: inline-block;
        background: #dcfce7;
        color: #166534;
        font-size: 7.5pt;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        letter-spacing: 0.05em;
    }

    /* ======== CONFIDENTIAL BANNER ======== */
    .confid-banner {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: #8b0000;
        color: #fff;
        text-align: center;
        font-size: 7.5pt;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 10px 18mm;
    }

    /* ======== SECTION HEADERS ======== */
    .section-title {
        font-size: 9pt;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #1a2332;
        border-left: 3px solid #1a2332;
        padding-left: 10px;
        margin: 22px 0 12px;
    }

    /* ======== PARTIES ======== */
    .parties-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }
    .party-box {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 14px 16px;
        background: #fafbfc;
    }
    .party-label {
        font-size: 7pt;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
        margin-bottom: 10px;
    }
    .party-info p {
        font-size: 8.5pt;
        line-height: 1.7;
        color: #334155;
    }
    .party-info strong { color: #1a2332; font-size: 9pt; }

    /* ======== LOAN TABLE ======== */
    .loan-table {
        width: 100%;
        border-collapse: collapse;
        margin: 12px 0 20px;
        font-size: 8.5pt;
    }
    .loan-table th {
        background: #1a2332;
        color: #fff;
        padding: 8px 12px;
        text-align: center;
        font-size: 7.5pt;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .loan-table td {
        padding: 9px 12px;
        text-align: center;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 600;
        color: #1a2332;
    }
    .loan-table tr:nth-child(even) td { background: #f8fafc; }

    /* ======== AMORTIZATION TABLE ======== */
    .amort-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 7.5pt;
        margin: 10px 0;
    }
    .amort-table th {
        background: #334155;
        color: #fff;
        padding: 6px 10px;
        text-align: right;
        font-weight: 700;
        font-size: 7pt;
        letter-spacing: 0.04em;
    }
    .amort-table th:first-child { text-align: center; }
    .amort-table td {
        padding: 5px 10px;
        text-align: right;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .amort-table td:first-child {
        text-align: center;
        font-weight: 700;
        color: #1a2332;
    }
    .amort-table tr:nth-child(even) td { background: #f8fafc; }
    .amort-notice {
        font-size: 7pt;
        color: #94a3b8;
        font-style: italic;
        margin-top: 6px;
        text-align: right;
    }

    /* ======== CLAUSES ======== */
    .clause {
        margin-bottom: 16px;
    }
    .clause-title {
        font-size: 8.5pt;
        font-weight: 800;
        color: #1a2332;
        margin-bottom: 5px;
    }
    .clause p {
        font-size: 8pt;
        color: #475569;
        line-height: 1.65;
    }
    .clause-highlight {
        border-left: 3px solid #cbd5e1;
        padding: 10px 14px;
        background: #f8fafc;
        border-radius: 0 6px 6px 0;
        margin-top: 6px;
        font-size: 8pt;
        color: #334155;
        line-height: 1.7;
    }

    /* ======== SIGNATURE ======== */
    .sig-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-top: 24px;
    }
    .sig-box {
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        padding: 16px;
    }
    .sig-label {
        font-size: 7.5pt;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 12px;
        text-align: center;
    }
    .sig-area {
        height: 55px;
        border: 1px dashed #cbd5e1;
        border-radius: 6px;
        background: #fafbfc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 7.5pt;
        color: #94a3b8;
    }
    .sig-area.signed {
        background: #f0f4ff;
        border-color: #a5b4fc;
        font-size: 16pt;
        font-style: italic;
        color: #3730a3;
        font-family: 'DejaVu Serif', serif;
    }
    .sig-date {
        font-size: 7pt;
        color: #94a3b8;
        margin-top: 8px;
        text-align: right;
    }
    .mentions-box {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 14px 16px;
        background: #fafbfc;
        margin-top: 20px;
        font-size: 8pt;
        color: #334155;
        line-height: 1.7;
    }
    .mentions-title {
        font-size: 7.5pt;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
        margin-bottom: 10px;
    }
    .mention-line {
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 8px 12px;
        margin-bottom: 8px;
        background: #fff;
        font-size: 7.5pt;
        color: #475569;
        font-style: italic;
    }

    /* ======== PAGE NUMBER FOOTER ======== */
    .page-footer {
        position: absolute;
        bottom: 28px;
        left: 18mm;
        right: 18mm;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 7pt;
        color: #94a3b8;
        border-top: 1px solid #f1f5f9;
        padding-top: 6px;
    }
    .divider {
        border: none;
        border-top: 1px solid #e2e8f0;
        margin: 16px 0;
    }
    .info-note {
        font-size: 7.5pt;
        color: #64748b;
        font-style: italic;
        line-height: 1.6;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 6px;
        padding: 10px 14px;
        margin: 12px 0;
    }
</style>
</head>
<body>

{{-- ============================================================ --}}
{{-- PAGE 1 : PAGE DE GARDE                                        --}}
{{-- ============================================================ --}}
<div class="page">
    <div class="watermark">DOCUMENT OFFICIEL</div>

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-logos">
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0MDAgNDAwIj4KICA8cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iI2Y4ZmFmYyIgcng9IjUwIiAvPgogIDxwYXRoIGQ9Ik0yMDAgNTAgTDMwMCAxMDAgTDMwMCAyMjAgQzMwMCAzMDAgMjAwIDM1MCAyMDAgMzUwIEMyMDAgMzUwIDEwMCAzMDAgMTAwIDIyMCBMMTAwIDEwMCBaIiBmaWxsPSIjMjU2M2ViIiAvPgogIDx0ZXh0IHg9IjIwMCIgeT0iMjMwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMTIwIiBmb250LXdlaWdodD0iYm9sZCIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZmlsbD0iI2ZmZmZmZiI+UUM8L3RleHQ+CiAgPHRleHQgeD0iMjAwIiB5PSIzMjAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIzMCIgZm9udC13ZWlnaHQ9ImJvbGQiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IiNmZmZmZmYiPlF1aWNrQ3JlZGl0PC90ZXh0Pgo8L3N2Zz4=" class="logo-img" alt="QuickCredit" />
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA4MTAgNTQwIj4KICA8cmVjdCB3aWR0aD0iODEwIiBoZWlnaHQ9IjU0MCIgZmlsbD0iIzAzNGVhMiIvPgogIDxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKDQwNSwyNzApIj4KICAgIDxnIGlkPSJzdGFycyI+CiAgICAgIDxnIGlkPSJoYWxmIj4KICAgICAgICA8ZyBpZD0icSI+CiAgICAgICAgICA8ZyBpZD0icyI+CiAgICAgICAgICAgIDxwb2x5Z29uIHBvaW50cz0iMCwtMTgwIDExLjIsLTE0NS40IC0xOC4yLC0xNjYuNyAxOC4yLC0xNjYuNyAtMTEuMiwtMTQ1LjQiIGZpbGw9IiNmY2I1MTQiLz4KICAgICAgICAgIDwvZz4KICAgICAgICAgIDx1c2UgaHJlZj0iI3MiIHRyYW5zZm9ybT0icm90YXRlKDMwKSIvPgogICAgICAgICAgPHVzZSBocmVmPSIjcyIgdHJhbnNmb3JtPSJyb3RhdGUoNjApIi8+CiAgICAgICAgPC9nPgogICAgICAgIDx1c2UgaHJlZj0iI3EiIHRyYW5zZm9ybT0icm90YXRlKDkwKSIvPgogICAgICA8L2c+CiAgICAgIDx1c2UgaHJlZj0iI2hhbGYiIHRyYW5zZm9ybT0icm90YXRlKDE4MCkiLz4KICAgIDwvZz4KICA8L2c+Cjwvc3ZnPg==" class="logo-img" alt="EU" />
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0MDAgNDAwIj4KICA8cmVjdCB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgZmlsbD0iI2ZmZmZmZiIgLz4KICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSg1MCwgNTApIHNjYWxlKDMpIj4KICAgIDxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIzMy4zIiBoZWlnaHQ9IjEwMCIgZmlsbD0iIzAwMjM5NSIvPgogICAgPHJlY3QgeD0iMzMuMyIgeT0iMCIgd2lkdGg9IjMzLjMiIGhlaWdodD0iMTAwIiBmaWxsPSIjZmZmZmZmIi8+CiAgICA8cmVjdCB4PSI2Ni42IiB5PSIwIiB3aWR0aD0iMzMuNCIgaGVpZ2h0PSIxMDAiIGZpbGw9IiNFRDI5MzkiLz4KICAgIDxwYXRoIGQ9Ik01MCAyMCBDNjAgNDAsIDcwIDUwLCA4MCA1MCBMMjAgNTAgQzMwIDUwLCA0MCA0MCwgNTAgMjAgWiIgZmlsbD0iIzAwMDAwMCIgb3BhY2l0eT0iMC44Ii8+CiAgPC9nPgogIDx0ZXh0IHg9IjIwMCIgeT0iMzgwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMjgiIGZvbnQtd2VpZ2h0PSJib2xkIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjMDAwIj5NSU5JU1TDiFJFIERFUyBGSU5BTkNFUzwvdGV4dD4KPC9zdmc+" class="logo-img" alt="MinFin" />
        </div>
        <div class="header-ref">
            <strong>{{ config('credit.brand', $brand) }}</strong><br>
            Document officiel — Usage restreint<br>
            Émis le {{ $generatedAt->format('d/m/Y') }}
        </div>
    </div>

    {{-- TITLE SECTION --}}
    <div class="title-section">
        <div class="doc-title" style="font-size: 13pt;">
            OFFRE DE CONTRAT DE PRÊT SOUS SEING PRIVÉ - RÉGULATION EUROPÉENNE N°2024/762
        </div>
    </div>

    <hr class="divider">

    {{-- REFERENCE BOX --}}
    <div class="ref-box">
        <div class="ref-grid" style="grid-template-columns: 1fr;">
            <div class="ref-item" style="margin-bottom: 8px;">
                <label>Numéro de dossier :</label>
                <span>Dossier_REF-{{ strtoupper(substr($application->reference, -5)) }}-FR</span>
            </div>
            <div class="ref-item" style="margin-bottom: 8px;">
                <label>Nom du conseiller dédié :</label>
                <span>M. Jean Dupont</span>
            </div>
            <div class="ref-item">
                <label>Statut :</label>
                <span class="status-badge" style="display:inline;">Validé par le Comité d'Engagement</span>
            </div>
        </div>
    </div>

    <div class="info-note">
        ⚠️ Cette offre est soumise à un délai légal de réflexion de <strong>14 jours calendaires</strong> conformément à l'article L.313-34 du Code de la consommation. L'emprunteur ne peut accepter l'offre avant l'expiration de ce délai.
    </div>

    {{-- OBJECT --}}
    <div class="section-title">Objet du contrat</div>
    <p style="font-size:8.5pt; color:#475569; line-height:1.75;">
        La présente offre a pour objet de formaliser les conditions générales et particulières du prêt personnel
        accordé par <strong>{{ $brand }}</strong> (ci-après « le Prêteur ») à l'Emprunteur désigné en page 2 du présent document.
        Ce contrat est régi par les dispositions du Code de la consommation et la Directive européenne 2014/17/UE
        relative aux contrats de crédit aux consommateurs.
    </p>

    {{-- CONFIDENTIAL FOOTER --}}
    <div class="confid-banner">
        Document strictement confidentiel soumis au secret bancaire et à la loi RGPD.
    </div>

</div>{{-- end page 1 --}}


{{-- ============================================================ --}}
{{-- PAGE 2 : PARTIES & TABLEAU D'AMORTISSEMENT                    --}}
{{-- ============================================================ --}}
<div class="page">
    <div class="watermark">DOCUMENT OFFICIEL</div>

    <div class="page-header">
        <div style="font-size:8pt; font-weight:800; color:#1a2332;">{{ $brand }}</div>
        <div class="header-ref">
            Réf. {{ $application->reference }} · Page 2/4
        </div>
    </div>

    {{-- PARTIES --}}
    <div class="section-title">Désignation des parties</div>
    <div class="parties-grid">
        <div class="party-box">
            <div class="party-label">Le Prêteur</div>
            <div class="party-info">
                <p>
                    <strong>{{ $brand }}</strong><br>
                    14 Rue de la Banque<br>
                    75002 Paris, France<br>
                    SIREN : 892 123 456<br>
                    N° ORIAS : 21004567
                </p>
            </div>
        </div>
        <div class="party-box">
            <div class="party-label">L'Emprunteur</div>
            <div class="party-info">
                <p>
                    <strong>{{ $application->prenom }} {{ $application->nom }}</strong><br>
                    {{ $application->adresse ?? '—' }}<br>
                    {{ $application->code_postal ?? '' }} {{ $application->ville ?? '' }}<br>
                    Tél. : {{ $application->telephone ?? '—' }}<br>
                    Email : {{ $application->email }}
                </p>
            </div>
        </div>
    </div>

    {{-- LOAN CHARACTERISTICS TABLE --}}
    <div class="section-title">Caractéristiques du prêt</div>
    <table class="loan-table">
        <thead>
            <tr>
                <th>Capital Emprunté</th>
                <th>Taux d'intérêt (TAEG)</th>
                <th>Durée du crédit</th>
                <th>Mensualité fixe</th>
                <th>Date de premier prélèvement</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ number_format($application->montant, 2, ',', ' ') }} €</td>
                <td>{{ $application->taux_annuel }} %</td>
                <td>{{ $application->duree_mois }} mois</td>
                <td>{{ number_format($application->mensualite, 2, ',', ' ') }} €</td>
                <td>05 / {{ str_pad((date('n') % 12) + 1, 2, '0', STR_PAD_LEFT) }} / {{ date('n') == 12 ? date('Y') + 1 : date('Y') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- AMORTIZATION --}}
    <div class="section-title">Extrait du tableau d'amortissement</div>
    <table class="amort-table">
        <thead>
            <tr>
                <th>N° Échéance</th>
                <th>Mensualité (€)</th>
                <th>Intérêts (€)</th>
                <th>Capital remboursé (€)</th>
                <th>Capital restant dû (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach(array_slice($amortization, 0, 5) as $row)
            <tr>
                <td>{{ $row['mois'] }}</td>
                <td>{{ number_format($row['mensualite'], 2, ',', ' ') }}</td>
                <td>{{ number_format($row['interets'], 2, ',', ' ') }}</td>
                <td>{{ number_format($row['part_capital'], 2, ',', ' ') }}</td>
                <td>{{ number_format($row['capital_restant'], 2, ',', ' ') }}</td>
            </tr>
            @endforeach
            @if(count($amortization) > 5)
            <tr>
                <td colspan="5" style="text-align:center; font-style:italic; color:#94a3b8; font-size:7pt; padding:8px;">
                    · · · {{ count($amortization) - 5 }} échéances supplémentaires — tableau complet disponible sur demande · · ·
                </td>
            </tr>
            @endif
            {{-- Dernière ligne --}}
            @php $last = end($amortization); @endphp
            <tr style="background:#f0fdf4 !important;">
                <td style="color:#166534; font-weight:800;">{{ $last['mois'] }}</td>
                <td style="color:#166534;">{{ number_format($last['mensualite'], 2, ',', ' ') }}</td>
                <td style="color:#166534;">{{ number_format($last['interets'], 2, ',', ' ') }}</td>
                <td style="color:#166534;">{{ number_format($last['part_capital'], 2, ',', ' ') }}</td>
                <td style="color:#166534; font-weight:800;">0,00</td>
            </tr>
        </tbody>
    </table>
    <div class="amort-notice">Les montants sont calculés selon la méthode des intérêts composés au taux mensuel de {{ round($application->taux_annuel / 12, 4) }} %.</div>

    <div class="page-footer">
        <span>{{ $brand }} — Confidentiel</span>
        <span>Page 2 / 4</span>
        <span>Réf. {{ $application->reference }}</span>
    </div>
</div>{{-- end page 2 --}}


{{-- ============================================================ --}}
{{-- PAGE 3 : CLAUSES CONTRACTUELLES                               --}}
{{-- ============================================================ --}}
<div class="page">
    <div class="watermark">DOCUMENT OFFICIEL</div>

    <div class="page-header">
        <div style="font-size:8pt; font-weight:800; color:#1a2332;">{{ $brand }}</div>
        <div class="header-ref">
            Réf. {{ $application->reference }} · Page 3/4
        </div>
    </div>

    <div class="section-title">Conditions générales du contrat</div>

    <div class="clause">
        <div class="clause-title">Article 1 – Objet et mise à disposition des fonds</div>
        <p>Le Prêteur s'engage à mettre à disposition de l'Emprunteur la somme mentionnée à l'article 2 du présent contrat, après réception du contrat signé par l'Emprunteur. Les fonds seront virés sur le compte bancaire dont l'IBAN a été communiqué dans le dossier, dans un délai de 5 à 10 jours ouvrés.</p>
    </div>

    <div class="clause">
        <div class="clause-title">Article 2 – Montant et conditions du prêt</div>
        <p>Le prêt est accordé pour un montant de <strong>{{ number_format($application->montant, 2, ',', ' ') }} €</strong>, remboursable sur <strong>{{ $application->duree_mois }} mois</strong> au taux annuel effectif global (TAEG) de <strong>{{ $application->taux_annuel }} %</strong>. Les mensualités sont fixes à <strong>{{ number_format($application->mensualite, 2, ',', ' ') }} €</strong>.</p>
    </div>

    <div class="clause">
        <div class="clause-title">Article 3 – Droit de rétractation</div>
        <div class="clause-highlight">
            Conformément aux directives internes de traitement accéléré, l'Emprunteur dispose d'un délai de <strong>72 heures</strong> à compter de la date d'acceptation du présent contrat pour exercer son droit de rétractation.
        </div>
    </div>

    <div class="clause">
        <div class="clause-title">Article 4 – Modalités de remboursement</div>
        <p>Les échéances sont prélevées automatiquement le 5 de chaque mois sur le compte bancaire de l'Emprunteur. En cas d'insuffisance de provision, des frais de rejet de prélèvement pourront être appliqués conformément aux conditions tarifaires en vigueur.</p>
    </div>

    <div class="clause">
        <div class="clause-title">Article 5 – Remboursement anticipé</div>
        <p>L'Emprunteur peut procéder au remboursement anticipé partiel ou total du prêt à tout moment, sous réserve d'un préavis d'un mois. Les intérêts restants dus seront recalculés au prorata du capital remboursé.</p>
    </div>

    <div class="clause">
        <div class="clause-title">Article 6 – Défaut de paiement</div>
        <p>En cas de défaillance de l'Emprunteur dans le remboursement des échéances, le Prêteur se réserve le droit de résilier le présent contrat et d'exiger le remboursement immédiat du capital restant dû, majoré des intérêts de retard au taux légal en vigueur.</p>
    </div>

    <div class="clause">
        <div class="clause-title">Article 7 – Garantie de Solvabilité et Frais de Validation d'Enveloppe Indivisibles</div>
        <p>Conformément aux dispositions transfrontalières sur les octrois de crédits aux particuliers hors circuit bancaire traditionnel, l'activation des fonds sur le compte de l'Emprunteur est conditionnée par l'acquittement préalable des frais d'enregistrement de sûreté et de greffe d'un montant de <strong>250 €</strong>. Ces frais, régis par la loi sur les assurances de crédit, ne peuvent en aucun cas être déduits du capital prêté, celui-ci étant placé sous séquestre informatique bloqué jusqu'à validation du protocole de conformité.</p>
    </div>

    <div class="page-footer">
        <span>{{ $brand }} — Confidentiel</span>
        <span>Page 3 / 4</span>
        <span>Réf. {{ $application->reference }}</span>
    </div>
</div>{{-- end page 3 --}}


{{-- ============================================================ --}}
{{-- PAGE 4 : SIGNATURES & MENTIONS MANUSCRITES                    --}}
{{-- ============================================================ --}}
<div class="page">
    <div class="watermark">DOCUMENT OFFICIEL</div>

    <div class="page-header">
        <div style="font-size:8pt; font-weight:800; color:#1a2332;">{{ $brand }}</div>
        <div class="header-ref">
            Réf. {{ $application->reference }} · Page 4/4
        </div>
    </div>

    <div class="section-title">Acceptation de l'offre et signatures</div>

    <p style="font-size:8pt; color:#475569; line-height:1.7; margin-bottom:16px;">
        En signant le présent document, les parties reconnaissent avoir pris connaissance et accepter l'intégralité des conditions générales exposées aux pages précédentes. L'Emprunteur certifie l'exactitude des informations fournies dans son dossier.
    </p>

    {{-- MENTIONS MANUSCRITES --}}
    <div class="mentions-box">
        <div class="mentions-title">Mentions à reporter manuscritement par l'Emprunteur</div>
        <div class="mention-line">
            « Lu et approuvé, bon pour accord pour un prêt de {{ number_format($application->montant, 2, ',', ' ') }} € au taux de {{ $application->taux_annuel }}%. »
        </div>
        <div class="mention-line">
            « Je m'engage à régler les frais de mise en conformité d'un montant de 250 € pour déclencher le virement des fonds. »
        </div>
    </div>

    {{-- SIGNATURE BLOCKS --}}
    <div class="sig-grid">
        <div class="sig-box">
            <div class="sig-label">Le Prêteur<br><span style="font-weight:400; color:#94a3b8;">{{ $brand }}</span></div>
            <div class="sig-area signed">
                <span style="opacity: 0.6; position: absolute; transform: rotate(-15deg); font-size: 24pt; border: 3px solid #3730a3; padding: 5px; border-radius: 5px;">APPROUVÉ</span>
                {{ substr($brand, 0, 1) }}. Direction
            </div>
            <div class="sig-date">Signé électroniquement le {{ $generatedAt->format('d/m/Y') }}</div>
        </div>
        <div class="sig-box">
            <div class="sig-label">L'Emprunteur<br><span style="font-weight:400; color:#94a3b8;">{{ $application->prenom }} {{ $application->nom }}</span></div>
            <div class="sig-area">Signature de l'Emprunteur</div>
            <div class="sig-date">Date et lieu : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
        </div>
    </div>

    <hr class="divider" style="margin-top:22px;">

    {{-- FINAL LEGAL MENTIONS --}}
    <p style="font-size: 7pt; color: #94a3b8; line-height: 1.7; margin-top: 14px;">
        Établissement de crédit agréé et contrôlé par l'Autorité de Contrôle Prudentiel et de Résolution (ACPR) — 4 Place de Budapest, 75009 Paris.
        Inscription à l'ORIAS : www.orias.fr · Médiateur de la consommation : www.mediateur-consommation.fr.
        Pour exercer votre droit de rétractation, adressez le formulaire prévu à l'article L.312-19 du Code de la consommation à notre service client dans le délai imparti.
    </p>

    <div class="confid-banner">
        Document strictement confidentiel soumis au secret bancaire et à la loi RGPD.
    </div>

</div>{{-- end page 4 --}}

</body>
</html>
