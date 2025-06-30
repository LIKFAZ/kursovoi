<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $imagePath = null;
            if ($request->hasFile('image')) {
                // Создаем директорию если её нет
                if (!Storage::disk('public')->exists('categories')) {
                    Storage::disk('public')->makeDirectory('categories');
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('categories', $imageName, 'public');
                
                Log::info('Category image uploaded: ' . $imagePath);
            }
            
            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'image' => $imagePath,
            ]);
            
            return redirect()->route('admin.categories.index')->with('success', 'Категория создана успешно!');
            
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ошибка при создании категории: ' . $e->getMessage());
        }
    }
    
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, Category $category)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $imagePath = $category->image;
            
            if ($request->hasFile('image')) {
                // Удаляем старое изображение
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('categories', $imageName, 'public');
                
                Log::info('Category image updated: ' . $imagePath);
            }
            
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'image' => $imagePath,
            ]);
            
            return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена успешно!');
            
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Ошибка при обновлении категории: ' . $e->getMessage());
        }
    }
    
    public function destroy(Category $category)
    {
        try {
            // Проверяем, есть ли товары в этой категории
            if ($category->products()->count() > 0) {
                return back()->with('error', 'Нельзя удалить категорию, в которой есть товары!');
            }
            
            // Удаляем изображение
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }
            
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Категория удалена успешно!');
            
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return back()->with('error', 'Ошибка при удалении категории: ' . $e->getMessage());
        }
    }
}
