<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Mi Panel
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- RESUMEN --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase">Mis Pedidos</p>
                <p class="text-3xl font-bold text-indigo-600">
                    {{ \App\Models\Order::where('user_id', auth()->id())->count() }}
                </p>
                <a href="{{ route('client.orders.index') }}" class="mt-2 inline-block text-xs text-indigo-500 hover:underline">Ver todos →</a>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase">Pendientes</p>
                <p class="text-3xl font-bold text-yellow-600">
                    {{ \App\Models\Order::where('user_id', auth()->id())->where('status', 'pending')->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase">Aprobados</p>
                <p class="text-3xl font-bold text-green-600">
                    {{ \App\Models\Order::where('user_id', auth()->id())->where('status', 'approved')->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase">Mis Búsquedas</p>
                <p class="text-3xl font-bold text-pink-600">
                    {{ \App\Models\SemanticSearchLog::where('user_id', auth()->id())->count() }}
                </p>
            </div>
        </div>

        {{-- MÉTRICAS DE BÚSQUEDA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase">Mis Búsquedas Recientes</h3>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="pb-2">Consulta</th>
                            <th class="pb-2">Resultados</th>
                            <th class="pb-2">Latencia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse(\App\Models\SemanticSearchLog::where('user_id', auth()->id())->orderByDesc('created_at')->limit(5)->get() as $log)
                            <tr>
                                <td class="py-2 text-gray-900 dark:text-gray-100">{{ $log->query_text }}</td>
                                <td class="py-2 text-gray-500">{{ $log->results_count }}</td>
                                <td class="py-2 text-gray-500">{{ $log->latency_ms }} ms</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-2 text-gray-400">Sin búsquedas aún</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase">Mis Últimos Pedidos</h3>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="pb-2">Producto</th>
                            <th class="pb-2">Estado</th>
                            <th class="pb-2">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse(\App\Models\Order::with('product')->where('user_id', auth()->id())->orderByDesc('created_at')->limit(5)->get() as $order)
                            <tr>
                                <td class="py-2 text-gray-900 dark:text-gray-100">{{ $order->product->name ?? '—' }}</td>
                                <td class="py-2">
                                    <span @class([
                                        'px-2 py-1 rounded-full text-xs font-medium',
                                        'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                                        'bg-green-100 text-green-800'  => $order->status === 'approved',
                                        'bg-red-100 text-red-800'      => $order->status === 'rejected',
                                        'bg-blue-100 text-blue-800'    => $order->status === 'completed',
                                    ])>{{ ucfirst($order->status) }}</span>
                                </td>
                                <td class="py-2 text-gray-500">{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-2 text-gray-400">Sin pedidos aún</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        

    </div>
</x-app-layout>