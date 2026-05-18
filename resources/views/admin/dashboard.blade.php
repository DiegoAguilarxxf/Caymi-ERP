<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Dashboard Administrador
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- RESUMEN GENERAL --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase">Total Productos</p>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalProducts }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase">Total Clientes</p>
                <p class="text-3xl font-bold text-green-600">{{ $totalClients }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase">Pedidos Pendientes</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $pendingOrders }}</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase">Tasa de Éxito</p>
                <p class="text-3xl font-bold text-blue-600">{{ $successRate }}%</p>
            </div>
        </div>

        {{-- RENDIMIENTO VECTORIAL --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-3">Rendimiento Base Vectorial</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase">Vectores Almacenados</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalVectors }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase">Total Búsquedas</p>
                    <p class="text-3xl font-bold text-pink-600">{{ $totalSearches }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase">Latencia Promedio Búsqueda</p>
                    <p class="text-3xl font-bold text-red-600">{{ round($avgSearchLatency ?? 0) }} ms</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase">Consultas Chatbot</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $totalChatbotQueries }}</p>
                </div>
            </div>
        </div>

        {{-- ACTIVIDAD DE USUARIOS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase">Pedidos por Cliente</h3>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="pb-2">Cliente</th>
                            <th class="pb-2">Pedidos</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($ordersByClient as $row)
                            <tr>
                                <td class="py-2 text-gray-900 dark:text-gray-100">{{ $row->user->name ?? '—' }}</td>
                                <td class="py-2 font-bold text-indigo-600">{{ $row->total }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="py-2 text-gray-400">Sin datos</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase">Top Búsquedas Semánticas</h3>
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="pb-2">Consulta</th>
                            <th class="pb-2">Veces</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($topSearches as $search)
                            <tr>
                                <td class="py-2 text-gray-900 dark:text-gray-100">{{ $search->query_text }}</td>
                                <td class="py-2 font-bold text-pink-600">{{ $search->total }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="py-2 text-gray-400">Sin búsquedas aún</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- ÚLTIMOS PEDIDOS --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase">Últimos Pedidos</h3>
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="pb-2">Cliente</th>
                        <th class="pb-2">Producto</th>
                        <th class="pb-2">Estado</th>
                        <th class="pb-2">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="py-2 text-gray-900 dark:text-gray-100">{{ $order->user->name ?? '—' }}</td>
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
                            <td class="py-2 text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-2 text-gray-400">Sin pedidos</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- LOGS OPERACIONALES --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-5">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3 uppercase">Logs Operacionales Recientes</h3>
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500">
                        <th class="pb-2">Usuario</th>
                        <th class="pb-2">Acción</th>
                        <th class="pb-2">Estado</th>
                        <th class="pb-2">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recentLogs as $log)
                        <tr>
                            <td class="py-2 text-gray-900 dark:text-gray-100">{{ $log->user->name ?? 'Sistema' }}</td>
                            <td class="py-2 text-gray-900 dark:text-gray-100">{{ $log->action }}</td>
                            <td class="py-2">
                                <span @class([
                                    'px-2 py-1 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-800' => $log->status === 'success',
                                    'bg-red-100 text-red-800'     => $log->status === 'error',
                                ])>{{ $log->status }}</span>
                            </td>
                            <td class="py-2 text-gray-500">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-2 text-gray-400">Sin logs</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

   
       

    </div>
</x-app-layout>