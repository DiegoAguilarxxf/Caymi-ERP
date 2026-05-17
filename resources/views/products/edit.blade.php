<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Editar Producto
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-md">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.update', $product) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                        <textarea name="description" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoría</label>
                            <input type="text" name="category" value="{{ old('category', $product->category) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colores</label>
                            <input type="text" name="colors" value="{{ old('colors', $product->colors) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">URL de imagen</label>
                        <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('admin.products.index') }}"
                       class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>