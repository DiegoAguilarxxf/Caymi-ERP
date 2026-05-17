<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                {{ $product->name }}
            </h2>
            <a href="{{ route('admin.products.index') }}"
               class="text-sm text-indigo-600 hover:underline">← Volver</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">

            @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     class="w-full h-64 object-cover rounded-md">
            @endif

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-500">Categoría</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $product->category ?? '—' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-500">Colores</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $product->colors ?? '—' }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-500">Precio</span>
                    <p class="text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</p>
                </div>
                <div>
                    <span class="font-medium text-gray-500">Stock</span>
                    <p class="text-gray-900 dark:text-gray-100">{{ $product->stock }}</p>
                </div>
            </div>

            <div>
                <span class="font-medium text-gray-500 text-sm">Descripción</span>
                <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $product->description }}</p>
            </div>

            <div class="flex gap-3 pt-4">
                <a href="{{ route('admin.products.edit', $product) }}"
                   class="px-4 py-2 text-sm text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                    Editar
                </a>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                      onsubmit="return confirm('¿Eliminar este producto?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-red-600 rounded-md hover:bg-red-700">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>