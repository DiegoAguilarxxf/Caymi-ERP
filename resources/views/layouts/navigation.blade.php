<nav x-data="{ open: false }" class="caymi-nav">
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

        /* Nav Base Container */
        .caymi-nav {
            background-color: #faf6f0 !important; /* Un tono ligeramente más claro que el fondo general */
            border-bottom: 1px solid var(--sand-mid) !important;
            font-family: 'Josefin Sans', sans-serif;
            font-weight: 300;
            position: relative;
            z-index: 50;
        }

        /* Forzar estilos sobre los componentes nativos de Breeze */
        .caymi-nav a, 
        .caymi-nav button {
            font-family: 'Josefin Sans', sans-serif !important;
            text-transform: uppercase !important;
            letter-spacing: 0.15em !important;
            font-size: 0.65rem !important;
            color: var(--ink-soft) !important;
            transition: color 0.2s ease, border-color 0.2s ease !important;
        }

        /* Enlaces de Navegación Customizados */
        .caymi-nav .flex.space-x-8 a {
            border-bottom: 1px solid transparent !important;
            padding-bottom: 4px;
            height: auto !important;
            align-self: center;
            margin-top: 4px;
        }

        .caymi-nav .flex.space-x-8 a:hover {
            color: var(--ink) !important;
            border-bottom-color: var(--sand-dark) !important;
            text-decoration: none !important;
        }

        /* Estado Activo (Editorial) */
        .caymi-nav .flex.space-x-8 a[class*="border-indigo"],
        .caymi-nav .flex.space-x-8 a[aria-current="page"],
        .caymi-nav .flex.space-x-8 a.active-custom,
        /* Selector fallback si Breeze inyecta clases activas */
        .caymi-nav a[class*="text-gray-900"] {
            color: var(--teal) !important;
            border-bottom: 1px solid var(--teal) !important;
            font-weight: 400 !important;
        }

        /* Dropdown Trigger Ajustes */
        .caymi-nav button {
            background: transparent !important;
            border: none !important;
            padding-right: 0 !important;
            box-shadow: none !important;
        }
        .caymi-nav button:hover {
            color: var(--ink) !important;
        }
        .caymi-nav button svg {
            fill: var(--ink-soft) !important;
        }

        /* Logo Brand Style */
        .caymi-brand-logo {
            font-family: 'EB Garamond', serif !important;
            font-size: 1.3rem !important;
            letter-spacing: 0.05em !important;
            text-transform: none !important;
            color: var(--ink) !important;
            font-weight: 400 !important;
            display: flex;
            align-items: center;
            text-decoration: none !important;
        }
        .caymi-brand-logo em {
            font-style: italic;
            color: var(--terracotta);
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo Identidad Editorial -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('client.dashboard') }}" class="caymi-brand-logo">
                        caymi<!-- O puedes mantener tu componente si prefieres: <x-application-logo style="height: 2.25rem; width: auto; fill: currentColor; color: var(--ink);" /> -->
                    </a>
                </div>

                <!-- Enlaces de Navegación -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            {{ __('Productos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            {{ __('Pedidos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.chat')" :active="request()->routeIs('admin.chat*')">
                            {{ __('Asistente') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('client.catalog')" :active="request()->routeIs('client.catalog')">
                            {{ __('Catálogo') }}
                        </x-nav-link>
                        <x-nav-link :href="route('client.orders.index')" :active="request()->routeIs('client.orders.*')">
                            {{ __('Mis Pedidos') }}
                        </x-nav-link>
                        <x-nav-link :href="route('client.chat')" :active="request()->routeIs('client.chat*')">
                            {{ __('Asistente') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Menú Desplegable de Usuario -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" style="font-size: 0.6rem !important; letter-spacing: 0.12em !important;">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                style="font-size: 0.6rem !important; letter-spacing: 0.12em !important; color: var(--terracotta) !important;">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>