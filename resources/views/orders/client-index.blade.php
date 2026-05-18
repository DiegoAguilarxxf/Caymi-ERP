<x-app-layout>
    <x-slot name="header">
        <h2 style="
            font-family: 'EB Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--ink);
            letter-spacing: 0.02em;
        ">
            Mis <em style="font-style:italic; color: var(--terracotta);">Pedidos</em>
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

        /* ── Page wrapper ── */
        .caymi-orders {
            padding: 2.5rem 2rem;
            max-width: 1280px;
            margin: 0 auto;
            position: relative; z-index: 10;
        }

        /* ── Flash ── */
        .caymi-flash {
            font-size: 0.65rem; letter-spacing: 0.08em;
            color: var(--teal); background: rgba(46,107,104,0.08);
            border-left: 2px solid var(--teal);
            padding: 0.7rem 1rem;
            margin-bottom: 1.75rem;
        }

        /* ── Eyebrow ── */
        .caymi-eyebrow {
            font-size: 0.58rem; letter-spacing: 0.3em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 1.5rem;
            display: flex; align-items: center; gap: 0.75rem;
        }
        .caymi-eyebrow::before { content: ''; width: 28px; height: 1px; background: var(--teal); display: block; }

        /* ── Table card ── */
        .caymi-table-wrap {
            background: #fff8f0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            overflow: hidden;
            border-top: 3px solid var(--terracotta);
        }

        /* ── Table ── */
        .caymi-table {
            width: 100%;
            border-collapse: collapse;
        }

        .caymi-table thead tr {
            background: var(--sand-mid);
            border-bottom: 1px solid var(--sand-dark);
        }
        .caymi-table thead th {
            padding: 0.9rem 1.5rem;
            font-family: 'Josefin Sans', sans-serif !important;
            font-size: 0.52rem !important;
            letter-spacing: 0.22em !important;
            text-transform: uppercase !important;
            font-weight: 400 !important;
            color: var(--ink-soft) !important;
            text-align: left;
        }

        .caymi-table tbody tr {
            border-bottom: 1px solid var(--sand-mid);
            transition: background 0.15s;
        }
        .caymi-table tbody tr:last-child { border-bottom: none; }
        .caymi-table tbody tr:hover { background: #fdf5ec; }

        .caymi-table tbody td {
            padding: 1rem 1.5rem;
            font-size: 0.78rem;
            letter-spacing: 0.03em;
            color: var(--ink-soft);
            vertical-align: middle;
        }
        .caymi-table tbody td:first-child {
            font-family: 'EB Garamond', serif;
            font-size: 1rem;
            color: var(--ink);
        }

        /* Empty row */
        .caymi-empty td {
            padding: 3rem 1.5rem;
            text-align: center;
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--sand-dark);
        }

        /* ── Status badges ── */
        .caymi-badge {
            display: inline-block;
            font-family: 'Josefin Sans', sans-serif;
            font-size: 0.5rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.25rem 0.65rem;
            border-radius: 0;
        }
        .caymi-badge-pending   { background: rgba(184,137,42,0.12); color: var(--gold); }
        .caymi-badge-approved  { background: rgba(46,107,104,0.12); color: var(--teal); }
        .caymi-badge-rejected  { background: rgba(168,92,58,0.12);  color: var(--terracotta); }
        .caymi-badge-completed { background: rgba(28,23,18,0.07);   color: var(--ink-soft); }

        /* ── Pagination ── */
        .caymi-pagination {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--sand-dark);
        }
    </style>

    <div class="caymi-orders">

        @if(session('success'))
            <div class="caymi-flash">{{ session('success') }}</div>
        @endif

        <div class="caymi-eyebrow">Historial de pedidos</div>

        <div class="caymi-table-wrap">
            <table class="caymi-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Personalización</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->product->name ?? '—' }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ $order->customization ?? '—' }}</td>
                            <td>
                                <span @class([
                                    'caymi-badge',
                                    'caymi-badge-pending'   => $order->status === 'pending',
                                    'caymi-badge-approved'  => $order->status === 'approved',
                                    'caymi-badge-rejected'  => $order->status === 'rejected',
                                    'caymi-badge-completed' => $order->status === 'completed',
                                ])>{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr class="caymi-empty">
                            <td colspan="5">No tienes pedidos aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="caymi-pagination">
            {{ $orders->links() }}
        </div>

    </div>

</x-app-layout>