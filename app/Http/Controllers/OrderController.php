<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Cliente: ver sus pedidos
    public function index()
    {
        $orders = Order::with('product')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.client-index', compact('orders'));
    }

    // Cliente: crear pedido
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'    => 'required|uuid|exists:products,id',
            'quantity'      => 'required|integer|min:1',
            'customization' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Stock insuficiente. Disponible: ' . $product->stock]);
        }

        Order::create([
            'user_id'       => Auth::id(),
            'product_id'    => $validated['product_id'],
            'quantity'      => $validated['quantity'],
            'customization' => $validated['customization'] ?? null,
            'status'        => 'pending',
        ]);

        return redirect()->route('client.orders.index')
            ->with('success', 'Pedido creado correctamente.');
    }

    // Admin: ver todos los pedidos
    public function adminIndex()
    {
        $orders = Order::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.admin-index', compact('orders'));
    }

    // Admin: aprobar o rechazar
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,completed',
        ]);

        $order->update([
            'status'   => $validated['status'],
            'admin_id' => Auth::id(),
        ]);

        return back()->with('success', 'Pedido actualizado.');
    }
}