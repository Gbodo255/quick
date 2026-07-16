@extends('admin.layout')
@section('title', 'Paramètres — QuickCredit')

@section('content')

{!! '<style>
    .settings-section {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .settings-section-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .settings-section-title {
        display: flex; align-items: center; gap: 10px;
    }
    .settings-section-title h2 {
        font-size: 0.9rem; font-weight: 700; color: #0f172a; margin: 0;
    }
    .icon-badge {
        height: 32px; width: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .form-input {
        padding: 0.55rem 0.875rem;
        font-size: 0.82rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        color: #0f172a;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        font-family: "Inter", sans-serif !important;
        width: 100%;
    }
    .form-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); background: #fff; }
    .form-select {
        padding: 0.55rem 0.875rem;
        font-size: 0.82rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background: #f8fafc;
        color: #0f172a;
        outline: none;
        font-family: "Inter", sans-serif !important;
        width: 100%;
        cursor: pointer;
    }
    .form-label { font-size: 0.78rem; font-weight: 600; color: #475569; margin-bottom: 5px; display: block; }
    .input-error { font-size: 0.72rem; color: #ef4444; margin-top: 3px; }
    .btn-primary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 0.5rem 1rem;
        background: #4f46e5; color: #fff;
        border: none; border-radius: 8px;
        font-size: 0.8rem; font-weight: 600; cursor: pointer;
        font-family: "Inter", sans-serif !important;
        transition: background 0.15s; white-space: nowrap;
    }
    .btn-primary:hover { background: #4338ca; }
    .btn-danger {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 0.4rem 0.75rem;
        background: #fef2f2; color: #ef4444;
        border: 1px solid #fecaca; border-radius: 7px;
        font-size: 0.75rem; font-weight: 600; cursor: pointer;
        font-family: "Inter", sans-serif !important;
        transition: all 0.15s; white-space: nowrap;
    }
    .btn-danger:hover { background: #ef4444; color: #fff; border-color: #ef4444; }
    .btn-ghost {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 0.4rem 0.75rem;
        background: #f8fafc; color: #475569;
        border: 1px solid #e2e8f0; border-radius: 7px;
        font-size: 0.75rem; font-weight: 600; cursor: pointer;
        font-family: "Inter", sans-serif !important;
        transition: all 0.15s; white-space: nowrap;
    }
    .btn-ghost:hover { background: #f1f5f9; color: #0f172a; }
    .alert-success {
        display: flex; align-items: center; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: 10px; padding: 0.75rem 1rem; margin-bottom: 1.25rem;
        font-size: 0.82rem; color: #166534; font-weight: 500;
    }
    .alert-error {
        display: flex; align-items: center; gap: 10px;
        background: #fef2f2; border: 1px solid #fecaca;
        border-radius: 10px; padding: 0.75rem 1rem; margin-bottom: 1.25rem;
        font-size: 0.82rem; color: #b91c1c; font-weight: 500;
    }
    /* Modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(15,23,42,0.4); backdrop-filter: blur(2px);
        z-index: 200; align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        background: #fff; border-radius: 16px;
        width: 100%; max-width: 480px;
        padding: 2rem; box-shadow: 0 25px 50px rgba(0,0,0,0.12);
        animation: slideUp 0.2s ease;
    }
    @keyframes slideUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .modal-title { font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0 0 1.25rem; }
    .modal-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .modal-grid .full { grid-column: 1 / -1; }
    .modal-actions { display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; }
    .user-row { border-bottom: 1px solid #f8fafc; }
    .user-row:last-child { border-bottom: none; }
    .user-row:hover { background: #fafbfc; }
    .role-badge {
        font-size: 0.7rem; font-weight: 600; padding: 0.2rem 0.55rem;
        border-radius: 6px; border: 1px solid;
    }
</style>' !!}

{{-- Flash --}}
@if(session('success'))
<div class="alert-success">
    <svg style="width:16px;height:16px;flex-shrink:0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert-error">
    <svg style="width:16px;height:16px;flex-shrink:0;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd"/></svg>
    {{ session('error') }}
</div>
@endif

{{-- ===== SECTION UTILISATEURS ===== --}}
<div class="settings-section">
    <div class="settings-section-header">
        <div class="settings-section-title">
            <div class="icon-badge" style="background:#e0e7ff;">
                <svg style="width:16px;height:16px;stroke:#4f46e5;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
            <div>
                <h2>Gestion des utilisateurs</h2>
                <div style="font-size:0.75rem; color:#94a3b8;">{{ $users->count() }} utilisateur(s) au total</div>
            </div>
        </div>
        <button onclick="document.getElementById('modal-create').classList.add('open')" class="btn-primary">
            <svg style="width:14px;height:14px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Nouvel utilisateur
        </button>
    </div>

    {{-- Table utilisateurs --}}
    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1px solid #f1f5f9;">
                    <th style="padding:0.75rem 1.25rem; text-align:left; font-size:0.7rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.06em;">Utilisateur</th>
                    <th style="padding:0.75rem 1.25rem; text-align:left; font-size:0.7rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.06em;">Rôle</th>
                    <th style="padding:0.75rem 1.25rem; text-align:left; font-size:0.7rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.06em;">Créé le</th>
                    <th style="padding:0.75rem 1.25rem; text-align:right; font-size:0.7rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:0.06em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr class="user-row" id="row-{{ $u->id }}">
                    <td style="padding:0.875rem 1.25rem;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="height:34px;width:34px;border-radius:8px;background:#e0e7ff;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;color:#4f46e5;flex-shrink:0;">
                                {{ strtoupper(substr($u->name ?? $u->email, 0, 2)) }}
                            </div>
                            <div>
                                <div style="font-size:0.825rem;font-weight:600;color:#0f172a;">{{ $u->name ?: '—' }}</div>
                                <div style="font-size:0.73rem;color:#94a3b8;">{{ $u->email }}</div>
                            </div>
                            @if($u->id === Auth::id())
                            <span style="font-size:0.68rem;font-weight:600;background:#f0fdf4;color:#166534;padding:0.15rem 0.45rem;border-radius:6px;">Vous</span>
                            @endif
                        </div>
                    </td>
                    <td style="padding:0.875rem 1.25rem;">
                        <span class="role-badge {{ $u->isAdmin() ? 'background:#e0e7ff; color:#4338ca; border-color:#c7d2fe;' : '' }}" style="{{ $u->isAdmin() ? 'background:#e0e7ff; color:#4338ca; border-color:#c7d2fe;' : 'background:#f0fdf4; color:#166534; border-color:#bbf7d0;' }}">
                            {{ $u->isAdmin() ? 'Administrateur' : 'Employé' }}
                        </span>
                    </td>
                    <td style="padding:0.875rem 1.25rem;">
                        <span style="font-size:0.8rem;color:#475569;">{{ $u->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td style="padding:0.875rem 1.25rem; text-align:right;">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5rem;">
                            <button onclick="openEditModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->email }}', '{{ $u->role }}')" class="btn-ghost">
                                <svg style="width:13px;height:13px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" /></svg>
                                Modifier
                            </button>
                            <button onclick="openPwdModal({{ $u->id }}, '{{ addslashes($u->name) }}')" class="btn-ghost">
                                <svg style="width:13px;height:13px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" /></svg>
                                Mot de passe
                            </button>
                            @if($u->id !== Auth::id())
                            <form method="POST" action="{{ route('admin.settings.users.delete', $u) }}" onsubmit="return confirm('Supprimer « {{ $u->name }} » ? Cette action est irréversible.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger">
                                    <svg style="width:13px;height:13px;stroke:currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                    Supprimer
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ===== SECTION SÉCURITÉ SYSTÈME ===== --}}
<div class="settings-section">
    <div class="settings-section-header">
        <div class="settings-section-title">
            <div class="icon-badge" style="background:#fef3c7;">
                <svg style="width:16px;height:16px;stroke:#d97706;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                </svg>
            </div>
            <div>
                <h2>Sécurité du système</h2>
                <div style="font-size:0.75rem; color:#94a3b8;">Paramètres de sécurité et d'accès</div>
            </div>
        </div>
    </div>
    <div style="padding:1.5rem; display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">
        <div style="padding:1.25rem; border:1px solid #f1f5f9; border-radius:10px; background:#f8fafc;">
            <div style="font-size:0.78rem; font-weight:600; color:#475569; margin-bottom:8px;">Durée de session</div>
            <div style="font-size:1rem; font-weight:700; color:#0f172a;">{{ config('session.lifetime', 120) }} minutes</div>
            <div style="font-size:0.72rem; color:#94a3b8; margin-top:4px;">Défini dans config/session.php</div>
        </div>
        <div style="padding:1.25rem; border:1px solid #f1f5f9; border-radius:10px; background:#f8fafc;">
            <div style="font-size:0.78rem; font-weight:600; color:#475569; margin-bottom:8px;">Tentatives de connexion</div>
            <div style="font-size:1rem; font-weight:700; color:#0f172a;">5 / minute</div>
            <div style="font-size:0.72rem; color:#94a3b8; margin-top:4px;">Rate limiting activé sur /admin/login</div>
        </div>
        <div style="padding:1.25rem; border:1px solid #f1f5f9; border-radius:10px; background:#f8fafc;">
            <div style="font-size:0.78rem; font-weight:600; color:#475569; margin-bottom:8px;">Protection CSRF</div>
            <div style="margin-top:6px;"><span style="font-size:0.8rem; font-weight:600; background:#f0fdf4; color:#166534; padding:0.2rem 0.6rem; border-radius:8px; border:1px solid #bbf7d0;">Active</span></div>
        </div>
        <div style="padding:1.25rem; border:1px solid #f1f5f9; border-radius:10px; background:#f8fafc;">
            <div style="font-size:0.78rem; font-weight:600; color:#475569; margin-bottom:8px;">Environnement</div>
            <div style="font-size:1rem; font-weight:700; color:#0f172a;">{{ ucfirst(config('app.env', 'production')) }}</div>
            <div style="font-size:0.72rem; color:#94a3b8; margin-top:4px;">{{ config('app.debug') ? 'Mode debug activé' : 'Mode debug désactivé' }}</div>
        </div>
    </div>
</div>

{{-- ===== SECTION APPARENCE ===== --}}
<div class="settings-section">
    <div class="settings-section-header">
        <div class="settings-section-title">
            <div class="icon-badge" style="background:#f3e8ff;">
                <svg style="width:16px;height:16px;stroke:#9333ea;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                </svg>
            </div>
            <div>
                <h2>Apparence</h2>
                <div style="font-size:0.75rem; color:#94a3b8;">Personnalisation de l'interface</div>
            </div>
        </div>
    </div>
    <div style="padding:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; padding:1rem; border:1px solid #f1f5f9; border-radius:10px; background:#f8fafc;">
            <div>
                <div style="font-size:0.825rem; font-weight:600; color:#0f172a;">Thème</div>
                <div style="font-size:0.75rem; color:#94a3b8; margin-top:2px;">Mode clair activé — le mode sombre sera disponible prochainement.</div>
            </div>
            <span style="font-size:0.75rem; font-weight:600; background:#f1f5f9; color:#64748b; padding:0.3rem 0.75rem; border-radius:8px; border:1px solid #e2e8f0;">Bientôt disponible</span>
        </div>
        <div style="display:flex; align-items:center; justify-content:space-between; padding:1rem; border:1px solid #f1f5f9; border-radius:10px; background:#f8fafc; margin-top:0.75rem;">
            <div>
                <div style="font-size:0.825rem; font-weight:600; color:#0f172a;">Langue de l'interface</div>
                <div style="font-size:0.75rem; color:#94a3b8; margin-top:2px;">Langue actuelle : Français</div>
            </div>
            <span style="font-size:0.75rem; font-weight:600; background:#f1f5f9; color:#64748b; padding:0.3rem 0.75rem; border-radius:8px; border:1px solid #e2e8f0;">Bientôt disponible</span>
        </div>
    </div>
</div>


{{-- ===== MODAL CRÉER UTILISATEUR ===== --}}
<div class="modal-overlay" id="modal-create" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal-box">
        <h3 class="modal-title">Créer un nouvel utilisateur</h3>
        <form method="POST" action="{{ route('admin.settings.users.create') }}">
            @csrf
            <div class="modal-grid">
                <div class="full">
                    <label class="form-label">Nom complet</label>
                    <input class="form-input" type="text" name="name" value="{{ old('name') }}" placeholder="Jean Dupont" required>
                    @error('name') <span class="input-error">{{ $message }}</span> @enderror
                </div>
                <div class="full">
                    <label class="form-label">Adresse email</label>
                    <input class="form-input" type="email" name="email" value="{{ old('email') }}" placeholder="jean@quickcredit.fr" required>
                    @error('email') <span class="input-error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Rôle / Accès</label>
                    <select class="form-select" name="role" required>
                        <option value="employee" {{ old('role') === 'employee' ? 'selected' : '' }}>Employé</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    @error('role') <span class="input-error">{{ $message }}</span> @enderror
                </div>
                <div></div>
                <div>
                    <label class="form-label">Mot de passe</label>
                    <input class="form-input" type="password" name="password" placeholder="Min. 8 caractères" required>
                    @error('password') <span class="input-error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Confirmer le mot de passe</label>
                    <input class="form-input" type="password" name="password_confirmation" placeholder="Répéter" required>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" onclick="document.getElementById('modal-create').classList.remove('open')" class="btn-ghost">Annuler</button>
                <button type="submit" class="btn-primary">Créer l'utilisateur</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL MODIFIER UTILISATEUR ===== --}}
<div class="modal-overlay" id="modal-edit" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal-box">
        <h3 class="modal-title" id="edit-modal-title">Modifier l'utilisateur</h3>
        <form method="POST" id="edit-form" action="">
            @csrf @method('PATCH')
            <div class="modal-grid">
                <div class="full">
                    <label class="form-label">Nom complet</label>
                    <input class="form-input" type="text" name="name" id="edit-name" required>
                </div>
                <div class="full">
                    <label class="form-label">Adresse email</label>
                    <input class="form-input" type="email" name="email" id="edit-email" required>
                </div>
                <div>
                    <label class="form-label">Rôle / Accès</label>
                    <select class="form-select" name="role" id="edit-role">
                        <option value="employee">Employé</option>
                        <option value="admin">Administrateur</option>
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" onclick="document.getElementById('modal-edit').classList.remove('open')" class="btn-ghost">Annuler</button>
                <button type="submit" class="btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL CHANGER MDP ===== --}}
<div class="modal-overlay" id="modal-pwd" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal-box">
        <h3 class="modal-title" id="pwd-modal-title">Changer le mot de passe</h3>
        <form method="POST" id="pwd-form" action="">
            @csrf
            <div style="margin-bottom:1rem;">
                <label class="form-label">Nouveau mot de passe</label>
                <input class="form-input" type="password" name="new_password" placeholder="Min. 8 caractères" required>
                @error('new_password') <span class="input-error">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="form-label">Confirmer le nouveau mot de passe</label>
                <input class="form-input" type="password" name="new_password_confirmation" placeholder="Répéter" required>
            </div>
            <div class="modal-actions">
                <button type="button" onclick="document.getElementById('modal-pwd').classList.remove('open')" class="btn-ghost">Annuler</button>
                <button type="submit" class="btn-primary">Modifier le mot de passe</button>
            </div>
        </form>
    </div>
</div>

{!! '<script>
function openEditModal(id, name, email, role) {
    document.getElementById("edit-modal-title").textContent = "Modifier : " + name;
    document.getElementById("edit-form").action = "/admin/settings/users/" + id;
    document.getElementById("edit-name").value = name;
    document.getElementById("edit-email").value = email;
    document.getElementById("edit-role").value = role;
    document.getElementById("modal-edit").classList.add("open");
}

function openPwdModal(id, name) {
    document.getElementById("pwd-modal-title").textContent = "Mot de passe de : " + name;
    document.getElementById("pwd-form").action = "/admin/settings/users/" + id + "/password";
    document.getElementById("modal-pwd").classList.add("open");
}

document.addEventListener("keydown", function(e) {
    if (e.key === "Escape") {
        document.querySelectorAll(".modal-overlay").forEach(m => m.classList.remove("open"));
    }
});

// Rouvrir les modals si erreur de validation
@if($errors->any())
    // Si l erreur vient du formulaire de création
    @if(old("name") || old("email"))
        document.getElementById("modal-create").classList.add("open");
    @endif
@endif
</script>' !!}

@endsection
