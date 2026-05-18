<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-between; align-items: center; justify-content: space-between; width: 100%;">
            <h2 style="
                font-family: 'EB Garamond', serif;
                font-size: 1.6rem;
                font-weight: 400;
                color: var(--ink);
                letter-spacing: 0.02em;
                margin: 0;
            ">
                Catálogo de <em style="font-style:italic; color: var(--terracotta);">Productos</em>
            </h2>
            
            <a href="{{ route('admin.products.create') }}" class="caymi-btn-header">
                + Nuevo Producto
            </a>
        </div>
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

        /* ── Enlace de Cabecera ── */
        .caymi-btn-header {
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--teal);
            text-decoration: none;
            border: 1px solid rgba(46,107,104, 0.3);
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }
        .caymi-btn-header:hover {
            background: var(--teal);
            color: #fff8f0;
            border-color: var(--teal);
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
            gap: 0.4rem;
            align-items: center;
        }
        .caymi-btn {
            background: transparent;
            font-family: 'Josefin Sans', sans-serif;
            font-size: 0.52rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 0.35rem 0.65rem;
            cursor: pointer;
            border-radius: 0;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s ease-in-out;
            line-height: 1;
        }
        
        /* Botón Ver (Monocromo soft) */
        .caymi-btn-show {
            border: 1px solid rgba(74,64,53, 0.3);
            color: var(--ink-soft);
        }
        .caymi-btn-show:hover {
            background: var(--ink-soft);
            color: #fff8f0;
            border-color: var(--ink-soft);
        }

        /* Botón Editar (Gold refinado) */
        .caymi-btn-edit {
            border: 1px solid rgba(184,137,42, 0.3);
            color: var(--gold);
        }
        .caymi-btn-edit:hover {
            background: var(--gold);
            color: #fff8f0;
            border-color: var(--gold);
        }

        /* Botón Eliminar (Terracotta refinado) */
        .caymi-btn-delete {
            border: 1px solid rgba(168,92,58, 0.3);
            color: var(--terracotta);
        }
        .caymi-btn-delete:hover {
            background: var(--terracotta);
            color: #fff8f0;
            border-color: var(--terracotta);
        }

        /* ── Custom Pagination ── */
        .caymi-pagination {
            margin-top: 0.5rem;
        }
        
        @media (max-width: 640px) {
            .caymi-dashboard { padding: 1.5rem 1.25rem; }
            .caymi-btn-group { flex-direction: column; gap: 0.25rem; align-items: flex-start; }
        }
    </style>

    <div class="caymi-dashboard">

        {{-- ALERTAS DE SISTEMA --}}
        @if(session('success'))
            <div class="caymi-alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLA DE PRODUCTOS --}}
        <div class="caymi-table-card">
            <table class="caymi-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td style="font-style: italic; color: var(--ink-soft);">
                                {{ $product->category ?? '—' }}
                            </td>
                            <td style="font-weight: 400; color: var(--ink);">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td style="color: var(--ink-soft);">
                                {{ $product->stock }}
                            </td>
                            <td>
                                <div class="caymi-btn-group">
                                    <a href="{{ route('admin.products.show', $product) }}" class="caymi-btn caymi-btn-show">
                                        Ver
                                    </a>
                                    
                                    <a href="{{ route('admin.products.edit', $product) }}" class="caymi-btn caymi-btn-edit">
                                        Editar
                                    </a>
                                    
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                          onsubmit="return confirm('¿Eliminar este producto?')" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="caymi-btn caymi-btn-delete">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="caymi-empty-row">
                            <td colspan="5">No hay productos registrados en el catálogo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="caymi-pagination">
            {{ $products->links() }}
        </div>

    </div>
</x-app-layout>