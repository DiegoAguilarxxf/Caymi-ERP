<?php

namespace App\Http\Controllers;

use App\Models\ChatbotLog;
use App\Models\Order;
use App\Models\Product;
use App\Models\SemanticSearchLog;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    public function __construct(private AIService $ai) {}

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

        $prompt = $request->input('prompt');
        $userId = Auth::id();

        $totalOrders    = Order::where('user_id', $userId)->count();
        $pendingOrders  = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $recentOrders   = Order::with('product')->where('user_id', $userId)->orderByDesc('created_at')->limit(3)->get();
        $totalSearches  = SemanticSearchLog::where('user_id', $userId)->count();
        $totalProducts  = Product::count();
        $avgLatency     = SemanticSearchLog::where('user_id', $userId)->avg('latency_ms');

        $recentOrdersText = $recentOrders->map(fn($o) =>
            "- {$o->product->name} (Estado: {$o->status}, Cantidad: {$o->quantity})"
        )->join("\n");

        $context = "
Eres un asistente de Tejidos Caymi, una tienda de textiles artesanales.
Responde en español, de forma amable y concisa.

Datos del usuario actual:
- Total de pedidos: {$totalOrders}
- Pedidos pendientes: {$pendingOrders}
- Total de búsquedas realizadas: {$totalSearches}
- Latencia promedio de búsqueda: " . round($avgLatency ?? 0) . " ms
- Total de productos disponibles: {$totalProducts}

Últimos pedidos del usuario:
{$recentOrdersText}

Responde la siguiente pregunta del usuario basándote en estos datos.
Si no tienes información suficiente, dilo amablemente.
        ";

        $start = now();

        try {
            $answer = $this->ai->chat($prompt, $context);
        } catch (\Exception $e) {
            $answer = 'Error al conectar con el agente. Intenta de nuevo.';
        }

        $latency = (int) abs(now()->diffInMilliseconds($start));

        ChatbotLog::create([
            'user_id'    => $userId,
            'prompt'     => $prompt,
            'response'   => $answer,
            'latency_ms' => $latency,
        ]);

        return back()->with('answer', $answer)->with('question', $prompt);
    }
    public function adminIndex()
{
    $logs = ChatbotLog::orderByDesc('created_at')->limit(10)->get();
    return view('admin.chat', compact('logs'));
}

public function adminAsk(Request $request)
{
    $request->validate([
        'prompt' => 'required|string|max:500',
    ]);

    $prompt = $request->input('prompt');
    $userId = Auth::id();

    // Contexto admin — datos globales del sistema
    $totalProducts   = Product::count();
    $totalClients    = \App\Models\User::where('role', 'client')->count();
    $totalOrders     = Order::count();
    $pendingOrders   = Order::where('status', 'pending')->count();
    $totalSearches   = SemanticSearchLog::count();
    $totalVectors    = \App\Models\Embedding::count();
    $avgLatency      = SemanticSearchLog::avg('latency_ms');
    $totalChatbot    = ChatbotLog::count();

    $topSearches = SemanticSearchLog::select('query_text', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
        ->groupBy('query_text')
        ->orderByDesc('total')
        ->limit(3)
        ->get()
        ->map(fn($s) => "- {$s->query_text} ({$s->total} veces)")
        ->join("\n");

    $context = "
Eres un asistente administrativo de Tejidos Caymi, una tienda de textiles artesanales.
Responde en español, de forma profesional y concisa.

Datos globales del sistema:
- Total productos: {$totalProducts}
- Total clientes: {$totalClients}
- Total pedidos: {$totalOrders}
- Pedidos pendientes: {$pendingOrders}
- Total búsquedas semánticas: {$totalSearches}
- Vectores almacenados: {$totalVectors}
- Latencia promedio de búsqueda: " . round($avgLatency ?? 0) . " ms
- Total consultas al chatbot: {$totalChatbot}

Top búsquedas:
{$topSearches}

Responde la siguiente pregunta basándote en estos datos.
    ";

    $start = now();

    try {
        $answer = $this->ai->chat($prompt, $context);
    } catch (\Exception $e) {
        $answer = 'Error al conectar con el agente.';
    }

    $latency = (int) abs(now()->diffInMilliseconds($start));

    ChatbotLog::create([
        'user_id'    => $userId,
        'prompt'     => $prompt,
        'response'   => $answer,
        'latency_ms' => $latency,
    ]);

    return back()->with('answer', $answer)->with('question', $prompt);
}
}