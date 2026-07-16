<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — QuickCredit')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {!! '<style>
        * { font-family: "Inter", sans-serif !important; box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; background: #f8fafc; }

        /* ---- Main wrapper ---- */
        .main-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ---- Top bar ---- */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 20;
        }
        
        .topbar-logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-right { display: flex; align-items: center; gap: 1.5rem; }
        .topbar-icon-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            color: #64748b;
            display: flex; align-items: center; justify-content: center;
            transition: color 0.15s;
        }
        .topbar-icon-btn:hover { color: #0f172a; }

        /* ---- Navbar ---- */
        .main-nav {
            background-color: #2b20a0;
            background-image:
                radial-gradient(ellipse at 15% 15%,  rgba(99,102,241,0.9)  0%, transparent 55%),
                radial-gradient(ellipse at 85% 5%,   rgba(167,139,250,0.7) 0%, transparent 45%),
                radial-gradient(ellipse at 90% 80%,  rgba(192,210,255,0.5) 0%, transparent 50%),
                radial-gradient(ellipse at 5%  85%,  rgba(55,48,163,0.95)  0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%,  rgba(109,40,217,0.55) 0%, transparent 60%);
            margin: 0.5rem 1rem 1rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            padding: 0.45rem 1.5rem;
            gap: 0.5rem;
            flex-wrap: wrap;
            overflow: visible;
        }

        .nav-link {
            display: flex; align-items: center; gap: 8px;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem; font-weight: 600;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .nav-link:hover { color: #ffffff; background: rgba(255,255,255,0.1); }
        .nav-link.active { background: rgba(255,255,255,0.2); color: #ffffff; }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; stroke: currentColor; }
        
        .nav-dropdown { position: relative; display: inline-block; }
        .nav-dropdown-content {
            display: none; position: absolute; background-color: #ffffff;
            min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
            border-radius: 8px; z-index: 100; padding: 0.5rem; top: 100%; left: 0;
            border: 1px solid #e2e8f0;
        }
        .nav-dropdown:hover .nav-dropdown-content { display: flex; flex-direction: column; gap: 4px; }
        .nav-dropdown-content a {
            color: #475569; padding: 0.5rem 0.8rem; text-decoration: none; display: block; font-size: 0.85rem; border-radius: 6px; font-weight: 500;
        }
        .nav-dropdown-content a:hover { background-color: #f8fafc; color: #0f172a; }
        .nav-dropdown-content a.active { background-color: #f1f5f9; color: #0f172a; font-weight: 600; }

        /* ---- Page content ---- */
        .page-content { flex: 1; padding: 0 2rem 2rem; }

        /* ---- Flash alerts ---- */
        .flash-success {
            display: flex; align-items: center; gap: 10px;
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-radius: 10px; padding: 0.75rem 1rem;
            margin: 0 2rem 1rem;
        }
        .flash-error {
            display: flex; align-items: center; gap: 10px;
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 10px; padding: 0.75rem 1rem;
            margin: 0 2rem 1rem;
        }

        /* ---- Footer ---- */
        .main-footer {
            border-top: 1px solid #e2e8f0;
            padding: 0.875rem 2rem;
            font-size: 0.7rem; color: #94a3b8;
            text-align: center;
        }

        .fade-in { animation: fadeInUp 0.3s ease both; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>' !!}
</head>

<body>

    @hasSection('hideHeader')
        @yield('content')
    @else

    <div class="main-wrapper">

        {{-- ===== TOP BAR ===== --}}
        <header class="topbar" style="position:relative;">
            
            {{-- Gauche: Navigation rapide --}}
            <div style="display:flex; align-items:center; gap:0.5rem;">
                <button onclick="if(window.history.length > 1) { window.history.back(); } else { window.location.href='{{ route('admin.dashboard') }}'; }" class="topbar-icon-btn" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; width:36px; height:36px; flex-shrink:0;" title="Retour">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;stroke:#64748b;" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="topbar-icon-btn" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; width:36px; height:36px; flex-shrink:0;" title="Accueil">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;stroke:#64748b;" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                </a>
            </div>

            {{-- Droite: Notifications et Profil --}}
            <div class="topbar-right" style="margin-left:auto;">
                
                {{-- Notifications --}}
                <div style="position:relative;" id="notifications-wrapper">
                    <button id="notifications-btn" onclick="toggleNotificationsMenu()" class="topbar-icon-btn" title="Notifications" style="position:relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;stroke:#475569;" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                        @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                        <span id="notification-badge" style="position:absolute; top:8px; right:8px; width:8px; height:8px; background:#ef4444; border-radius:50%; box-shadow:0 0 0 2px #fff;"></span>
                        @else
                        <span id="notification-badge" style="position:absolute; top:8px; right:8px; width:8px; height:8px; background:#ef4444; border-radius:50%; box-shadow:0 0 0 2px #fff; display:none;"></span>
                        @endif
                    </button>
                    
                    {{-- Dropdown notifications --}}
                    <div id="notifications-menu" style="display:none; position:absolute; top:calc(100% + 14px); right:-10px; width:340px; background:#ffffff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 10px 40px -10px rgba(0,0,0,0.1); overflow:hidden; z-index:100;">
                        @if(auth()->check())
                        <div style="padding:1.25rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; background:#f8fafc;">
                            <span style="font-size:0.9rem; font-weight:700; color:#0f172a;">Notifications</span>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                            <span style="font-size:0.7rem; font-weight:600; color:#4f46e5; background:#e0e7ff; padding:0.2rem 0.6rem; border-radius:12px;">{{ auth()->user()->unreadNotifications->count() }} nouvelles</span>
                            @endif
                        </div>
                        <div id="notification-list" style="max-height:320px; overflow-y:auto; padding:0.5rem;">
                            @forelse(auth()->user()->notifications()->take(10)->get() as $notification)
                            <a href="{{ route('admin.notifications.read', $notification->id) }}" style="display:flex; gap:12px; padding:0.75rem; border-radius:10px; text-decoration:none; {{ $notification->unread() ? 'background:#f8fafc;' : '' }}" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='{{ $notification->unread() ? '#f8fafc' : 'transparent' }}'">
                                <div style="height:36px; width:36px; border-radius:50%; background:#dbeafe; color:#1d4ed8; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    <svg style="width:18px;height:18px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                                </div>
                                <div>
                                    <div style="font-size:0.8rem; font-weight:600; color:#0f172a;">{{ $notification->data['message'] ?? 'Nouveau dossier' }} {{ $notification->data['reference'] ?? '' }}</div>
                                    <div style="font-size:0.7rem; color:#64748b; margin-top:2px;">Il y a {{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                            @empty
                            <div style="padding:1rem; text-align:center; color:#94a3b8; font-size:0.8rem;">Aucune notification</div>
                            @endforelse
                        </div>
                        @endif
                        <div style="padding:0.75rem; border-top:1px solid #e2e8f0; text-align:center; background:#f8fafc;">
                            <a href="#" style="font-size:0.75rem; color:#4f46e5; text-decoration:none; font-weight:600;">Voir toutes les notifications</a>
                        </div>
                    </div>
                </div>

                {{-- Profil --}}
                @if(Auth::check())
                <div style="position:relative;" id="profile-wrapper">
                    <button id="profile-btn" onclick="toggleProfileMenu()" style="display:flex; align-items:center; gap:10px; background:none; border:none; cursor:pointer; padding:0;">
                        <div style="height:36px; width:36px; border-radius:8px; background:#e0e7ff; border:1px solid #c7d2fe; display:flex; align-items:center; justify-content:center; color:#4f46e5; font-weight:600; font-size:0.8rem;">
                            {{ strtoupper(substr(Auth::user()->name ?? Auth::user()->email, 0, 2)) }}
                        </div>
                        <div style="text-align:left;">
                            <div style="font-size:0.8rem; font-weight:600; color:#0f172a;">
                                {{ Auth::user()->name ?? 'Utilisateur' }}
                            </div>
                            <div style="font-size:0.7rem; color:#64748b; display:flex; align-items:center; gap:4px;">
                                Accès restreint
                                <svg id="profile-chevron" xmlns="http://www.w3.org/2000/svg" style="width:12px;height:12px;stroke:#94a3b8;transition:transform 0.2s;" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>
                    </button>

                    {{-- Dropdown menu --}}
                    <div id="profile-menu" style="display:none; position:absolute; top:calc(100% + 14px); right:0; width:240px; background:#ffffff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 10px 40px -10px rgba(0,0,0,0.1); overflow:hidden; z-index:100;">
                        <div style="padding:1.25rem; border-bottom:1px solid #f1f5f9; background:#f8fafc;">
                            <div style="font-size:0.85rem; font-weight:700; color:#0f172a;">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div style="font-size:0.75rem; color:#64748b; margin-top:2px;">{{ Auth::user()->email }}</div>
                        </div>
                        <div style="padding:0.5rem;">
                            <a href="{{ route('admin.profile') }}" style="display:flex; align-items:center; gap:10px; padding:0.6rem 0.75rem; font-size:0.8rem; font-weight:500; color:#334155; text-decoration:none; border-radius:8px;"
                               onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a'" onmouseout="this.style.background='transparent'; this.style.color='#334155'">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                Mon Profil
                            </a>
                            <a href="{{ route('admin.settings') }}" style="display:flex; align-items:center; gap:10px; padding:0.6rem 0.75rem; font-size:0.8rem; font-weight:500; color:#334155; text-decoration:none; border-radius:8px;"
                               onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a'" onmouseout="this.style.background='transparent'; this.style.color='#334155'">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Paramètres
                            </a>
                        </div>
                        <div style="padding:0.5rem; border-top:1px solid #f1f5f9;">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" style="width:100%; display:flex; align-items:center; gap:10px; padding:0.6rem 0.75rem; font-size:0.8rem; font-weight:500; color:#ef4444; background:none; border:none; cursor:pointer; text-align:left; border-radius:8px;"
                                    onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </header>

        {{-- ===== NAVBAR HORIZONTALE ===== --}}
        <nav class="main-nav">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                </svg>
                Dashboard
            </a>



            <a href="{{ route('admin.dossiers.index') }}"
               class="nav-link {{ request()->routeIs('admin.dossiers.index') || request()->routeIs('admin.dossiers.show') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                Suivi des dossiers
            </a>

            <a href="{{ route('admin.clients.index') }}"
               class="nav-link {{ request()->routeIs('admin.clients.index') || request()->routeIs('admin.clients.show') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Utilisateurs
            </a>

            <a href="{{ route('admin.statistics') }}"
               class="nav-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                </svg>
                Statistiques
            </a>

            <div class="nav-dropdown">
                <a href="#"
                   class="nav-link {{ request()->routeIs('admin.dossiers.archives') || request()->routeIs('admin.clients.archives') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H2.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Archives
                    <svg style="width:12px;height:12px;margin-left:4px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                </a>
                <div class="nav-dropdown-content">
                    <a href="{{ route('admin.dossiers.archives') }}" class="{{ request()->routeIs('admin.dossiers.archives') ? 'active' : '' }}">Dossiers</a>
                    <a href="{{ route('admin.clients.archives') }}" class="{{ request()->routeIs('admin.clients.archives') ? 'active' : '' }}">Utilisateurs</a>
                </div>
            </div>
        </nav>

        {{-- Flash messages --}}
        @if (session('status') || session('success'))
        <div class="flash-success fade-in">
            <svg style="width:16px;height:16px;flex-shrink:0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#22c55e">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
            </svg>
            <span style="font-size:0.85rem; color:#15803d; font-weight:500;">{{ session('status') ?? session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div class="flash-error fade-in">
            <svg style="width:16px;height:16px;flex-shrink:0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#ef4444">
                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
            </svg>
            <span style="font-size:0.85rem; color:#b91c1c; font-weight:500;">{{ session('error') }}</span>
        </div>
        @endif

        {{-- Page content --}}
        <main class="page-content fade-in">
            @yield('content')
        </main>
    </div>

    @endif

    {!! '<script>
        function toggleProfileMenu() {
            var menu    = document.getElementById("profile-menu");
            var chevron = document.getElementById("profile-chevron");
            var isOpen  = menu.style.display === "block";
            
            var notifMenu = document.getElementById("notifications-menu");
            if (notifMenu) notifMenu.style.display = "none";

            menu.style.display    = isOpen ? "none" : "block";
            if (chevron) chevron.style.transform = isOpen ? "rotate(180deg)" : "rotate(0deg)";
        }

        function toggleNotificationsMenu() {
            var menu   = document.getElementById("notifications-menu");
            var isOpen = menu.style.display === "block";
            
            var profileMenu = document.getElementById("profile-menu");
            var chevron = document.getElementById("profile-chevron");
            if (profileMenu) {
                profileMenu.style.display = "none";
                if (chevron) chevron.style.transform = "rotate(0deg)";
            }

            menu.style.display = isOpen ? "none" : "block";
        }

        /* Fermer en cliquant en dehors */
        document.addEventListener("click", function(e) {
            var wrapper = document.getElementById("profile-wrapper");
            var menu    = document.getElementById("profile-menu");
            var chevron = document.getElementById("profile-chevron");
            if (wrapper && !wrapper.contains(e.target)) {
                if (menu) menu.style.display = "none";
                if (chevron) chevron.style.transform = "rotate(0deg)";
            }

            var notifWrapper = document.getElementById("notifications-wrapper");
            var notifMenu    = document.getElementById("notifications-menu");
            if (notifWrapper && !notifWrapper.contains(e.target)) {
                if (notifMenu) notifMenu.style.display = "none";
            }
        });

        /* Fermer avec Escape */
        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                var menu    = document.getElementById("profile-menu");
                var chevron = document.getElementById("profile-chevron");
                if (menu) { menu.style.display = "none"; if (chevron) chevron.style.transform = "rotate(0deg)"; }

                var notifMenu = document.getElementById("notifications-menu");
                if (notifMenu) { notifMenu.style.display = "none"; }
            }
        });

        /* Initialize TomSelect globally */
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("select").forEach((el) => {
                new TomSelect(el, {
                    create: false,
                    sortField: { field: "text", direction: "asc" }
                });
            });
        });
    </script>' !!}

</body>
</html>
