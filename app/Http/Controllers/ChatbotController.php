<?php

namespace App\Http\Controllers;

use App\Models\ChatbotLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\SemanticSearchLog;
use App\Models\User;
use App\Models\Embedding;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    public function __construct(private AIService $ai) {}

    /*
    |--------------------------------------------------------------------------
    | CLIENT CHAT
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $logs = ChatbotLog::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('client.chat', compact('logs'));
    }

    public function ask(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:500',
        ]);

        $prompt = trim($request->input('prompt'));
        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | USER DATA
        |--------------------------------------------------------------------------
        */

        $totalOrders = Order::where('user_id', $userId)->count();

        $pendingOrders = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $recentOrders = Order::with('product')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        $totalSearches = SemanticSearchLog::where('user_id', $userId)->count();

        $totalProducts = Product::count();

        $avgLatency = SemanticSearchLog::where('user_id', $userId)
            ->avg('latency_ms');

        $recentOrdersText = $recentOrders->map(function ($o) {
            return "- {$o->product->name} (Estado: {$o->status}, Cantidad: {$o->quantity})";
        })->join("\n");

        /*
        |--------------------------------------------------------------------------
        | PRODUCT RETRIEVAL (SMART SEARCH)
        |--------------------------------------------------------------------------
        |
        | Aquí es donde el chatbot obtiene productos REALES.
        | Ya no responderá genérico.
        |
        */

        $relatedProducts = Product::query()
            ->where('name', 'ILIKE', "%{$prompt}%")
            ->orWhere('description', 'ILIKE', "%{$prompt}%")
            ->orWhere('category', 'ILIKE', "%{$prompt}%")
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | FALLBACK SEARCH
        |--------------------------------------------------------------------------
        |
        | Si no encuentra coincidencias exactas,
        | intenta buscar por palabras individuales.
        |
        */

        if ($relatedProducts->isEmpty()) {

            $keywords = collect(explode(' ', strtolower($prompt)))
                ->filter(fn($word) => strlen($word) > 3);

            $query = Product::query();

            foreach ($keywords as $word) {
                $query->orWhere('name', 'ILIKE', "%{$word}%")
                    ->orWhere('description', 'ILIKE', "%{$word}%")
                    ->orWhere('category', 'ILIKE', "%{$word}%");
            }

            $relatedProducts = $query
                ->limit(5)
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | PRODUCT CONTEXT
        |--------------------------------------------------------------------------
        */

        $productContext = $relatedProducts->map(function ($product) {

            return "
- Producto: {$product->name}
  Categoría: {$product->category}
  Descripción: {$product->description}
  Precio: {$product->price}
";

        })->join("\n");

        /*
        |--------------------------------------------------------------------------
        | EMPTY PRODUCTS FALLBACK
        |--------------------------------------------------------------------------
        */

        if (empty(trim($productContext))) {

            $productContext = "
No se encontraron productos exactos relacionados con la consulta.
Si existen productos parcialmente relacionados, puedes sugerirlos.
";
        }

        /*
        |--------------------------------------------------------------------------
        | AI CONTEXT
        |--------------------------------------------------------------------------
        */

        $context = "
Eres un asistente inteligente de Tejidos Caymi,
una tienda de textiles artesanales.

Tu función principal es:
- recomendar productos,
- ayudar al cliente,
- responder preguntas del catálogo,
- sugerir productos relacionados,
- actuar como asesor comercial experto.

IMPORTANTE:
- SOLO puedes recomendar productos existentes.
- NO inventes productos.
- Usa los productos proporcionados en el contexto.
- Si no existe coincidencia exacta,
  recomienda productos similares explicando por qué.
- Responde SIEMPRE en español.
- Sé amable, natural y útil.
- Intenta recomendar productos específicos.

DATOS DEL CLIENTE:
- Total pedidos: {$totalOrders}
- Pedidos pendientes: {$pendingOrders}
- Total búsquedas: {$totalSearches}
- Latencia promedio: " . round($avgLatency ?? 0) . " ms
- Total productos disponibles: {$totalProducts}

ÚLTIMOS PEDIDOS:
{$recentOrdersText}

PRODUCTOS RELACIONADOS:
{$productContext}

PREGUNTA DEL CLIENTE:
{$prompt}
";

        /*
        |--------------------------------------------------------------------------
        | AI REQUEST
        |--------------------------------------------------------------------------
        */

        $start = now();

        try {

            $answer = $this->ai->chat($prompt, $context);

        } catch (\Exception $e) {

            $answer = 'Error al conectar con el asistente inteligente.';
        }

        $latency = (int) abs(now()->diffInMilliseconds($start));

        /*
        |--------------------------------------------------------------------------
        | LOG CHAT
        |--------------------------------------------------------------------------
        */

        ChatbotLog::create([
            'user_id'    => $userId,
            'prompt'     => $prompt,
            'response'   => $answer,
            'latency_ms' => $latency,
        ]);

        return response()->json([
            'answer' => $answer,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN CHAT
    |--------------------------------------------------------------------------
    */

    public function adminIndex()
    {
        $logs = ChatbotLog::orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.chat', compact('logs'));
    }

    public function adminAsk(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:500',
        ]);

        $prompt = trim($request->input('prompt'));

        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | GLOBAL STATS
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();

        $totalClients = User::where('role', 'client')->count();

        $totalOrders = Order::count();

        $pendingOrders = Order::where('status', 'pending')->count();

        $totalSearches = SemanticSearchLog::count();

        $totalVectors = Embedding::count();

        $avgLatency = SemanticSearchLog::avg('latency_ms');

        $totalChatbot = ChatbotLog::count();

        /*
        |--------------------------------------------------------------------------
        | TOP SEARCHES
        |--------------------------------------------------------------------------
        */

        $topSearches = SemanticSearchLog::select(
                'query_text',
                DB::raw('count(*) as total')
            )
            ->groupBy('query_text')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn($s) => "- {$s->query_text} ({$s->total} veces)")
            ->join("\n");

        /*
        |--------------------------------------------------------------------------
        | TOP PRODUCTS
        |--------------------------------------------------------------------------
        */

        $topProducts = Product::limit(5)
            ->get()
            ->map(function ($p) {

                return "- {$p->name} ({$p->category})";

            })->join("\n");

        /*
        |--------------------------------------------------------------------------
        | ADMIN CONTEXT
        |--------------------------------------------------------------------------
        */

        $context = "
Eres un asistente administrativo inteligente de Tejidos Caymi.

Tu función es ayudar al administrador a:
- analizar métricas,
- responder preguntas del sistema,
- identificar tendencias,
- interpretar búsquedas,
- monitorear actividad del catálogo,
- analizar pedidos y productos.

Responde:
- en español,
- de forma profesional,
- clara,
- útil,
- y basada SOLO en los datos proporcionados.

DATOS GLOBALES:
- Total productos: {$totalProducts}
- Total clientes: {$totalClients}
- Total pedidos: {$totalOrders}
- Pedidos pendientes: {$pendingOrders}
- Total búsquedas semánticas: {$totalSearches}
- Vectores almacenados: {$totalVectors}
- Latencia promedio: " . round($avgLatency ?? 0) . " ms
- Total conversaciones chatbot: {$totalChatbot}

TOP BÚSQUEDAS:
{$topSearches}

PRODUCTOS DESTACADOS:
{$topProducts}

PREGUNTA ADMIN:
{$prompt}
";

        /*
        |--------------------------------------------------------------------------
        | AI REQUEST
        |--------------------------------------------------------------------------
        */

        $start = now();

        try {

            $answer = $this->ai->chat($prompt, $context);

        } catch (\Exception $e) {

            $answer = 'Error al conectar con el asistente administrativo.';
        }

        $latency = (int) abs(now()->diffInMilliseconds($start));

        /*
        |--------------------------------------------------------------------------
        | LOG CHAT
        |--------------------------------------------------------------------------
        */

        ChatbotLog::create([
            'user_id'    => $userId,
            'prompt'     => $prompt,
            'response'   => $answer,
            'latency_ms' => $latency,
        ]);

        return response()->json([
            'answer' => $answer,
        ]);
    }
}