<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('items.product')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }
    
    public function show(Order $order)
    {
        // Проверяем, что пользователь может просматривать этот заказ
        if (auth()->user()->id !== $order->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }
        
        return view('orders.show', compact('order'));
    }
    
    public function create()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста!');
        }
        
        $cartItems = [];
        $total = 0;
        
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $product->current_price * $details['quantity']
                ];
                $total += $product->current_price * $details['quantity'];
            }
        }
        
        return view('orders.create', compact('cartItems', 'total'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cash,card,transfer',
            'delivery_method' => 'required|in:pickup,delivery',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста!');
        }
        
        $total = 0;
        $orderItems = [];
        
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product && $product->stock >= $details['quantity']) {
                $subtotal = $product->current_price * $details['quantity'];
                $total += $subtotal;
                
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $details['quantity'],
                    'price' => $product->current_price,
                ];
                
                // Уменьшаем количество товара на складе
                $product->decrement('stock', $details['quantity']);
            }
        }
        
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'total_amount' => $total,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'delivery_method' => $request->delivery_method,
            'notes' => $request->notes,
        ]);
        
        foreach ($orderItems as $item) {
            $order->items()->create($item);
        }
        
        // Очищаем корзину
        session()->forget('cart');
        
        return redirect()->route('orders.show', $order)->with('success', 'Заказ успешно оформлен!');
    }
}
