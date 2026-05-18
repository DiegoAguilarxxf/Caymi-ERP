<x-app-layout>
    <x-slot name="header">
        <h2 style="
            font-family: 'EB Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--ink);
            letter-spacing: 0.02em;
        ">
            Catálogo de <em style="font-style:italic; color: var(--terracotta);">Productos</em>
        </h2>
    </x-slot>

    {{-- Caymi design tokens + catalog styles --}}
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

        /* Grain texture overlay */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Crect width='1' height='1' fill='%23b09a7a' opacity='0.07'/%3E%3Crect x='2' y='2' width='1' height='1' fill='%23b09a7a' opacity='0.07'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0;
        }

        /* ── Search bar ── */
        .caymi-search-wrap {
            padding: 1.5rem 2rem 0;
            position: relative; z-index: 10;
        }
        .caymi-search-wrap form > div {
            display: flex;
            align-items: stretch;
            gap: 0;
            border-bottom: 1px solid var(--sand-dark);
            padding-bottom: 0.25rem;
        }
        .caymi-search-wrap input[type="text"] {
            flex: 1;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0.45rem 0 !important;
            font-family: 'Josefin Sans', sans-serif !important;
            font-size: 0.82rem !important;
            letter-spacing: 0.05em !important;
            color: var(--ink) !important;
            outline: none !important;
            border-radius: 0 !important;
        }
        .caymi-search-wrap input[type="text"]::placeholder { color: var(--sand-dark) !important; }
        .caymi-search-wrap button[type="submit"] {
            font-family: 'Josefin Sans', sans-serif !important;
            font-size: 0.58rem !important; letter-spacing: 0.2em !important;
            text-transform: uppercase !important;
            background: none !important; border: none !important;
            color: var(--teal) !important; cursor: pointer;
            padding: 0 0 0 1.25rem !important;
            border-radius: 0 !important; box-shadow: none !important;
            transition: color 0.2s;
        }
        .caymi-search-wrap button[type="submit"]:hover { color: var(--terracotta) !important; }
        .caymi-search-wrap a {
            font-family: 'Josefin Sans', sans-serif;
            font-size: 0.58rem; letter-spacing: 0.15em; text-transform: uppercase;
            color: var(--sand-dark); text-decoration: none;
            padding: 0 0 0 1.25rem;
            display: flex; align-items: center;
            transition: color 0.2s;
        }
        .caymi-search-wrap a:hover { color: var(--ink-soft); }

        /* ── Flash message ── */
        .caymi-flash {
            margin: 1.5rem 2rem 0;
            font-size: 0.65rem; letter-spacing: 0.08em;
            color: var(--teal); background: rgba(46,107,104,0.08);
            border-left: 2px solid var(--teal);
            padding: 0.7rem 1rem;
            position: relative; z-index: 10;
        }

        /* ── Catalog section ── */
        .caymi-catalog {
            padding: 2.5rem 2rem;
            position: relative; z-index: 10;
        }

        /* Section eyebrow */
        .caymi-eyebrow {
            font-size: 0.6rem; letter-spacing: 0.3em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 2rem;
            display: flex; align-items: center; gap: 0.75rem;
        }
        .caymi-eyebrow::before { content: ''; width: 28px; height: 1px; background: var(--teal); display: block; }

        /* Grid */
        .caymi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2px;
        }

        /* Card */
        .caymi-card {
            background: var(--sand-mid) !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            overflow: hidden;
            display: flex; flex-direction: column;
            position: relative;
            transition: background 0.2s;
        }
        .caymi-card:hover { background: #ede6da !important; }
        .caymi-card::before {
            content: '';
            position: absolute; top: 0.75rem; left: 0.75rem;
            width: 18px; height: 18px;
            border-top: 1px solid var(--terracotta);
            border-left: 1px solid var(--terracotta);
            opacity: 0; transition: opacity 0.2s; z-index: 2;
        }
        .caymi-card:hover::before { opacity: 0.4; }

        /* Product image */
        .caymi-card img {
            width: 100%; height: 220px;
            object-fit: cover; display: block;
        }
        .caymi-card .caymi-no-image {
            width: 100%; height: 220px;
            background: var(--sand-dark);
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden;
        }
        .caymi-card .caymi-no-image::after {
            content: '';
            position: absolute; inset: 0;
            background-image: repeating-linear-gradient(
                45deg,
                transparent 0, transparent 8px,
                rgba(168,92,58,0.07) 8px, rgba(168,92,58,0.07) 9px
            );
        }
        .caymi-card .caymi-no-image span {
            font-size: 0.55rem; letter-spacing: 0.25em; text-transform: uppercase;
            color: var(--sand-mid); position: relative; z-index: 1;
        }

        /* Card body */
        .caymi-card-body {
            padding: 1.5rem;
            display: flex; flex-direction: column; flex: 1;
            border-top: 1px solid var(--sand-dark);
        }

        .caymi-category {
            font-size: 0.55rem; letter-spacing: 0.25em; text-transform: uppercase;
            color: var(--teal); margin-bottom: 0.35rem;
        }
        .caymi-product-name {
            font-family: 'EB Garamond', serif;
            font-size: 1.2rem; font-weight: 400; color: var(--ink);
            line-height: 1.2; margin-bottom: 0.5rem;
        }
        .caymi-product-desc {
            font-size: 0.72rem; letter-spacing: 0.03em; line-height: 1.65;
            color: var(--ink-soft); margin-bottom: 1rem; flex: 1;
            display: -webkit-box; -webkit-line-clamp: 2;
            -webkit-box-orient: vertical; overflow: hidden;
        }
        .caymi-price {
            font-family: 'EB Garamond', serif;
            font-size: 1.4rem; font-weight: 400; color: var(--terracotta);
            letter-spacing: 0.02em; margin-bottom: 1.25rem;
        }

        /* Order form inside card */
        .caymi-order-form {
            border-top: 1px solid var(--sand-dark);
            padding-top: 1.25rem;
        }
        .caymi-order-form label {
            display: block;
            font-size: 0.55rem !important; letter-spacing: 0.2em !important;
            text-transform: uppercase !important;
            color: var(--ink-soft) !important; margin-bottom: 0.35rem !important;
        }
        .caymi-order-form input[type="number"],
        .caymi-order-form textarea {
            width: 100% !important;
            background: transparent !important;
            border: none !important; border-bottom: 1px solid var(--sand-dark) !important;
            border-radius: 0 !important; box-shadow: none !important;
            padding: 0.4rem 0 !important;
            font-family: 'Josefin Sans', sans-serif !important;
            font-size: 0.78rem !important; letter-spacing: 0.04em !important;
            color: var(--ink) !important; outline: none !important;
            resize: none; transition: border-color 0.2s;
        }
        .caymi-order-form input[type="number"]:focus,
        .caymi-order-form textarea:focus { border-bottom-color: var(--terracotta) !important; }
        .caymi-order-form textarea::placeholder,
        .caymi-order-form input::placeholder { color: var(--sand-dark) !important; }

        .caymi-order-form .caymi-field-row {
            display: flex; gap: 1rem; margin-bottom: 0;
        }
        .caymi-order-form .caymi-field-qty { max-width: 80px; }

        .caymi-btn-order {
            width: 100% !important;
            margin-top: 1rem !important;
            font-family: 'Josefin Sans', sans-serif !important;
            font-size: 0.6rem !important; letter-spacing: 0.2em !important;
            text-transform: uppercase !important; font-weight: 400 !important;
            padding: 0.75rem 1rem !important;
            background: var(--ink) !important;
            color: var(--sand) !important;
            border: 1px solid var(--ink) !important;
            border-radius: 0 !important; box-shadow: none !important;
            cursor: pointer; transition: all 0.25s ease !important;
        }
        .caymi-btn-order:hover {
            background: var(--terracotta) !important;
            border-color: var(--terracotta) !important;
        }

        /* Empty state */
        .caymi-empty {
            grid-column: 1 / -1;
            text-align: center; padding: 5rem 2rem;
        }
        .caymi-empty p {
            font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--sand-dark);
        }

        /* Pagination */
        .caymi-pagination {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--sand-dark);
        }

        /* Responsive */
        @media (max-width: 1024px) { .caymi-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px)  { .caymi-grid { grid-template-columns: 1fr; } }
    </style>

    {{-- Search bar --}}
    <div class="caymi-search-wrap">
        <form method="GET" action="{{ route('client.catalog') }}">
            <div>
                <input type="text" name="q" value="{{ $query ?? '' }}"
                       placeholder="Busca por descripción, color, categoría...">
                <button type="submit">Buscar</button>
                @if($query ?? false)
                    <a href="{{ route('client.catalog') }}">Limpiar</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="caymi-flash">{{ session('success') }}</div>
    @endif

    {{-- Catalog --}}
    <div class="caymi-catalog">

        <div class="caymi-eyebrow">Colección disponible</div>

        <div class="caymi-grid">
            @forelse($products as $product)
                <div class="caymi-card">

                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                    @else
                        <div class="caymi-no-image"><span>Sin imagen</span></div>
                    @endif

                    <div class="caymi-card-body">
                        <div class="caymi-category">{{ $product->category ?? '—' }}</div>
                        <div class="caymi-product-name">{{ $product->name }}</div>
                        <p class="caymi-product-desc">{{ $product->description }}</p>
                        <div class="caymi-price">${{ number_format($product->price, 2) }}</div>

                        <form method="POST" action="{{ route('client.orders.store') }}" class="caymi-order-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="caymi-field-row">
                                <div class="caymi-field-qty">
                                    <label class="block text-xs text-gray-500 mb-1">Cantidad</label>
                                    <input type="number" name="quantity" value="1"
                                           min="1" max="{{ $product->stock }}">
                                </div>
                                <div style="flex:1">
                                    <label class="block text-xs text-gray-500 mb-1">Personalización (opcional)</label>
                                    <textarea name="customization" rows="2"
                                              placeholder="Ej: color azul, talla XL..."></textarea>
                                </div>
                            </div>

                            <button type="submit" class="caymi-btn-order">Pedir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="caymi-empty"><p>No hay productos disponibles.</p></div>
            @endforelse
        </div>

        <div class="caymi-pagination">
            @if(method_exists($products, 'links'))
                {{ $products->links() }}
            @endif
        </div>

    </div>

</x-app-layout>