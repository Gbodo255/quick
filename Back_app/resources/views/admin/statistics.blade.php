@extends('admin.layout')
@section('title', 'Dashboard — QuickCredit Admin')

@section('content')

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

{!! '<style>
    /* ---- Page header ---- */
    .dash-header {
        display: flex; align-items: center; justify-content: flex-end;
        margin-bottom: 1.5rem;
    }
    .dash-header-actions { display: flex; align-items: center; gap: 0.75rem; }
    .btn-outline {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 0.5rem 1rem; background: #fff;
        border: 1px solid #e2e8f0; border-radius: 8px;
        font-size: 0.8rem; font-weight: 500; color: #475569;
        cursor: pointer; font-family: inherit; transition: border-color 0.15s;
    }
    .btn-outline:hover { border-color: #94a3b8; }
    .btn-primary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 0.5rem 1.1rem; background: #4f46e5; color: #fff;
        border: none; border-radius: 8px;
        font-size: 0.8rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: background 0.15s;
        text-decoration: none;
    }
    .btn-primary:hover { background: #4338ca; }

    /* ---- Stat cards ---- */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.875rem; margin-bottom: 1.25rem; }
    .stat-card  {
        background: #fff; border: 1px solid #e2e8f0; border-radius: 12px;
        padding: 1rem 1.1rem;
    }
    .stat-icon-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.6rem; }
    .stat-icon-box {
        height: 32px; width: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
    }
    .stat-pct {
        font-size: 0.68rem; font-weight: 700; padding: 0.15rem 0.45rem;
        border-radius: 6px; display: inline-flex; align-items: center; gap: 2px;
    }
    .stat-pct.up   { background: #f0fdf4; color: #166534; }
    .stat-pct.down { background: #fef2f2; color: #b91c1c; }
    .stat-label { font-size: 0.68rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
    .stat-value { font-size: 1.55rem; font-weight: 800; color: #0f172a; line-height: 1.1; }

    /* ---- Charts row ---- */
    .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.25rem; }
    .widget { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; }
    .widget-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1rem 1.25rem; border-bottom: 1px solid #f1f5f9;
    }
    .widget-title { font-size: 0.875rem; font-weight: 700; color: #0f172a; }

    /* ---- Bottom row ---- */
    .bottom-grid { display: grid; grid-template-columns: 3fr 2fr; gap: 1rem; }

    /* ---- Table ---- */
    .dash-table { width: 100%; border-collapse: collapse; }
    .dash-table th {
        padding: 0.6rem 1rem; text-align: left;
        font-size: 0.65rem; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.07em;
        background: #f8fafc; border-bottom: 1px solid #f1f5f9;
    }
    .dash-table td { padding: 0.75rem 1rem; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
    .dash-table tr:last-child td { border-bottom: none; }
    .dash-table tr:hover td { background: #fafbfc; }
    .ref-code { font-size: 0.7rem; font-weight: 700; color: #4f46e5; font-family: monospace; }
    .client-avatar {
        height: 28px; width: 28px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.62rem; font-weight: 700;
    }

    /* ---- Badges ---- */
    .badge { font-size: 0.68rem; font-weight: 600; padding: 0.2rem 0.6rem; border-radius: 6px; white-space: nowrap; }
    .badge-green  { background:#f0fdf4; color:#166534; }
    .badge-amber  { background:#fffbeb; color:#92400e; }
    .badge-blue   { background:#eff6ff; color:#1d4ed8; }
    .badge-red    { background:#fef2f2; color:#b91c1c; }
    .badge-slate  { background:#f8fafc; color:#475569; border:1px solid #e2e8f0; }
    .badge-urgent { background:#fef2f2; color:#b91c1c; font-size:0.62rem; padding:0.15rem 0.5rem; border-radius:5px; }
    .badge-normal { background:#f8fafc; color:#64748b; font-size:0.62rem; padding:0.15rem 0.5rem; border-radius:5px; border:1px solid #e2e8f0; }

    /* ---- Alertes ---- */
    .alert-item {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 0.875rem 1.25rem; border-bottom: 1px solid #f8fafc;
        transition: background 0.12s; cursor: pointer;
    }
    .alert-item:last-child { border-bottom: none; }
    .alert-item:hover { background: #f8fafc; }
    .alert-icon {
        height: 30px; width: 30px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-size: 0.8rem; font-weight: 700;
    }
    .new-badge {
        background: #ef4444; color: #fff; font-size: 0.62rem; font-weight: 700;
        padding: 0.1rem 0.45rem; border-radius: 5px;
    }

    /* ---- Pagination UI ---- */
    .pagination-container {
        display: flex; justify-content: space-between; align-items: center;
        padding: 1rem 1.25rem; border-top: 1px solid #f1f5f9;
        font-size: 0.8rem; color: #64748b;
    }
    .per-page-select {
        padding: 0.3rem 0.6rem; font-size: 0.8rem;
        border: 1px solid #e2e8f0; border-radius: 6px;
        background: #fff; color: #0f172a; outline: none;
    }
    .pagination {
        display: flex; align-items: center; gap: 0.25rem; list-style: none; margin: 0; padding: 0;
    }
    .page-item .page-link, .page-item span {
        padding: 0.35rem 0.75rem; font-size: 0.8rem; font-weight: 600;
        color: #475569; background: #fff;
        border: 1px solid #e2e8f0; border-radius: 6px; text-decoration: none;
        transition: background 0.15s;
    }
    .page-item .page-link:hover { background: #f1f5f9; color: #0f172a; }
    .page-item.active span { background: #4f46e5; color: #fff; border-color: #4f46e5; }
    .page-item.disabled span { opacity: 0.5; cursor: not-allowed; }
</style>' !!}

{{-- ===== HEADER ===== --}}
<div class="dash-header">
    <div class="dash-header-actions">
        <form method="GET" action="{{ route('admin.statistics') }}" style="display:flex; align-items:center; gap:10px;">
            <select name="period" onchange="this.form.submit()" style="padding:0.4rem 0.8rem; font-size:0.8rem; border:1px solid #e2e8f0; border-radius:8px; outline:none; background:#fff; color:#0f172a;">
                <option value="7d" {{ request('period') === '7d' ? 'selected' : '' }}>7 derniers jours</option>
                <option value="30d" {{ request('period') === '30d' ? 'selected' : '' }}>30 derniers jours</option>
                <option value="1y" {{ request('period') === '1y' ? 'selected' : '' }}>12 derniers mois</option>
            </select>
        </form>
    </div>
</div>

{{-- ===== STATS ===== --}}
@php
    $totalUsers = $users->count();
    $totalDossiers = $stats['total'];
    $newThisMonth = $stats['new_this_month'];
    $processing = $stats['processing'];
@endphp

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon-row">
            <div class="stat-icon-box" style="background:#e0e7ff;">
                <svg style="width:15px;height:15px;stroke:#4f46e5;" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
            <span class="stat-pct up">+12%</span>
        </div>
        <div class="stat-label">Total Utilisateurs</div>
        <div class="stat-value">{{ number_format($totalUsers) }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-row">
            <div class="stat-icon-box" style="background:#f0fdf4;">
                <svg style="width:15px;height:15px;stroke:#22c55e;" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
            </div>
            <span class="stat-pct up">+5.2%</span>
        </div>
        <div class="stat-label">Total Dossiers</div>
        <div class="stat-value">{{ number_format($totalDossiers) }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-row">
            <div class="stat-icon-box" style="background:#fef3c7;">
                <svg style="width:15px;height:15px;stroke:#d97706;" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2.25m0 0v2.25m0-2.25h2.25m-2.25 0H9.75M12 21a9 9 0 1 1 0-18 9 9 0 0 1 0 18Z" />
                </svg>
            </div>
            <span class="stat-pct up">+8.5%</span>
        </div>
        <div class="stat-label">Nouveaux ce mois</div>
        <div class="stat-value">{{ number_format($newThisMonth) }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-icon-row">
            <div class="stat-icon-box" style="background:#eff6ff;">
                <svg style="width:15px;height:15px;stroke:#3b82f6;" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            </div>
            <span class="stat-pct down">-2.1%</span>
        </div>
        <div class="stat-label">Dossiers en cours</div>
        <div class="stat-value">{{ number_format($processing) }}</div>
    </div>
</div>

{{-- ===== GRAPHIQUES ===== --}}
<div class="charts-grid">
    {{-- Bar chart --}}
    <div class="widget">
        <div class="widget-header">
            <div class="widget-title">Évolution des demandes</div>
        </div>
        <div style="padding:1.25rem;">
            <canvas id="barChart" style="max-height:200px;"></canvas>
        </div>
    </div>

    {{-- Donut chart --}}
    <div class="widget">
        <div class="widget-header">
            <div class="widget-title">Répartition des statuts</div>
        </div>
        <div style="padding:1.25rem; display:flex; flex-direction:column; align-items:center; gap:1rem;">
            <div style="position:relative; width:160px; height:160px;">
                <canvas id="donutChart"></canvas>
                <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
                    <div style="font-size:1.5rem;font-weight:800;color:#0f172a;">{{ $stats['total'] }}</div>
                    <div style="font-size:0.68rem;color:#94a3b8;font-weight:600;">Dossiers</div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:0.5rem;width:100%;">
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.75rem;">
                    <div style="display:flex;align-items:center;gap:7px;"><span style="display:block;height:10px;width:10px;border-radius:50%;background:#4f46e5;"></span><span style="color:#475569;">Soumis</span></div>
                    <span style="font-weight:700;color:#0f172a;">{{ $stats['submitted'] }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.75rem;">
                    <div style="display:flex;align-items:center;gap:7px;"><span style="display:block;height:10px;width:10px;border-radius:50%;background:#3b82f6;"></span><span style="color:#475569;">En cours</span></div>
                    <span style="font-weight:700;color:#0f172a;">{{ $stats['processing'] }}</span>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;font-size:0.75rem;">
                    <div style="display:flex;align-items:center;gap:7px;"><span style="display:block;height:10px;width:10px;border-radius:50%;background:#22c55e;"></span><span style="color:#475569;">Approuvés</span></div>
                    <span style="font-weight:700;color:#0f172a;">{{ $stats['completed'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== SCRIPTS CHARTS ===== --}}
<script>
// ---- Données ----
const chartData  = @json(array_reverse($chartData));
const chartLabels  = @json(array_reverse($chartLabels));

// ---- Bar chart ----
const barCtx = document.getElementById("barChart").getContext("2d");
const barChart = new Chart(barCtx, {
    type: "bar",
    data: {
        labels: chartLabels,
        datasets: [{
            data: chartData,
            backgroundColor: chartData.map((v, i) => i === chartData.indexOf(Math.max(...chartData)) ? "#4f46e5" : "#e0e7ff"),
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => " " + ctx.raw + " dossiers" } } },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 }, color: "#94a3b8" } },
            y: { grid: { color: "#f1f5f9" }, ticks: { font: { size: 11 }, color: "#94a3b8" }, beginAtZero: true }
        }
    }
});

// ---- Donut chart ----
const donutCtx = document.getElementById("donutChart").getContext("2d");
new Chart(donutCtx, {
    type: "doughnut",
    data: {
        labels: ["Soumis", "En cours", "Approuvés"],
        datasets: [{
            data: [{{ $stats["submitted"] }}, {{ $stats["processing"] }}, {{ $stats["completed"] }}],
            backgroundColor: ["#4f46e5", "#3b82f6", "#22c55e"],
            borderWidth: 0,
            hoverOffset: 4,
        }]
    },
    options: {
        responsive: true,
        cutout: "72%",
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => " " + ctx.raw + " dossiers" } }
        }
    }
});
</script>

@endsection
