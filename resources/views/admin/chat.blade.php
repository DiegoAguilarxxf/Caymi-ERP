<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Asistente Administrativo
        </h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('answer'))
            <div class="mb-6 space-y-3">
                <div class="bg-indigo-50 dark:bg-indigo-900 rounded-lg p-4">
                    <p class="text-xs text-indigo-400 mb-1">Pregunta:</p>
                    <p class="text-sm text-indigo-800 dark:text-indigo-200">{{ session('question') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                    <p class="text-xs text-gray-400 mb-1">Asistente:</p>
                    <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ session('answer') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <form method="POST" action="{{ route('admin.chat.ask') }}">
                @csrf
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    ¿Qué deseas consultar?
                </label>
                <textarea name="prompt" rows="3"
                          placeholder="Ej: ¿Cuántos pedidos pendientes hay? ¿Qué productos son más buscados?"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">{{ old('prompt') }}</textarea>
                @error('prompt')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <div class="mt-3 flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded-md">
                        Preguntar
                    </button>
                </div>
            </form>
        </div>

        @if($logs->count() > 0)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 uppercase">
                    Historial
                </h3>
                <div class="space-y-4">
                    @foreach($logs as $log)
                        <div class="border-l-4 border-indigo-300 pl-4">
                            <p class="text-xs text-gray-400">{{ $log->created_at->format('d/m/Y H:i') }} — {{ $log->latency_ms }} ms</p>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $log->prompt }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 whitespace-pre-line">{{ $log->response }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>