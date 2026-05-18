<x-app-layout>
    <x-slot name="header">
        <h2 style="
            font-family: 'EB Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--ink);
            letter-spacing: 0.02em;
        ">
            Nuevo <em style="font-style:italic; color: var(--terracotta);">Producto</em>
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
            max-width: 768px; /* max-w-3xl equivalente */
            margin: 0 auto;
            position: relative; z-index: 10;
            display: flex; flex-direction: column; gap: 2rem;
        }

        /* ── Form Card ── */
        .caymi-form-card {
            background: #faf6f0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            padding: 2.5rem 2rem;
            border-top: 2px solid var(--sand-dark);
        }

        /* ── Alert Error ── */
        .caymi-alert-error {
            background: rgba(168,92,58,0.06);
            border-left: 3px solid var(--terracotta);
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            color: var(--terracotta);
        }
        .caymi-alert-error ul {
            list-style-type: none;
            padding: 0; margin: 0;
            font-size: 0.75rem;
            letter-spacing: 0.03em;
        }

        /* ── Typography & Inputs ── */
        .caymi-form-group {
            margin-bottom: 1.75rem;
        }
        .caymi-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .caymi-label {
            font-size: 0.55rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--ink-soft);
            display: block;
            margin-bottom: 0.5rem;
        }

        .caymi-input, .caymi-textarea {
            width: 100%;
            background: transparent !important;
            border: none !important;
            border-bottom: 1px solid var(--sand-dark) !important;
            border-radius: 0 !important;
            padding: 0.5rem 0;
            font-family: 'Josefin Sans', sans-serif;
            font-size: 0.85rem;
            color: var(--ink) !important;
            box-shadow: none !important;
            transition: border-color 0.2s ease;
        }
        .caymi-input:focus, .caymi-textarea:focus {
            outline: none !important;
            border-bottom-color: var(--teal) !important;
        }

        .caymi-textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* ── Action Buttons ── */
        .caymi-form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 2.5rem;
        }

        .caymi-btn {
            background: transparent;
            font-family: 'Josefin Sans', sans-serif;
            font-size: 0.58rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.6rem 1.2rem;
            cursor: pointer;
            border-radius: 0;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .caymi-btn-cancel {
            border: 1px solid rgba(74,64,53, 0.2);
            color: var(--ink-soft);
        }
        .caymi-btn-cancel:hover {
            background: rgba(74,64,53, 0.05);
            border-color: var(--ink-soft);
        }

        .caymi-btn-save {
            border: 1px solid var(--teal);
            color: #fff8f0;
            background: var(--teal);
        }
        .caymi-btn-save:hover {
            background: transparent;
            color: var(--teal);
        }

        @media (max-width: 640px) {
            .caymi-dashboard { padding: 1.5rem 1.25rem; }
            .caymi-form-row { grid-template-columns: 1fr; gap: 1.75rem; }
            .caymi-form-actions { flex-direction: column-reverse; }
            .caymi-btn { text-align: center; }
        }
    </style>

    <div class="caymi-dashboard">
        <div class="caymi-form-card">

            {{-- VALIDACIONES DE ERRORES --}}
            @if($errors->any())
                <div class="caymi-alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>— {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORMULARIO --}}
            <form method="POST" action="{{ route('admin.products.store') }}">
                @csrf

                <div class="caymi-form-group">
                    <label class="caymi-label">Nombre del Producto</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="caymi-input" required>
                </div>

                <div class="caymi-form-group">
                    <label class="caymi-label">Descripción</label>
                    <textarea name="description" rows="3" class="caymi-textarea">{{ old('description') }}</textarea>
                </div>

                <div class="caymi-form-row caymi-form-group">
                    <div>
                        <label class="caymi-label">Categoría</label>
                        <input type="text" name="category" value="{{ old('category') }}" class="caymi-input">
                    </div>
                    <div>
                        <label class="caymi-label">Colores disponibles</label>
                        <input type="text" name="colors" value="{{ old('colors') }}" class="caymi-input" placeholder="ej. Negro, Blanco, Terracota">
                    </div>
                </div>

                <div class="caymi-form-row caymi-form-group">
                    <div>
                        <label class="caymi-label">Precio ($)</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" class="caymi-input" required>
                    </div>
                    <div>
                        <label class="caymi-label">Stock Inicial</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" min="0" class="caymi-input" required>
                    </div>
                </div>

                <div class="caymi-form-group">
                    <label class="caymi-label">URL de Imagen</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" class="caymi-input">
                </div>

                {{-- ACCIONES --}}
                <div class="caymi-form-actions">
                    <a href="{{ route('admin.products.index') }}" class="caymi-btn caymi-btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="caymi-btn caymi-btn-save">
                        Guardar Producto
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</x-app-layout>