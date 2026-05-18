<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Embedding;
use App\Models\SemanticSearchLog;
use App\Models\ChatbotLog;
use App\Models\OperationalLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        // 1. Total registros (productos)
        $totalProducts = Product::count();

        // 2. Total usuarios clientes
        $totalClients = User::where('role', 'client')->count();

        // 3. Pedidos pendientes
        $pendingOrders = Order::where('status', 'pending')->count();

        // 4. Total consultas al agente
        $totalChatbotQueries = ChatbotLog::count();

        // 5. Total búsquedas semánticas
        $totalSearches = SemanticSearchLog::count();

        // 6. Latencia promedio de búsqueda semántica
        $avgSearchLatency = SemanticSearchLog::avg('latency_ms');

        // 7. Vectores almacenados
        $totalVectors = Embedding::count();

        // 8. Registros por cliente
        $ordersByClient = Order::select('user_id', DB::raw('count(*) as total'))
            ->with('user:id,name')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 9. Tasa de éxito de inserción
        $totalOrders = Order::count();
        $successOrders = Order::whereIn('status', ['approved', 'completed'])->count();
        $successRate = $totalOrders > 0 ? round(($successOrders / $totalOrders) * 100, 1) : 0;

        // 10. Tiempo promedio de consulta semántica
        $avgQueryTime = SemanticSearchLog::avg('latency_ms');

        // 11. Últimos pedidos
        $recentOrders = Order::with(['user:id,name', 'product:id,name'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // 12. Logs operacionales recientes
        $recentLogs = OperationalLog::with('user:id,name')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // 13. Búsquedas más frecuentes
        $topSearches = SemanticSearchLog::select('query_text', DB::raw('count(*) as total'))
            ->groupBy('query_text')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalClients',
            'pendingOrders',
            'totalChatbotQueries',
            'totalSearches',
            'avgSearchLatency',
            'totalVectors',
            'ordersByClient',
            'successRate',
            'avgQueryTime',
            'recentOrders',
            'recentLogs',
            'topSearches'
        ));
    }
}