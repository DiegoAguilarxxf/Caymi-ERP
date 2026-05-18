<x-app-layout>
    <x-slot name="header">
        <h2 style="
            font-family: 'EB Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--ink);
            letter-spacing: 0.02em;
        ">
            Gestión de <em style="font-style:italic; color: var(--terracotta);">Pedidos</em>
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
            display: flex; flex-direction: column; gap: 2rem;
        }

        /* ── Alert Notification ── */
        .caymi-alert {
            background: #faf6f0;
            border-left: 3px solid var(--teal);
            padding: 1rem 1.25rem;
            font-size: 0.75rem;
            letter-spacing: 0.03em;
            color: var(--teal);
            font-weight: 400;
        }

        /* ── Table Container ── */
        .caymi-table-card {
            background: #faf6f0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            padding: 1.75rem 1.5rem;
            border-top: 2px solid var(--sand-dark);
            overflow-x: auto;
        }

        .caymi-table {
            width: 100%;
            border-collapse: collapse;
        }
        .caymi-table thead th {
            font-size: 0.52rem !important;
            letter-spacing: 0.2em !important;
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
            padding: 0.9rem 0.5rem 0.9rem 0;
            font-size: 0.75rem;
            letter-spacing: 0.03em;
            color: var(--ink-soft);
            vertical-align: middle;
        }
        .caymi-table tbody td:first-child {
            color: var(--ink);
            font-weight: 400;
        }
        .caymi-empty-row td {
            font-size: 0.6rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--sand-dark);
            padding: 2rem 0 !important;
            text-align: center;
        }

        /* ── Action Buttons Minimalistas ── */
        .caymi-btn-group {
            display: flex;
            gap: 0.5rem;
        }
        .caymi-btn {
            background: transparent;
            font-family: 'Josefin Sans', sans-serif;
            font-size: 0.55rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.4rem 0.8rem;
            cursor: pointer;
            border-radius: 0;
            transition: all 0.2s ease-in-out;
        }
        
        /* Botón Aprobar (Teal refinado) */
        .caymi-btn-approve {
            border: 1px solid rgba(46,107,104, 0.4);
            color: var(--teal);
        }
        .caymi-btn-approve:hover {
            background: var(--teal);
            color: #fff8f0;
            border-color: var(--teal);
        }

        /* Botón Rechazar (Terracotta refinado) */
        .caymi-btn-reject {
            border: 1px solid rgba(168,92,58, 0.4);
            color: var(--terracotta);
        }
        .caymi-btn-reject:hover {
            background: var(--terracotta);
            color: #fff8f0;
            border-color: var(--terracotta);
        }

        /* Botón Completar (Ink / Monocromo elegante) */
        .caymi-btn-complete {
            border: 1px solid rgba(28,23,18, 0.4);
            color: var(--ink);
        }
        .caymi-btn-complete:hover {
            background: var(--ink);
            color: #fff8f0;
            border-color: var(--ink);
        }

        /* ── Status badges ── */
        .caymi-badge {
            display: inline-block;
            font-size: 0.5rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.2rem 0.6rem;
            border-radius: 0;
        }
        .caymi-badge-pending  { background: rgba(184,137,42,0.12);  color: var(--gold); }
        .caymi-badge-approved { background: rgba(46,107,104,0.12);  color: var(--teal); }
        .caymi-badge-rejected { background: rgba(168,92,58,0.12);   color: var(--terracotta); }
        .caymi-badge-completed{ background: rgba(28,23,18,0.08);    color: var(--ink-soft); }

        /* ── Custom Pagination ── */
        .caymi-pagination {
            margin-top: 0.5rem;
        }
        
        @media (max-width: 640px) {
            .caymi-dashboard { padding: 1.5rem 1.25rem; }
            .caymi-btn-group { flex-direction: column; gap: 0.25rem; }
        }
    </style>

    <div class="caymi-dashboard">

        {{-- ALERTAS DE SISTEMA --}}
        @if(session('success'))
            <div class="caymi-alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLA PRINCIPAL DE GESTIÓN --}}
        <div class="caymi-table-card">
            <table class="caymi-table">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Personalización</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->user->name ?? '—' }}</td>
                            <td>{{ $order->product->name ?? '—' }}</td>
                            <td style="font-weight: 400; color: var(--ink);">{{ $order->quantity }}</td>
                            <td style="font-style: italic; color: var(--ink-soft);">
                                {{ $order->customization ?? '—' }}
                            </td>
                            <td>
                                <span @class([
                                    'caymi-badge',
                                    'caymi-badge-pending'   => $order->status === 'pending',
                                    'caymi-badge-approved'  => $order->status === 'approved',
                                    'caymi-badge-rejected'  => $order->status === 'rejected',
                                    'caymi-badge-completed' => $order->status === 'completed',
                                ])>{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                @if($order->status === 'pending')
                                    <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="caymi-btn-group">
                                        @csrf
                                        @method('PATCH')
                                        <button name="status" value="approved" class="caymi-btn caymi-btn-approve">
                                            Aprobar
                                        </button>
                                        <button name="status" value="rejected" class="caymi-btn caymi-btn-reject">
                                            Rechazar
                                        </button>
                                    </form>
                                @elseif($order->status === 'approved')
                                    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button name="status" value="completed" class="caymi-btn caymi-btn-complete">
                                            Completar
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size: 0.55rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--sand-dark);">
                                        Sin acciones
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="caymi-empty-row">
                            <td colspan="6">No hay pedidos registrados en este momento.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="caymi-pagination">
            {{ $orders->links() }}
        </div>

    </div>
</x-app-layout>