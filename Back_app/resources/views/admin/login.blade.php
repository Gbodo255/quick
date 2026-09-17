<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Admin QuickCredit</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {!! '<style>
        * { font-family: "Nunito", sans-serif !important; box-sizing: border-box; margin:0; padding:0; }

        /* Input — avec arrondi */
        .form-input {
            display: block;
            width: 100%;
            border-radius: 8px;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            padding: 0.7rem 0.9rem;
            font-size: 0.875rem;
            font-weight: 400;
            color: #111827;
            transition: border-color 0.2s;
            outline: none;
        }
        .form-input::placeholder { color: #9ca3af; font-size:0.85rem; }
        .form-input:focus { border-color: #6c63ff; background:#ffffff; }

        /* Bouton — sans hover */
        .btn-login {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #ffffff;
            border: none;
            cursor: pointer;
            background: linear-gradient(135deg, #7c73f0, #6c63ff);
            box-shadow: 0 4px 14px rgba(108, 99, 255, 0.3);
            letter-spacing: 0.01em;
            transition: opacity 0.2s;
        }
        .btn-login:disabled {
            opacity: 0.75;
            cursor: not-allowed;
        }

        /* Spinner */
        .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.35);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            flex-shrink: 0;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Animation */
        .fade-in { animation: fadeInUp 0.45s ease both; }
        .slide-in { animation: slideInLeft 0.5s ease both; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel  { display: none !important; }
            .right-panel { width: 100% !important; }
        }
    </style>' !!}
</head>

<body style="margin:0; padding:0; min-height:100vh; display:flex; align-items:stretch; font-family:'Nunito',sans-serif; background:#f5f5f5;">

    {{-- Carte plein écran divisée en 2 --}}
    <div style="width:100%; display:flex; flex-direction:row; min-height:100vh;">

        {{-- ======= GAUCHE : Fond aurora gradient ======= --}}
        <div class="left-panel slide-in" style="
            width: 50%;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            background-color: #2b20a0;
            background-image:
                radial-gradient(ellipse at 15% 20%,  rgba(99,102,241,0.95) 0%,  transparent 55%),
                radial-gradient(ellipse at 80% 10%,  rgba(167,139,250,0.75) 0%, transparent 45%),
                radial-gradient(ellipse at 90% 70%,  rgba(224,231,255,0.90) 0%, transparent 50%),
                radial-gradient(ellipse at 10% 80%,  rgba(55,48,163,0.95)  0%,  transparent 50%),
                radial-gradient(ellipse at 50% 50%,  rgba(109,40,217,0.60)  0%, transparent 60%);
        ">
            {{-- Grain/noise overlay pour texture subtile --}}
            <div style="
                position: absolute; inset: 0;
                background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22 opacity=%220.04%22/%3E%3C/svg%3E');
                opacity: 0.5;
                pointer-events: none;
            "></div>

            {{-- Logo plateforme --}}
            <div class="slide-in" style="position:relative; z-index:1; display:flex; flex-direction:column; justify-content:space-between; height:100%; padding:3rem;">
                <img src="{{ asset('images/brand/logo-full-white.svg') }}" alt="StudCredit" style="height:30px; width:auto; display:block;">
                <p style="color:rgba(255,255,255,0.75); font-size:0.9rem; line-height:1.6; max-width:340px; font-family:'Nunito',sans-serif;">
                    Espace d'administration — pilotez les dossiers, les clients et les indicateurs de la plateforme StudCredit.
                </p>
            </div>

        </div>


        {{-- ======= DROITE : Formulaire centré ======= --}}
        <div class="right-panel fade-in" style="width:50%; background:#ffffff; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:3rem; flex-shrink:0;">

            {{-- Contenu centré --}}
            <div style="width:100%; max-width:360px;">

                {{-- Logo --}}
                <div style="display:flex; justify-content:center; margin-bottom:1.75rem;">
                    <img src="{{ asset('images/brand/logo-full-dark.svg') }}" alt="StudCredit" style="height:26px; width:auto; display:block;">
                </div>

                {{-- Titre --}}
                <h1 style="font-size:1.6rem; font-weight:600; color:#0f172a; margin:0 0 1.75rem 0; text-align:center; letter-spacing:-0.01em;">
                    Connexion
                </h1>



                {{-- Erreurs serveur (identifiants incorrects) --}}
                @if ($errors->any())
                <div style="display:flex; align-items:flex-start; gap:10px; background:#fef2f2; border-left:3px solid #ef4444; padding:0.75rem 1rem; margin-bottom:1.25rem;">
                    <svg style="height:15px;width:15px;flex-shrink:0;margin-top:2px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#ef4444">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
                    </svg>
                    <p style="font-size:0.85rem; color:#b91c1c; margin:0;">{{ $errors->first() }}</p>
                </div>
                @endif

                {{-- Formulaire --}}
                <form id="login-form" method="POST" action="{{ route('admin.login.submit') }}" novalidate>
                    @csrf

                    {{-- Champ nom d'utilisateur --}}
                    <div style="margin-bottom:1rem;">
                        <label for="username" style="display:block; font-size:0.75rem; font-weight:500; color:#374151; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:0.4rem;">
                            Nom d'utilisateur
                        </label>
                        <input
                            id="username"
                            name="username"
                            type="text"
                            value="{{ old('username') }}"
                            autofocus
                            class="form-input"
                        />
                        <p id="username-error" style="display:none; font-size:0.75rem; color:#dc2626; margin-top:0.3rem;">Ce champ est requis.</p>
                    </div>

                    {{-- Champ mot de passe --}}
                    <div style="margin-bottom:1rem;">
                        <label for="password" style="display:block; font-size:0.75rem; font-weight:500; color:#374151; text-transform:uppercase; letter-spacing:0.06em; margin-bottom:0.4rem;">
                            Mot de passe
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-input"
                        />
                        <p id="password-error" style="display:none; font-size:0.75rem; color:#dc2626; margin-top:0.3rem;">Ce champ est requis.</p>
                    </div>

                    {{-- Se souvenir de moi + Mot de passe oublié --}}
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                style="width:15px; height:15px; accent-color:#6c63ff; cursor:pointer; flex-shrink:0;"
                            />
                            <label for="remember" style="font-size:0.8rem; font-weight:400; color:#6b7280; cursor:pointer; user-select:none;">
                                Se souvenir de moi
                            </label>
                        </div>
                        <button type="button" id="forgot-password-btn" style="background:none; border:none; padding:0; font-size:0.8rem; font-weight:500; color:#6c63ff; cursor:pointer; font-family:'Nunito',sans-serif;">
                            Mot de passe oublié ?
                        </button>
                    </div>

                    {{-- Bouton --}}
                    <button type="submit" id="submit-btn" class="btn-login">
                        <span id="btn-spinner" class="spinner"></span>
                        <span id="btn-text">Se connecter</span>
                        <svg id="btn-arrow" xmlns="http://www.w3.org/2000/svg" style="height:15px;width:15px;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </form>

            </div>
        </div>

    </div>

    {{-- ======= MODAL Mot de passe oublié ======= --}}
    <div id="forgot-modal" style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center;">

        {{-- Overlay --}}
        <div id="modal-overlay" style="position:absolute; inset:0; background:rgba(15,23,42,0.45); backdrop-filter:blur(4px);"></div>

        {{-- Carte modale --}}
        <div style="position:relative; z-index:1; background:#ffffff; border-radius:16px; padding:2rem 2rem 1.75rem; max-width:420px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.18); animation:fadeInUp 0.25s ease both;">

            {{-- Icône --}}
            <div style="display:flex; justify-content:center; margin-bottom:1.25rem;">
                <div style="height:52px; width:52px; border-radius:50%; background:#ede9fe; display:flex; align-items:center; justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="height:26px;width:26px;" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#7c3aed">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
            </div>

            {{-- Titre --}}
            <h2 style="font-size:1.1rem; font-weight:700; color:#0f172a; text-align:center; margin:0 0 0.75rem 0; font-family:'Nunito',sans-serif;">
                Mot de passe oublié ?
            </h2>

            {{-- Message --}}
            <p style="font-size:0.875rem; color:#475569; text-align:center; line-height:1.7; margin:0 0 1.5rem 0; font-family:'Nunito',sans-serif;">
                Pour réinitialiser votre mot de passe, veuillez vous adresser directement à
                <strong style="color:#0f172a;">l'équipe technique</strong>
                chargée de la gestion de la plateforme.
            </p>

            {{-- Bouton fermer --}}
            <button id="modal-close-btn" style="width:100%; padding:0.75rem; border-radius:8px; background:#f1f5f9; border:none; font-size:0.875rem; font-weight:600; color:#475569; cursor:pointer; font-family:'Nunito',sans-serif;">
                Compris
            </button>
        </div>
    </div>

    {!! '<script>
        (function () {
            var form          = document.getElementById("login-form");
            var usernameInput = document.getElementById("username");
            var passwordInput = document.getElementById("password");
            var usernameError = document.getElementById("username-error");
            var passwordError = document.getElementById("password-error");

            /* --- Validation --- */
            function setError(input, errorEl, show) {
                if (show) {
                    input.style.borderColor = "#ef4444";
                    input.style.background  = "#fff5f5";
                    errorEl.style.display   = "block";
                } else {
                    input.style.borderColor = "#e5e7eb";
                    input.style.background  = "#f9fafb";
                    errorEl.style.display   = "none";
                }
            }
            usernameInput.addEventListener("input", function () { setError(usernameInput, usernameError, false); });
            passwordInput.addEventListener("input", function () { setError(passwordInput, passwordError, false); });
            form.addEventListener("submit", function (e) {
                var valid = true;
                if (!usernameInput.value.trim()) { setError(usernameInput, usernameError, true);  valid = false; }
                if (!passwordInput.value.trim()) { setError(passwordInput, passwordError, true);  valid = false; }
                if (!valid) { e.preventDefault(); return; }

                /* --- Spinner --- */
                var btn     = document.getElementById("submit-btn");
                var spinner = document.getElementById("btn-spinner");
                var btnText = document.getElementById("btn-text");
                var arrow   = document.getElementById("btn-arrow");
                btn.disabled          = true;
                spinner.style.display = "block";
                btnText.textContent   = "Connexion en cours...";
                arrow.style.display   = "none";
            });

            /* --- Modal mot de passe oublié --- */
            var modal      = document.getElementById("forgot-modal");
            var overlay    = document.getElementById("modal-overlay");
            var openBtn    = document.getElementById("forgot-password-btn");
            var closeBtn   = document.getElementById("modal-close-btn");

            function openModal()  { modal.style.display = "flex"; document.body.style.overflow = "hidden"; }
            function closeModal() { modal.style.display = "none";  document.body.style.overflow = ""; }

            openBtn.addEventListener("click", openModal);
            closeBtn.addEventListener("click", closeModal);
            overlay.addEventListener("click", closeModal);

            /* Fermer avec Escape */
            document.addEventListener("keydown", function(e) {
                if (e.key === "Escape") closeModal();
            });
        })();
    </script>' !!}

</body>
</html>
