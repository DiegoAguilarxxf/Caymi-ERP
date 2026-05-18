<x-app-layout>
    <x-slot name="header">
        <h2 style="
            font-family: 'EB Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--ink);
            letter-spacing: 0.02em;
        ">
            Dashboard <em style="font-style:italic; color: var(--terracotta);">Administrador</em>
        </h2>
    </x-slot>

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

        body {
            font-family: 'Josefin Sans', sans-serif;
            font-weight: 300;
            background-color: var(--sand) !important;
            color: var(--ink);
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='1' height='1' fill='%23b09a7a' opacity='0.07'/%3E%3Crect x='2' y='2' width='1' height='1' fill='%23b09a7a' opacity='0.07'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0;
        }

        /* ── Dashboard wrapper ── */
        .caymi-dashboard {
            padding: 2.5rem 2rem;
            max-width: 1280px;
            margin: 0 auto;
            position: relative; z-index: 10;
            display: flex; flex-direction: column; gap: 3rem;
        }

        /* ── Section eyebrow ── */
        .caymi-eyebrow {
            font-size: 0.58rem; letter-spacing: 0.3em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.75rem;
        }
        .caymi-eyebrow::before { content: ''; width: 28px; height: 1px; background: var(--teal); display: block; }

        /* ── Stat cards grid ── */
        .caymi-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3px;
        }

        .caymi-stat-card {
            background: #fff8f0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            padding: 1.75rem 1.5rem;
            position: relative; overflow: hidden;
            transition: background 0.2s;
        }
        .caymi-stat-card:hover { background: #fdf2e6 !important; }

        /* Accent top border por rol/sección */
        .grid-resumen .caymi-stat-card:nth-child(1) { border-top: 3px solid var(--terracotta); }
        .grid-resumen .caymi-stat-card:nth-child(2) { border-top: 3px solid var(--gold); }
        .grid-resumen .caymi-stat-card:nth-child(3) { border-top: 3px solid var(--teal); }
        .grid-resumen .caymi-stat-card:nth-child(4) { border-top: 3px solid var(--ink-soft); }

        .grid-vectorial .caymi-stat-card:nth-child(1) { border-top: 3px solid var(--teal); }
        .grid-vectorial .caymi-stat-card:nth-child(2) { border-top: 3px solid var(--ink-soft); }
        .grid-vectorial .caymi-stat-card:nth-child(3) { border-top: 3px solid var(--terracotta); }
        .grid-vectorial .caymi-stat-card:nth-child(4) { border-top: 3px solid var(--gold); }

        /* Decorative corner */
        .caymi-stat-card::after {
            content: '';
            position: absolute; bottom: 0; right: 0;
            width: 28px; height: 28px;
            border-top: 1px solid var(--sand-dark);
            border-left: 1px solid var(--sand-dark);
        }

        .caymi-stat-label {
            font-size: 0.55rem; letter-spacing: 0.25em; text-transform: uppercase;
            color: var(--ink-soft); margin-bottom: 0.75rem; display: block;
        }
        .caymi-stat-number {
            font-family: 'EB Garamond', serif;
            font-size: 3.2rem; font-weight: 400; line-height: 1;
            margin-bottom: 0.25rem;
        }
        .caymi-stat-number.color-terracotta { color: var(--terracotta); }
        .caymi-stat-number.color-gold       { color: var(--gold); }
        .caymi-stat-number.color-teal       { color: var(--teal); }
        .caymi-stat-number.color-ink        { color: var(--ink-soft); }

        /* ── Tables grid ── */
        .caymi-tables-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2px;
        }
        .caymi-tables-full {
            display: grid;
            grid-template-columns: 1fr;
        }

        .caymi-table-card {
            background: #faf6f0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            padding: 1.75rem 1.5rem;
            border-top: 2px solid var(--sand-dark);
        }

        .caymi-table-title {
            font-size: 0.58rem; letter-spacing: 0.25em; text-transform: uppercase;
            color: var(--ink); margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--sand-dark);
        }

        .caymi-table {
            width: 100%; border-collapse: collapse;
        }
        .caymi-table thead th {
            font-size: 0.52rem !important; letter-spacing: 0.2em !important;
            text-transform: uppercase !important;
            color: var(--ink-soft) !important;
            font-weight: 400 !important;
            padding-bottom: 0.75rem;
            text-align: left;
        }
        .caymi-table tbody tr {
            border-top: 1px solid var(--sand-dark);
        }
        .caymi-table tbody td {
            padding: 0.75rem 0;
            font-size: 0.75rem; letter-spacing: 0.03em;
            color: var(--ink-soft);
            vertical-align: middle;
        }
        .caymi-table tbody td:first-child { color: var(--ink); font-weight: 400; }
        .caymi-table .caymi-empty-row td {
            font-size: 0.6rem; letter-spacing: 0.15em; text-transform: uppercase;
            color: var(--sand-dark); padding: 1.25rem 0;
            text-align: center;
        }

        /* Status badges */
        .caymi-badge {
            display: inline-block;
            font-size: 0.5rem; letter-spacing: 0.15em; text-transform: uppercase;
            padding: 0.2rem 0.6rem;
            border-radius: 0;
        }
        .caymi-badge-pending  { background: rgba(184,137,42,0.12);  color: var(--gold); }
        .caymi-badge-approved { background: rgba(46,107,104,0.12);  color: var(--teal); }
        .caymi-badge-rejected { background: rgba(168,92,58,0.12);   color: var(--terracotta); }
        .caymi-badge-completed{ background: rgba(28,23,18,0.08);    color: var(--ink-soft); }
        
        .caymi-badge-success  { background: rgba(46,107,104,0.12);  color: var(--teal); }
        .caymi-badge-error    { background: rgba(168,92,58,0.12);   color: var(--terracotta); }

        /* Responsive */
        @media (max-width: 1024px) {
            .caymi-stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 640px) {
            .caymi-stats-grid  { grid-template-columns: 1fr; }
            .caymi-tables-grid { grid-template-columns: 1fr; }
            .caymi-dashboard   { padding: 1.5rem 1.25rem; }
        }
    </style>

    <div class="caymi-dashboard">

        {{-- RESUMEN GENERAL --}}
        <div>
            <div class="caymi-eyebrow">Resumen General</div>
            <div class="caymi-stats-grid grid-resumen">
                <div class="caymi-stat-card">
                    <span class="caymi-stat-label">Total Productos</span>
                    <p class="caymi-stat-number color-terracotta">{{ $totalProducts }}</p>
                </div>
                <div class="caymi-stat-card">
                    <span class="caymi-stat-label">Total Clientes</span>
                    <p class="caymi-stat-number color-gold">{{ $totalClients }}</p>
                </div>
                <div class="caymi-stat-card">
                    <span class="caymi-stat-label">Pedidos Pendientes</span>
                    <p class="caymi-stat-number color-teal">{{ $pendingOrders }}</p>
                </div>
                <div class="caymi-stat-card">
                    <span class="caymi-stat-label">Tasa de Éxito</span>
                    <p class="caymi-stat-number color-ink">{{ $successRate }}%</p>
                </div>
            </div>
        </div>

        {{-- RENDIMIENTO VECTORIAL --}}
        <div>
            <div class="caymi-eyebrow">Rendimiento Base Vectorial</div>
            <div class="caymi-stats-grid grid-vectorial">
                <div class="caymi-stat-card">
                    <span class="caymi-stat-label">Vectores Almacenados</span>
                    <p class="caymi-stat-number color-teal">{{ $totalVectors }}</p>
                </div>
                <div class="caymi-stat-card">
                    <span class="caymi-stat-label">Total Búsquedas</span>
                    <p class="caymi-stat-number color-ink">{{ $totalSearches }}</p>
                </div>
                <div class="caymi-stat-card">
                    <span class="caymi-stat-label">Latencia Promedio</span>
                    <p class="caymi-stat-number color-terracotta">{{ round($avgSearchLatency ?? 0) }} <span style="font-size: 1.2rem;">ms</span></p>
                </div>
                <div class="caymi-stat-card">
                    <span class="caymi-stat-label">Consultas Chatbot</span>
                    <p class="caymi-stat-number color-gold">{{ $totalChatbotQueries }}</p>
                </div>
            </div>
        </div>

        {{-- ACTIVIDAD DE USUARIOS --}}
        <div class="caymi-tables-grid">
            
            <div class="caymi-table-card">
                <div class="caymi-table-title">Pedidos por Cliente</div>
                <table class="caymi-table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th style="text-align: right;">Pedidos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ordersByClient as $row)
                            <tr>
                                <td>{{ $row->user->name ?? '—' }}</td>
                                <td style="text-align: right; font-weight: 400; color: var(--terracotta);">{{ $row->total }}</td>
                            </tr>
                        @empty
                            <tr class="caymi-empty-row"><td colspan="2">Sin datos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="caymi-table-card">
                <div class="caymi-table-title">Top Búsquedas Semánticas</div>
                <table class="caymi-table">
                    <thead>
                        <tr>
                            <th>Consulta</th>
                            <th style="text-align: right;">Veces</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topSearches as $search)
                            <tr>
                                <td>{{ $search->query_text }}</td>
                                <td style="text-align: right; font-weight: 400; color: var(--teal);">{{ $search->total }}</td>
                            </tr>
                        @empty
                            <tr class="caymi-empty-row"><td colspan="2">Sin búsquedas aún</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- ÚLTIMOS PEDIDOS --}}
        <div class="caymi-tables-full">
            <div class="caymi-table-card">
                <div class="caymi-table-title">Últimos Pedidos</div>
                <table class="caymi-table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Producto</th>
                            <th>Estado</th>
                            <th style="text-align: right;">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td>{{ $order->user->name ?? '—' }}</td>
                                <td>{{ $order->product->name ?? '—' }}</td>
                                <td>
                                    <span @class([
                                        'caymi-badge',
                                        'caymi-badge-pending'   => $order->status === 'pending',
                                        'caymi-badge-approved'  => $order->status === 'approved',
                                        'caymi-badge-rejected'  => $order->status === 'rejected',
                                        'caymi-badge-completed' => $order->status === 'completed',
                                    ])>{{ ucfirst($order->status) }}</span>
                                </td>
                                <td style="text-align: right; color: var(--ink-soft);">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr class="caymi-empty-row"><td colspan="4">Sin pedidos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- LOGS OPERACIONALES --}}
        <div class="caymi-tables-full">
            <div class="caymi-table-card">
                <div class="caymi-table-title">Logs Operacionales Recientes</div>
                <table class="caymi-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Acción</th>
                            <th>Estado</th>
                            <th style="text-align: right;">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                            <tr>
                                <td>{{ $log->user->name ?? 'Sistema' }}</td>
                                <td>{{ $log->action }}</td>
                                <td>
                                    <span @class([
                                        'caymi-badge',
                                        'caymi-badge-success' => $log->status === 'success',
                                        'caymi-badge-error'   => $log->status === 'error',
                                    ])>{{ $log->status }}</span>
                                </td>
                                <td style="text-align: right; color: var(--ink-soft);">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr class="caymi-empty-row"><td colspan="4">Sin logs</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>