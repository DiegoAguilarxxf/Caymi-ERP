<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Welcome') }} - {{ config('app.name', 'Tejidos Caymi') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;1,400;1,500&family=Josefin+Sans:wght@300;400&display=swap" rel="stylesheet">
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
            body::before {
                content: '';
                position: fixed;
                inset: 0;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='1' height='1' fill='%23b09a7a' opacity='0.07'/%3E%3Crect x='2' y='2' width='1' height='1' fill='%23b09a7a' opacity='0.07'/%3E%3C/svg%3E");
                pointer-events: none;
                z-index: 0;
            }
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
            header {
                position: relative; z-index: 10;
                padding: 2rem 3rem 2rem 3.5rem;
                display: flex; align-items: center; justify-content: space-between;
                border-bottom: 1px solid var(--sand-dark);
            }
            .brand-name { font-family: 'EB Garamond', serif; font-size: 1.65rem; font-weight: 400; letter-spacing: 0.04em; color: var(--ink); line-height: 1; }
            .brand-name em { font-style: italic; color: var(--terracotta); }
            .brand-origin { font-size: 0.58rem; letter-spacing: 0.28em; text-transform: uppercase; color: var(--ink-soft); margin-top: 0.2rem; }
            nav { display: flex; align-items: center; gap: 0.75rem; }
            .nav-link { font-size: 0.65rem; letter-spacing: 0.18em; text-transform: uppercase; color: var(--ink-soft); text-decoration: none; padding: 0.5rem 1.1rem; border: 1px solid transparent; transition: all 0.25s ease; }
            .nav-link:hover { color: var(--ink); border-color: var(--sand-dark); }
            .nav-link.primary { border-color: var(--ink); color: var(--ink); }
            .nav-link.primary:hover { background: var(--ink); color: var(--sand); }
            .hero { position: relative; z-index: 10; display: grid; grid-template-columns: 1fr 1fr; flex: 1; }
            .hero-text { padding: 5rem 3rem 5rem 3.5rem; display: flex; flex-direction: column; justify-content: center; border-right: 1px solid var(--sand-dark); }
            .eyebrow { font-size: 0.6rem; letter-spacing: 0.3em; text-transform: uppercase; color: var(--teal); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; }
            .eyebrow::before { content: ''; width: 28px; height: 1px; background: var(--teal); display: block; }
            h1 { font-family: 'EB Garamond', serif; font-size: clamp(2.8rem, 5vw, 4rem); font-weight: 400; line-height: 1.08; color: var(--ink); margin-bottom: 1.75rem; }
            h1 em { font-style: italic; color: var(--terracotta); }
            .hero-desc { font-size: 0.72rem; letter-spacing: 0.08em; line-height: 1.9; color: var(--ink-soft); max-width: 30ch; margin-bottom: 3rem; text-transform: uppercase; }
            .chakana { width: 34px; height: 34px; margin-bottom: 3rem; opacity: 0.35; }
            .collection-links { display: flex; flex-direction: column; border-top: 1px solid var(--sand-dark); }
            .collection-link { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 0; border-bottom: 1px solid var(--sand-dark); text-decoration: none; color: var(--ink); font-size: 0.68rem; letter-spacing: 0.15em; text-transform: uppercase; transition: all 0.2s ease; cursor: default; }
            .collection-link span:first-child { display: flex; align-items: center; gap: 0.75rem; }
            .link-dot { width: 5px; height: 5px; background: var(--sand-dark); transform: rotate(45deg); transition: background 0.2s; flex-shrink: 0; }
            .collection-link:hover .link-dot { background: var(--terracotta); }
            .collection-link:hover { color: var(--terracotta); }
            .link-arrow { font-size: 0.8rem; opacity: 0.25; transition: opacity 0.2s, transform 0.2s; }
            .collection-link:hover .link-arrow { opacity: 0.7; transform: translateX(4px); }
            .hero-visual { background-color: var(--sand-mid); position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; min-height: 420px; }
            .pattern-bg { position: absolute; inset: 0; opacity: 0.18; background-image: repeating-linear-gradient(0deg, transparent 0px, transparent 10px, var(--terracotta) 10px, var(--terracotta) 12px, transparent 12px, transparent 22px, var(--teal) 22px, var(--teal) 24px, transparent 24px, transparent 34px, var(--gold) 34px, var(--gold) 36px); }
            .pattern-bg-cross { position: absolute; inset: 0; opacity: 0.06; background-image: repeating-linear-gradient(90deg, var(--ink) 0px, var(--ink) 1px, transparent 1px, transparent 36px); }
            .frame-tl, .frame-br { position: absolute; width: 40px; height: 40px; z-index: 3; }
            .frame-tl { top: 2rem; left: 2rem; border-top: 1px solid var(--terracotta); border-left: 1px solid var(--terracotta); opacity: 0.5; }
            .frame-br { bottom: 2rem; right: 2rem; border-bottom: 1px solid var(--teal); border-right: 1px solid var(--teal); opacity: 0.5; }
            .brand-mark { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; gap: 2rem; animation: fadein 1s ease forwards; }
            @keyframes fadein { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
            .brand-mark-svg { width: 200px; filter: drop-shadow(0 4px 24px rgba(168,92,58,0.15)); }
            .mark-label { font-size: 0.58rem; letter-spacing: 0.35em; text-transform: uppercase; color: var(--ink-soft); text-align: center; }
            footer { position: relative; z-index: 10; border-top: 1px solid var(--sand-dark); padding: 1rem 3rem 1rem 3.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
            .footer-text { font-size: 0.58rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--sand-dark); }
            .footer-stripes { display: flex; gap: 3px; align-items: center; }
            .footer-stripes span { display: block; height: 10px; width: 3px; }
            @media (max-width: 680px) {
                .hero { grid-template-columns: 1fr; }
                header { padding: 1.5rem 2rem 1.5rem 2.5rem; flex-wrap: wrap; gap: 1rem; }
                .hero-text { padding: 3rem 2rem 3rem 2.5rem; border-right: none; border-bottom: 1px solid var(--sand-dark); }
                footer { flex-direction: column; text-align: center; padding: 1.25rem 2rem; }
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
            <div>
                <div class="brand-name">Tejidos <em>Caymi</em></div>
                <div class="brand-origin">Peguche &middot; Imbabura &middot; Ecuador</div>
            </div>
            @if (Route::has('login'))
                <nav>
                    @auth
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('client.dashboard') }}" class="nav-link primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Ingresar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link primary">Registrarse</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="hero">
            <div class="hero-text">
                <div class="eyebrow">Catálogo de tejidos</div>
                <h1>Arte kichwa<br>hecho <em>tejido</em></h1>
                <p class="hero-desc">
                    Ponchos, fajas y telas culturales<br>
                    elaborados a mano en Peguche<br>
                    desde generaciones.
                </p>
                <svg class="chakana" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="12" y="0"  width="12" height="12" fill="var(--terracotta)"/>
                    <rect x="0"  y="12" width="36" height="12" fill="var(--terracotta)"/>
                    <rect x="12" y="24" width="12" height="12" fill="var(--terracotta)"/>
                    <rect x="14" y="14" width="8"  height="8"  fill="var(--sand)"/>
                    <rect x="16" y="16" width="4"  height="4"  fill="var(--teal)"/>
                </svg>
                <div class="collection-links">
                    <div class="collection-link">
                        <span><span class="link-dot"></span>Ponchos tradicionales</span>
                        <span class="link-arrow">&#8594;</span>
                    </div>
                    <div class="collection-link">
                        <span><span class="link-dot"></span>Fajas y cinturones</span>
                        <span class="link-arrow">&#8594;</span>
                    </div>
                    <div class="collection-link">
                        <span><span class="link-dot"></span>Telas y metraje</span>
                        <span class="link-arrow">&#8594;</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="pattern-bg"></div>
                <div class="pattern-bg-cross"></div>
                <div class="frame-tl"></div>
                <div class="frame-br"></div>
                <div class="brand-mark">
                    <svg class="brand-mark-svg" viewBox="0 0 200 220" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                    <div class="mark-label">Peguche &middot; Imbabura &middot; Ecuador</div>
                </div>
            </div>
        </main>

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
    </body>
</html>