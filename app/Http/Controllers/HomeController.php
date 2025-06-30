<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->where('stock', '>', 0)  // Только товары в наличии
            ->latest()
            ->take(8)
            ->get();
        
        $categories = Category::take(6)->get();
        
        return view('home', compact('featuredProducts', 'categories'));
    }
}
