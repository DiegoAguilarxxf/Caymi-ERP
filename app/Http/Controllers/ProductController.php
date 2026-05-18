<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Embedding;
use App\Models\SemanticSearchLog;
use App\Services\AIService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private AIService $ai) {}

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150|unique:products',
            'description' => 'required|string',
            'category'    => 'nullable|string|max:100',
            'colors'      => 'nullable|string|max:200',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image_url'   => 'nullable|url',
        ]);

        $product = Product::create($validated);

        // Generar embedding en FastAPI
        try {
            $text = "{$product->name}. {$product->description}. Categoría: {$product->category}. Colores: {$product->colors}";
            $result = $this->ai->generateEmbedding($text, $product->id);
            

            Embedding::create([
    'product_id'       => $product->id,
    'vector_reference' => json_encode($result['embedding'] ?? []),
    'embedding_model'  => $result['model'] ?? 'gemini-embedding-001',
    'embedding'        => '[' . implode(',', $result['embedding'] ?? []) . ']',
]);
        } catch (\Exception $e) {
            // No bloqueamos si falla la IA
            \Log::warning("Embedding no generado para producto {$product->id}: " . $e->getMessage());
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:150|unique:products,name,' . $id,
            'description' => 'required|string',
            'category'    => 'nullable|string|max:100',
            'colors'      => 'nullable|string|max:200',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image_url'   => 'nullable|url',
        ]);

        $product->update($validated);

        // Regenerar embedding al actualizar
        try {
            $text = "{$product->name}. {$product->description}. Categoría: {$product->category}. Colores: {$product->colors}";
            $result = $this->ai->generateEmbedding($text, $product->id);

           Embedding::updateOrCreate(
    ['product_id' => $product->id],
    [
        'vector_reference' => json_encode($result['embedding'] ?? []),
        'embedding_model'  => $result['model'] ?? 'gemini-embedding-001',
        'embedding'        => '[' . implode(',', $result['embedding'] ?? []) . ']',
    ]
);
        } catch (\Exception $e) {
            \Log::warning("Embedding no actualizado para producto {$product->id}: " . $e->getMessage());
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    public function catalog(Request $request)
{
    $query = $request->get('q');

    if ($query) {
        $allProducts = Product::where('stock', '>', 0)->get();

        $candidates = $allProducts->map(fn($p) => [
            'id'          => $p->id,
            'name'        => $p->name,
            'description' => "{$p->name}. {$p->description}. Categoría: {$p->category}. Colores: {$p->colors}",
        ])->toArray();

        try {
            $start = now();
            $result = $this->ai->search($query, $candidates);
            $latency = (int) abs(now()->diffInMilliseconds($start));

            $rankedResults = collect($result['results'] ?? []);
            $ids = $rankedResults->pluck('product_id')->toArray();

            $productsById = Product::whereIn('id', $ids)->get()->keyBy('id');
    $products = collect($ids)
    ->map(fn($id) => $productsById->get($id))
    ->filter()
    ->values();

            SemanticSearchLog::create([
                'user_id'       => auth()->id(),
                'query_text'    => $query,
                'results_count' => $products->count(),
                'latency_ms'    => $latency,
            ]);
            
            return view('products.catalog', compact('products', 'query'));

        } catch (\Exception $e) {
            \Log::warning("Búsqueda semántica falló: " . $e->getMessage());
            
        }
    }

    $products = Product::where('stock', '>', 0)
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    return view('products.catalog', compact('products', 'query'));
}
}