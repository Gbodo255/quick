@extends('admin.layout')
@section('title', 'Mon Profil — QuickCredit')

@section('content')
@php $user = Auth::user(); @endphp

{!! '<style>
    .profile-header { margin-bottom: 24px; padding: 0 4px; }
    .profile-title { font-size: 28px; font-weight: 700; color: #0f172a; margin: 0 0 8px 0; font-family: "Inter", sans-serif; letter-spacing: -0.02em; }
    .profile-subtitle { font-size: 14px; color: #64748b; margin: 0; }

    .profile-grid { display: grid; grid-template-columns: minmax(0, 1.8fr) minmax(0, 1fr); gap: 24px; align-items: start; }
    
    @media(max-width: 900px) {
        .profile-grid { grid-template-columns: 1fr; }
    }

    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-bottom: 24px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.01);
    }
    .profile-card-header {
        padding: 20px 24px 16px 24px;
        border-bottom: 1px solid #f8fafc;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .profile-card-header h2 { font-size: 16px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px; }
    .profile-card-header h2 svg { width: 18px; height: 18px; color: #0f172a; }
    .profile-card-body { padding: 24px; }
    
    /* Info Personnelles */
    .info-container { display: flex; gap: 32px; align-items: flex-start; }
    .avatar-col { display: flex; flex-direction: column; align-items: center; gap: 12px; width: 120px; flex-shrink: 0; }
    .avatar-wrapper { position: relative; width: 100px; height: 100px; border-radius: 12px; overflow: hidden; background: #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
    .avatar-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-badge { position: absolute; bottom: 4px; right: 4px; background: #0f172a; color: #fff; width: 24px; height: 24px; border-radius: 6px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
    .avatar-badge svg { width: 14px; height: 14px; }
    .role-text { font-size: 12px; font-weight: 600; color: #475569; text-align: center; }
    
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; width: 100%; }
    .form-group { display: flex; flex-direction: column; gap: 8px; }
    .form-label { font-size: 13px; font-weight: 600; color: #475569; }
    .form-input {
        padding: 10px 12px;
        font-size: 13px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background: #f8fafc;
        color: #0f172a;
        outline: none;
        transition: all 0.2s;
        font-weight: 500;
    }
    .form-input:focus { border-color: #0f172a; background: #ffffff; }
    
    /* Sécurité */
    .security-row { display: flex; justify-content: space-between; align-items: center; padding-bottom: 24px; border-bottom: 1px solid #f1f5f9; margin-bottom: 24px; }
    .security-row:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
    .sec-info h4 { font-size: 13px; font-weight: 700; color: #0f172a; margin: 0 0 4px 0; }
    .sec-info p { font-size: 13px; color: #64748b; margin: 0; }
    .btn-outline { padding: 6px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 12px; font-weight: 600; color: #0f172a; background: #fff; cursor: pointer; }
    .btn-outline:disabled { opacity: 0.5; cursor: not-allowed; }
    .text-danger { color: #dc2626; font-size: 12px; font-weight: 700; cursor: pointer; text-decoration: none; }
    
    .badge-success { background: #6ee7b7; color: #065f46; font-size: 10px; font-weight: 800; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 8px; }
    
    .sec-icon-box { width: 36px; height: 36px; border-radius: 8px; background: #ecfdf5; display: flex; align-items: center; justify-content: center; color: #059669; flex-shrink: 0; }
    .sec-icon-box svg { width: 18px; height: 18px; }
    
    /* Notifications */
    .notif-section { margin-bottom: 28px; }
    .notif-title { font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; }
    .notif-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    .notif-row:last-child { margin-bottom: 0; }
    .notif-name { font-size: 13px; color: #334155; font-weight: 500; }
    .notif-desc { font-size: 11px; color: #94a3b8; margin-top: 2px; }
    
    /* Toggles */
    .toggle-switch { position: relative; display: inline-block; width: 40px; height: 22px; }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #e2e8f0; transition: .3s; border-radius: 22px; }
    .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 2px; bottom: 2px; background-color: white; transition: .3s; border-radius: 50%; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
    input:checked + .slider { background-color: #059669; }
    input:checked + .slider:before { transform: translateX(18px); }
    
    /* Custom Checkbox */
    .custom-checkbox { width: 16px; height: 16px; border-radius: 4px; border: 1px solid #cbd5e1; appearance: none; cursor: pointer; position: relative; background: #fff; }
    .custom-checkbox:checked { background: #0f172a; border-color: #0f172a; }
    .custom-checkbox:checked::after { content: "✓"; position: absolute; color: #fff; font-size: 10px; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: bold; }
    
    /* Sessions */
    .session-item { display: flex; gap: 12px; padding: 12px; border: 1px solid #f1f5f9; border-radius: 8px; margin-bottom: 12px; background: #fff; }
    .session-item.current { border-color: #a7f3d0; background: #f0fdf4; }
    .session-icon { color: #0f172a; margin-top: 2px; }
    .session-icon svg { width: 18px; height: 18px; }
    .session-details { flex: 1; }
    .session-device { font-size: 12px; font-weight: 700; color: #0f172a; margin-bottom: 2px; }
    .session-meta { font-size: 11px; color: #64748b; }
    .session-current-badge { font-size: 9px; font-weight: 800; color: #059669; text-transform: uppercase; margin-top: 6px; letter-spacing: 0.05em; }
    .session-close { color: #94a3b8; cursor: pointer; }
    .session-close:hover { color: #0f172a; }
    
    .btn-block-danger { display: block; width: 100%; text-align: center; padding: 10px; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; font-size: 12px; font-weight: 600; background: #fff; cursor: pointer; margin-top: 16px; transition: 0.2s; }
    .btn-block-danger:hover { background: #fef2f2; }
    
    /* Bottom Actions */
    .action-bar { display: flex; justify-content: flex-end; align-items: center; gap: 16px; padding: 24px 0 32px; margin-top: 8px; }
    .btn-cancel { font-size: 13px; font-weight: 600; color: #475569; background: transparent; border: none; cursor: pointer; padding: 8px 16px; }
    .btn-cancel:hover { color: #0f172a; }
    .btn-save { padding: 10px 24px; background: #000; color: #fff; font-size: 13px; font-weight: 600; border: none; border-radius: 6px; cursor: pointer; transition: 0.2s; }
    .btn-save:hover { background: #333; }
    
</style>' !!}

{{-- Flash messages --}}
@if(session('success'))
<div style="margin-bottom:20px; padding:12px 16px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; color:#166534; font-size:14px; font-weight:500;">
    {{ session('success') }}
</div>
@endif



<form method="POST" action="{{ route('admin.profile.update') }}">
@csrf
<div class="profile-grid">
    {{-- LEFT COLUMN --}}
    <div class="left-col">
        
        {{-- Card: Informations Personnelles --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <h2>
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                    Informations Personnelles
                </h2>
            </div>
            <div class="profile-card-body">
                <div class="info-container">
                    <div class="avatar-col">
                        <div class="avatar-wrapper">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? $user->email) }}&background=e2e8f0&color=0f172a&size=200&font-size=0.33" alt="Avatar">
                            <div class="avatar-badge">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" /></svg>
                            </div>
                        </div>
                        <div class="role-text">{{ $user->isAdmin() ? 'Admin Principal' : 'Employé' }}</div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nom Complet</label>
                            <input class="form-input" type="text" name="name" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Adresse Email</label>
                            <input class="form-input" type="email" name="email" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Sécurité --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <h2>
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    Sécurité
                </h2>
            </div>
            <div class="profile-card-body">
                <div class="security-row" style="border-bottom:none; margin-bottom:0; padding-bottom:0;">
                    <div class="sec-info">
                        <h4>Mot de passe</h4>
                        <p>Dernière modification : il y a 3 mois</p>
                    </div>
                    <div>
                        <button type="button" class="btn-outline" disabled title="Seul le super-admin peut modifier votre mot de passe">Modifier</button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    {{-- RIGHT COLUMN --}}
    <div class="right-col">
        
        {{-- Card: Notifications --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <h2>
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
                    Notifications
                </h2>
            </div>
            <div class="profile-card-body">
                <div class="notif-section">
                    <div class="notif-title">CANAUX</div>
                    <div class="notif-row">
                        <span class="notif-name">Email</span>
                        <label class="toggle-switch">
                            <input type="checkbox" name="preferences[email]" value="1" {{ ($user->notification_preferences['email'] ?? true) ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
                
                <div class="notif-section" style="margin-bottom:0;">
                    <div class="notif-title">ALERTES SYSTÈME</div>
                    <div class="notif-row">
                        <div>
                            <div class="notif-name">Nouveaux Dossiers</div>
                            <div class="notif-desc">Lorsqu'un dossier est assigné</div>
                        </div>
                        <input type="checkbox" name="preferences[new_dossier]" value="1" class="custom-checkbox" {{ ($user->notification_preferences['new_dossier'] ?? true) ? 'checked' : '' }}>
                    </div>
                    <div class="notif-row">
                        <div>
                            <div class="notif-name">Alertes Critiques</div>
                            <div class="notif-desc">Transactions à haut risque</div>
                        </div>
                        <input type="checkbox" name="preferences[critical_alerts]" value="1" class="custom-checkbox" {{ ($user->notification_preferences['critical_alerts'] ?? true) ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Sessions Actives --}}
        <div class="profile-card">
            <div class="profile-card-header">
                <h2>
                    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" /></svg>
                    Sessions Actives
                </h2>
            </div>
            <div class="profile-card-body">
                @foreach($sessions as $s)
                @php 
                    $isCurrent = $s->id === session()->getId(); 
                    $agent = $s->user_agent;
                    $browser = str_contains(strtolower($agent), 'chrome') ? 'Chrome' : (str_contains(strtolower($agent), 'firefox') ? 'Firefox' : (str_contains(strtolower($agent), 'safari') ? 'Safari' : 'Navigateur'));
                    $os = str_contains(strtolower($agent), 'mac') ? 'Mac' : (str_contains(strtolower($agent), 'windows') ? 'Windows' : (str_contains(strtolower($agent), 'iphone') || str_contains(strtolower($agent), 'ipad') ? 'iOS' : 'Appareil'));
                @endphp
                <div class="session-item {{ $isCurrent ? 'current' : '' }}">
                    <div class="session-icon">
                        @if(str_contains(strtolower($agent), 'mobi'))
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" /></svg>
                        @else
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" /></svg>
                        @endif
                    </div>
                    <div class="session-details">
                        <div class="session-device">{{ $os }} • {{ $browser }}</div>
                        <div class="session-meta">
                            {{ $s->ip_address }}<br>
                            @if(!$isCurrent)
                            Dernière activité : {{ \Carbon\Carbon::createFromTimestamp($s->last_activity)->diffForHumans() }}
                            @endif
                        </div>
                        @if($isCurrent)
                        <div class="session-current-badge">SESSION ACTUELLE</div>
                        @endif
                    </div>
                </div>
                @endforeach
                
                @if(count($sessions) > 1)
                <button type="submit" formaction="{{ route('admin.profile.sessions.logout') }}" class="btn-block-danger">Déconnecter tous les autres appareils</button>
                @endif
            </div>
        </div>

    </div>
</div>

<div class="action-bar">
    <button type="button" onclick="window.history.back();" class="btn-cancel">Annuler</button>
    <button type="submit" class="btn-save">Enregistrer les modifications</button>
</div>
</form>
@endsection
