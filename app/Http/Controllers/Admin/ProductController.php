<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'brand' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            // Создаем директории если их нет
            if (!Storage::disk('public')->exists('products')) {
                Storage::disk('public')->makeDirectory('products');
            }
            
            // Загрузка основного изображения
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                
                Log::info('Image uploaded: ' . $imagePath);
            }
            
            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'stock' => $request->stock,
                'brand' => $request->brand,
                'category_id' => $request->category_id,
                'image' => $imagePath,
                'is_active' => true,
            ]);
            
            Log::info('Product created: ' . $product->id);
            
            return redirect()->route('admin.products.index')->with('success', 'Товар создан успешно!');
            
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ошибка при создании товара: ' . $e->getMessage());
        }
    }
    
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    
    public function update(Request $request, Product $product)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'brand' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $imagePath = $product->image;
            
            // Обновление основного изображения
            if ($request->hasFile('image')) {
                // Удаляем старое изображение
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                
                Log::info('Image updated: ' . $imagePath);
            }
            
            $product->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'stock' => $request->stock,
                'brand' => $request->brand,
                'category_id' => $request->category_id,
                'image' => $imagePath,
            ]);
            
            return redirect()->route('admin.products.index')->with('success', 'Товар обновлен успешно!');
            
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ошибка при обновлении товара: ' . $e->getMessage());
        }
    }
    
    public function destroy(Product $product)
    {
        try {
            // Удаляем изображение при удалении товара
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            $product->delete();
            return redirect()->route('admin.products.index')->with('success', 'Товар удален успешно!');
            
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return back()->with('error', 'Ошибка при удалении товара: ' . $e->getMessage());
        }
    }
}
