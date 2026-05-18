<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrarse &mdash; Tejidos Caymi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Josefin+Sans:wght@300;400&display=swap" rel="stylesheet">
    <style>
        :root {
            --sand: #f2ece2;
            --sand-mid: #e4dbd0;
            --sand-dark: #cfc5b8;
            --ink: #1c1712;
            --ink-soft: #4a4035;
            --terracotta: #a85c3a;
            --teal: #2e6b68;
            --gold: #b8892a;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: 'Josefin Sans', sans-serif;
            font-weight: 300;
            background-color: var(--sand);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }
        /* Grain texture */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='1' height='1' fill='%23b09a7a' opacity='0.07'/%3E%3Crect x='2' y='2' width='1' height='1' fill='%23b09a7a' opacity='0.07'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0;
        }
        /* Andean side stripe */
        .edge-stripe { position: fixed; left: 0; top: 0; bottom: 0; width: 5px; display: flex; flex-direction: column; z-index: 50; }
        .edge-stripe span { flex: 1; }
        .s1 { background: var(--terracotta); }
        .s2 { background: var(--teal); }
        .s3 { background: var(--gold); }
        .s4 { background: var(--terracotta); }
        .s5 { background: var(--ink); }
        .s6 { background: var(--teal); }
        .s7 { background: var(--gold); }
        .s8 { background: var(--terracotta); }

        /* Header */
        header {
            position: relative; z-index: 10;
            padding: 2rem 3rem 2rem 3.5rem;
            border-bottom: 1px solid var(--sand-dark);
            display: flex; align-items: center; justify-content: space-between;
        }
        .brand-name { font-family: 'EB Garamond', serif; font-size: 1.5rem; font-weight: 400; letter-spacing: 0.04em; color: var(--ink); line-height: 1; text-decoration: none; }
        .brand-name em { font-style: italic; color: var(--terracotta); }
        .brand-origin { font-size: 0.58rem; letter-spacing: 0.28em; text-transform: uppercase; color: var(--ink-soft); margin-top: 0.2rem; }

        /* Main layout */
        .page-body {
            position: relative; z-index: 10;
            display: grid;
            grid-template-columns: 1fr 1fr;
            flex: 1;
        }

        /* Left: decorative panel */
        .deco-panel {
            background-color: var(--sand-mid);
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
            min-height: 500px;
        }
        .pattern-bg { position: absolute; inset: 0; opacity: 0.18;
            background-image: repeating-linear-gradient(0deg,
                transparent 0px, transparent 10px,
                var(--terracotta) 10px, var(--terracotta) 12px,
                transparent 12px, transparent 22px,
                var(--teal) 22px, var(--teal) 24px,
                transparent 24px, transparent 34px,
                var(--gold) 34px, var(--gold) 36px);
        }
        .pattern-bg-cross { position: absolute; inset: 0; opacity: 0.06;
            background-image: repeating-linear-gradient(90deg, var(--ink) 0px, var(--ink) 1px, transparent 1px, transparent 36px);
        }
        .frame-tl { position: absolute; top: 2rem; left: 2rem; width: 40px; height: 40px; border-top: 1px solid var(--terracotta); border-left: 1px solid var(--terracotta); opacity: 0.5; z-index: 3; }
        .frame-br { position: absolute; bottom: 2rem; right: 2rem; width: 40px; height: 40px; border-bottom: 1px solid var(--teal); border-right: 1px solid var(--teal); opacity: 0.5; z-index: 3; }

        .deco-content {
            position: relative; z-index: 2;
            display: flex; flex-direction: column; align-items: center; gap: 2rem;
            animation: fadein 1s ease forwards;
        }
        @keyframes fadein { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

        .deco-svg { width: 160px; filter: drop-shadow(0 4px 24px rgba(168,92,58,0.15)); }

        .deco-label { font-size: 0.58rem; letter-spacing: 0.35em; text-transform: uppercase; color: var(--ink-soft); text-align: center; }

        /* Right: form panel */
        .form-panel {
            padding: 4rem 3.5rem;
            display: flex; flex-direction: column; justify-content: center;
            border-left: 1px solid var(--sand-dark);
        }

        .form-eyebrow {
            font-size: 0.6rem; letter-spacing: 0.3em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.75rem;
        }
        .form-eyebrow::before { content: ''; width: 28px; height: 1px; background: var(--teal); display: block; }

        .form-title {
            font-family: 'EB Garamond', serif;
            font-size: 2.4rem; font-weight: 400; line-height: 1.1;
            color: var(--ink); margin-bottom: 0.4rem;
        }
        .form-title em { font-style: italic; color: var(--terracotta); }

        .form-subtitle {
            font-size: 0.65rem; letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--ink-soft); margin-bottom: 2.5rem;
        }

        /* Session status */
        .session-status {
            font-size: 0.65rem; letter-spacing: 0.08em;
            color: var(--teal); background: rgba(46,107,104,0.08);
            border-left: 2px solid var(--teal);
            padding: 0.6rem 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* Form fields */
        .field { margin-bottom: 1.5rem; }

        label {
            display: block;
            font-size: 0.6rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--ink-soft); margin-bottom: 0.5rem;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--sand-dark);
            padding: 0.6rem 0;
            font-family: 'Josefin Sans', sans-serif;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            color: var(--ink);
            outline: none;
            transition: border-color 0.2s;
            -webkit-appearance: none;
            border-radius: 0;
        }
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus { border-bottom-color: var(--terracotta); }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder,
        input[type="text"]::placeholder { color: var(--sand-dark); }

        /* Password wrapper for viewable toggle */
        .password-wrapper {
            position: relative;
        }
        .password-wrapper input {
            padding-right: 2rem;
        }
        .toggle-password {
            position: absolute;
            right: 0;
            bottom: 0.6rem;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            color: var(--sand-dark);
            transition: color 0.2s;
            line-height: 1;
        }
        .toggle-password:hover { color: var(--ink-soft); }
        .toggle-password svg { width: 14px; height: 14px; display: block; }

        /* Input error */
        .field-error {
            font-size: 0.6rem; letter-spacing: 0.08em;
            color: var(--terracotta); margin-top: 0.4rem;
        }

        /* Two-column grid for password fields */
        .fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 2rem;
        }

        /* Form actions */
        .form-actions {
            margin-top: 0.5rem;
        }

        .btn-submit {
            font-family: 'Josefin Sans', sans-serif;
            font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase;
            font-weight: 400;
            width: 100%;
            padding: 0.85rem 2rem;
            background: var(--ink);
            color: var(--sand);
            border: 1px solid var(--ink);
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .btn-submit:hover { background: var(--terracotta); border-color: var(--terracotta); }

        /* Divider */
        .form-divider {
            display: flex; align-items: center; gap: 0.75rem;
            margin: 1.75rem 0 1.5rem;
        }
        .form-divider::before, .form-divider::after { content: ''; flex: 1; height: 1px; background: var(--sand-dark); }
        .divider-diamond { width: 5px; height: 5px; background: var(--sand-dark); transform: rotate(45deg); flex-shrink: 0; }

        .login-hint {
            font-size: 0.6rem; letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--ink-soft); text-align: center;
        }
        .login-hint a { color: var(--teal); text-decoration: none; border-bottom: 1px solid transparent; transition: border-color 0.2s; }
        .login-hint a:hover { border-bottom-color: var(--teal); }

        /* Footer */
        footer {
            position: relative; z-index: 10;
            border-top: 1px solid var(--sand-dark);
            padding: 1rem 3rem 1rem 3.5rem;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        }
        .footer-text { font-size: 0.58rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--sand-dark); }
        .footer-stripes { display: flex; gap: 3px; align-items: center; }
        .footer-stripes span { display: block; height: 10px; width: 3px; }

        /* Responsive */
        @media (max-width: 700px) {
            .page-body { grid-template-columns: 1fr; }
            .deco-panel { display: none; }
            .form-panel { padding: 3rem 2rem 3rem 2.5rem; border-left: none; }
            header { padding: 1.5rem 2rem 1.5rem 2.5rem; }
            footer { flex-direction: column; text-align: center; padding: 1.25rem 2rem; }
            .fields-grid { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>

    <div class="edge-stripe">
        <span class="s1"></span><span class="s2"></span><span class="s3"></span>
        <span class="s4"></span><span class="s5"></span><span class="s6"></span>
        <span class="s7"></span><span class="s8"></span>
    </div>

    <header>
        <a href="{{ route('home') ?? '/' }}" style="text-decoration:none">
            <div class="brand-name">Tejidos <em>Caymi</em></div>
            <div class="brand-origin">Peguche &middot; Imbabura &middot; Ecuador</div>
        </a>
    </header>

    <div class="page-body">

        <!-- Decorative left panel -->
        <div class="deco-panel">
            <div class="pattern-bg"></div>
            <div class="pattern-bg-cross"></div>
            <div class="frame-tl"></div>
            <div class="frame-br"></div>
            <div class="deco-content">
                <svg class="deco-svg" viewBox="0 0 200 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="g1" x1="0" y1="0" x2="200" y2="220" gradientUnits="userSpaceOnUse">
                            <stop offset="0%"   stop-color="#a85c3a"/>
                            <stop offset="50%"  stop-color="#b8892a"/>
                            <stop offset="100%" stop-color="#2e6b68"/>
                        </linearGradient>
                    </defs>
                    <rect x="60"  y="0"   width="80"  height="16" fill="url(#g1)" opacity="0.9"/>
                    <rect x="40"  y="16"  width="120" height="8"  fill="url(#g1)" opacity="0.6"/>
                    <rect x="20"  y="24"  width="160" height="4"  fill="url(#g1)" opacity="0.35"/>
                    <rect x="76"  y="44"  width="48"  height="48"  fill="#a85c3a" opacity="0.9"/>
                    <rect x="44"  y="76"  width="112" height="48"  fill="#a85c3a" opacity="0.9"/>
                    <rect x="76"  y="108" width="48"  height="48"  fill="#a85c3a" opacity="0.9"/>
                    <rect x="84"  y="84"  width="32"  height="32"  fill="#e4dbd0"/>
                    <rect x="96"  y="96"  width="8"   height="8"   fill="#2e6b68" transform="rotate(45 100 100)"/>
                    <g transform="translate(20,168)" opacity="0.75">
                        <rect x="0"   y="4" width="8" height="8" transform="rotate(45 4 8)"   fill="#a85c3a"/>
                        <rect x="18"  y="4" width="6" height="6" transform="rotate(45 21 7)"  fill="#2e6b68"/>
                        <rect x="34"  y="4" width="8" height="8" transform="rotate(45 38 8)"  fill="#b8892a"/>
                        <rect x="52"  y="4" width="6" height="6" transform="rotate(45 55 7)"  fill="#a85c3a"/>
                        <rect x="68"  y="4" width="8" height="8" transform="rotate(45 72 8)"  fill="#2e6b68"/>
                        <rect x="86"  y="4" width="6" height="6" transform="rotate(45 89 7)"  fill="#b8892a"/>
                        <rect x="102" y="4" width="8" height="8" transform="rotate(45 106 8)" fill="#a85c3a"/>
                        <rect x="120" y="4" width="6" height="6" transform="rotate(45 123 7)" fill="#2e6b68"/>
                        <rect x="136" y="4" width="8" height="8" transform="rotate(45 140 8)" fill="#b8892a"/>
                        <rect x="154" y="4" width="6" height="6" transform="rotate(45 157 7)" fill="#a85c3a"/>
                    </g>
                    <rect x="20"  y="192" width="160" height="4"  fill="url(#g1)" opacity="0.35"/>
                    <rect x="40"  y="196" width="120" height="8"  fill="url(#g1)" opacity="0.6"/>
                    <rect x="60"  y="204" width="80"  height="16" fill="url(#g1)" opacity="0.9"/>
                </svg>
                <div class="deco-label">Arte kichwa &middot; Peguche</div>
            </div>
        </div>

        <!-- Form panel -->
        <div class="form-panel">

            <div class="form-eyebrow">Nueva cuenta</div>
            <h1 class="form-title">Únete a <em>Caymi</em></h1>
            <p class="form-subtitle">Ingresa tus datos para crear tu cuenta</p>

            @if (session('status'))
                <div class="session-status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <!-- Name -->
                <div class="field">
                    <label for="name">Nombre completo</label>
                    <input id="name" type="text" name="name"
                           value="{{ old('name') }}"
                           placeholder="Tu nombre completo"
                           required autofocus autocomplete="name">
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="field">
                    <label for="email">Correo electrónico</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="tucorreo@ejemplo.com"
                           required autocomplete="email">
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password + Confirm (side by side) -->
                <div class="fields-grid">
                    <div class="field">
                        <label for="password">Contraseña</label>
                        <div class="password-wrapper">
                            <input id="password" type="password" name="password"
                                   placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                                   required autocomplete="new-password">
                            <button type="button" class="toggle-password" onclick="togglePass('password', this)" aria-label="Mostrar contraseña">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirmar contraseña</label>
                        <div class="password-wrapper">
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;"
                                   required autocomplete="new-password">
                            <button type="button" class="toggle-password" onclick="togglePass('password_confirmation', this)" aria-label="Mostrar contraseña">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit -->
                <div class="form-actions">
                    <button type="submit" class="btn-submit" data-test="register-user-button">
                        Crear cuenta
                    </button>
                </div>

                <div class="form-divider"><div class="divider-diamond"></div></div>
                <div class="login-hint">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Ingresar aquí</a>
                </div>

            </form>

        </div>
    </div>

    <footer>
        <span class="footer-text">Tejidos Caymi &middot; Manufactura artesanal kichwa</span>
        <div class="footer-stripes">
            <span style="background:#a85c3a"></span>
            <span style="background:#2e6b68"></span>
            <span style="background:#b8892a"></span>
            <span style="background:#a85c3a"></span>
            <span style="background:#1c1712"></span>
        </div>
        <span class="footer-text">Ponchos &middot; Telas &middot; Cultura</span>
    </footer>

    <script>
        function togglePass(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            // Swap icon: eye vs eye-off
            btn.innerHTML = isPassword
                ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
                : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
        }
    </script>

</body>
</html>