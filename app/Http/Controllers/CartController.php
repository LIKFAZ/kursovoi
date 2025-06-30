<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
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
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    // Изменим метод add, чтобы проверять наличие товара перед добавлением в корзину
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        // Проверяем наличие товара
        if ($product->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Товар отсутствует на складе!',
            ], 400);
        }
        
        $cart = session()->get('cart', []);
        $quantity = $request->quantity ?? 1;
        
        // Проверяем, не превышает ли запрашиваемое количество доступное на складе
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно товара на складе! Доступно: ' . $product->stock . ' шт.',
                ], 400);
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            if ($quantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Недостаточно товара на складе! Доступно: ' . $product->stock . ' шт.',
                ], 400);
            }
            $cart[$product->id] = [
                'quantity' => $quantity,
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Товар добавлен в корзину!',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }
    
    // Изменим метод update, чтобы проверять наличие товара при обновлении корзины
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            // Проверяем наличие товара на складе
            $product = Product::findOrFail($request->product_id);
            if ($request->quantity > $product->stock) {
                return back()->with('error', 'Недостаточно товара на складе! Доступно: ' . $product->stock . ' шт.');
            }
            
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return back()->with('success', 'Корзина обновлена!');
    }
    
    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        
        return back()->with('success', 'Товар удален из корзины!');
    }
}
