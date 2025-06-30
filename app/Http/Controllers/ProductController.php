<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
        ->where('stock', '>', 0)  // Добавляем проверку наличия товара
        ->with('category');
        
        // Фильтрация по категории
        if ($request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Фильтрация по цене
        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Фильтрация по бренду
        if ($request->brand) {
            $query->where('brand', $request->brand);
        }
        
        // Поиск
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        // Сортировка
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->paginate(12);
        $categories = Category::all();
        $brands = Product::distinct()->pluck('brand')->filter();
        
        return view('products.index', compact('products', 'categories', 'brands'));
    }
    
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'reviews.user'])
            ->firstOrFail();
        
        // Если товара нет в наличии, показываем соответствующее сообщение
        $inStock = $product->stock > 0;
        
        // Проверяем, оставлял ли текущий пользователь отзыв
        $userHasReview = false;
        if (auth()->check()) {
            $userHasReview = $product->reviews()->where('user_id', auth()->id())->exists();
        }
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where('stock', '>', 0)  // Только товары в наличии
            ->take(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts', 'inStock', 'userHasReview'));
    }
    
    public function storeReview(Request $request, Product $product)
    {
        // Проверяем, не оставлял ли пользователь уже отзыв
        $existingReview = Review::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();
            
        if ($existingReview) {
            return back()->with('error', 'Вы уже оставили отзыв к этому товару. Каждый пользователь может оставить только один отзыв на товар.');
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
        
        return back()->with('success', 'Отзыв добавлен успешно!');
    }
}
