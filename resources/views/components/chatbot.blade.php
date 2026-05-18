@props(['role' => 'client'])

<!-- Botón flotante -->
<div id="chatbot-container" class="fixed bottom-6 right-6 z-50">
    
    <!-- Botón para abrir -->
    <button id="chatbot-toggle"
            onclick="toggleChatbot()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3z" />
        </svg>
    </button>

    <!-- Panel flotante -->
    <div id="chatbot-panel"
         class="hidden absolute bottom-16 right-0 w-80 bg-white dark:bg-gray-800 shadow-2xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
        
        <!-- Header -->
        <div class="bg-indigo-600 px-4 py-3 flex justify-between items-center">
            <div>
                <p class="text-white font-semibold text-sm">Asistente Tejidos Caymi</p>
                <p class="text-indigo-200 text-xs">Respondo en segundos</p>
            </div>
            <button onclick="toggleChatbot()" class="text-white hover:text-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mensajes -->
        <div id="chatbot-messages" class="h-64 overflow-y-auto p-4 space-y-3 bg-gray-50 dark:bg-gray-900">
            <div class="flex justify-start">
                <div class="bg-white dark:bg-gray-700 rounded-lg px-3 py-2 text-sm text-gray-700 dark:text-gray-200 shadow max-w-xs">
                    ¡Hola! ¿En qué puedo ayudarte hoy?
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <form id="chatbot-form" onsubmit="sendMessage(event)">
                @csrf
                <div class="flex gap-2">
                    <input type="text"
                           id="chatbot-input"
                           placeholder="Escribe tu pregunta..."
                           class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-indigo-500 focus:border-indigo-500"
                           autocomplete="off">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-3 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const chatRoute = '{{ $role === "admin" ? route("admin.chat.ask") : route("client.chat.ask") }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function toggleChatbot() {
        const panel = document.getElementById('chatbot-panel');
        panel.classList.toggle('hidden');
    }

    function addMessage(text, isUser = false) {
        const messages = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        div.className = `flex ${isUser ? 'justify-end' : 'justify-start'}`;
        div.innerHTML = `
            <div class="${isUser 
                ? 'bg-indigo-600 text-white' 
                : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200'} 
                rounded-lg px-3 py-2 text-sm shadow max-w-xs whitespace-pre-line">
                ${text}
            </div>
        `;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function addLoading() {
        const messages = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        div.id = 'loading-msg';
        div.className = 'flex justify-start';
        div.innerHTML = `
            <div class="bg-white dark:bg-gray-700 rounded-lg px-3 py-2 text-sm text-gray-400 shadow">
                Escribiendo...
            </div>
        `;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function removeLoading() {
        const loading = document.getElementById('loading-msg');
        if (loading) loading.remove();
    }

    async function sendMessage(event) {
        event.preventDefault();
        const input = document.getElementById('chatbot-input');
        const prompt = input.value.trim();
        if (!prompt) return;

        addMessage(prompt, true);
        input.value = '';
        addLoading();

        try {
            const response = await fetch(chatRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ prompt }),
            });

            const data = await response.json();
            removeLoading();
            addMessage(data.answer || 'No pude generar una respuesta.');
        } catch (error) {
            removeLoading();
            addMessage('Error de conexión. Intenta de nuevo.');
        }
    }
</script>