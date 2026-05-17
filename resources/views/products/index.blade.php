<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Productos
            </h2>
            <a href="{{ route('admin.products.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                + Nuevo Producto
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $product->category ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $product->stock }}</td>
                            <td class="px-6 py-4 text-sm flex gap-3">
                                <a href="{{ route('admin.products.show', $product) }}"
                                   class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                      onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay productos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>