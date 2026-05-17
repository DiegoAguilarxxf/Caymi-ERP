<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Mi Panel
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Mis Pedidos</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ \App\Models\Order::where('user_id', auth()->id())->count() }}
                </p>
                <a href="{{ route('client.orders.index') }}"
                   class="mt-4 inline-block text-sm text-indigo-600 hover:underline">
                    Ver todos →
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Pedidos Pendientes</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ \App\Models\Order::where('user_id', auth()->id())->where('status', 'pending')->count() }}
                </p>
                <a href="{{ route('client.catalog') }}"
                   class="mt-4 inline-block text-sm text-indigo-600 hover:underline">
                    Ver catálogo →
                </a>
            </div>

        </div>
    </div>
</x-app-layout>