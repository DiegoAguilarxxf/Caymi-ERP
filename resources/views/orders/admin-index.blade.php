<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Gestión de Pedidos
        </h2>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Personalización</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                {{ $order->user->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                {{ $order->product->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                {{ $order->quantity }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $order->customization ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span @class([
                                    'px-2 py-1 rounded-full text-xs font-medium',
                                    'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                                    'bg-green-100 text-green-800'  => $order->status === 'approved',
                                    'bg-red-100 text-red-800'      => $order->status === 'rejected',
                                    'bg-blue-100 text-blue-800'    => $order->status === 'completed',
                                ])>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($order->status === 'pending')
                                    <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <button name="status" value="approved"
                                                class="px-3 py-1 bg-green-600 text-white rounded-md text-xs hover:bg-green-700">
                                            Aprobar
                                        </button>
                                        <button name="status" value="rejected"
                                                class="px-3 py-1 bg-red-600 text-white rounded-md text-xs hover:bg-red-700">
                                            Rechazar
                                        </button>
                                    </form>
                                @elseif($order->status === 'approved')
                                    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button name="status" value="completed"
                                                class="px-3 py-1 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700">
                                            Completar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">Sin acciones</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay pedidos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>