<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Catálogo de Productos
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <span class="text-gray-400 text-sm">Sin imagen</span>
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $product->category ?? '—' }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ $product->description }}</p>

                        <div class="mt-3 flex justify-between items-center">
                            <span class="font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>
                            <span class="text-xs text-gray-400">Stock: {{ $product->stock }}</span>
                        </div>

                        <form method="POST" action="{{ route('client.orders.store') }}" class="mt-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="mb-2">
                                <label class="block text-xs text-gray-500 mb-1">Cantidad</label>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                       class="w-full rounded-md border-gray-300 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>

                            <div class="mb-3">
                                <label class="block text-xs text-gray-500 mb-1">Personalización (opcional)</label>
                                <textarea name="customization" rows="2" placeholder="Ej: color azul, talla XL..."
                                          class="w-full rounded-md border-gray-300 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                            </div>

                            <button type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm py-2 rounded-md">
                                Pedir
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">No hay productos disponibles.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>