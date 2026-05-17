<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
                Dashboard Admin
            </h2>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md transition">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Total Productos</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ \App\Models\Product::count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Pedidos Pendientes</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ \App\Models\Order::where('status', 'pending')->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <p class="text-sm text-gray-500">Total Clientes</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ \App\Models\User::where('role', 'client')->count() }}
                </p>
            </div>
        </div>
</x-app-layout>