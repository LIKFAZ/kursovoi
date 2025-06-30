@extends('layouts.app')

@section('title', 'Каталог товаров')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- фильтры -->
        <div class="lg:w-1/4">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Фильтры</h3>
                
                <form method="GET" action="{{ route('products.index') }}">
                    <!-- Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Поиск</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Название товара...">
                    </div>

                    <!-- категории -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Категория</label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Все категории</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- бренд -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Бренд</label>
                        <select name="brand" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Все бренды</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- цена -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Цена</label>
                        <div class="flex space-x-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="От">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                   class="w-1/2 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="До">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Сортировка</label>
                        <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">По умолчанию</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена: по возрастанию</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена: по убыванию</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>По названию</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300">
                        Применить фильтры
                    </button>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="lg:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Каталог товаров</h1>
                <p class="text-gray-600">Найдено: {{ $products->total() }} товаров</p>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $product->brand }}</p>
                            <p class="text-gray-600 text-sm mb-2">{{ $product->category->name }}</p>
                            
                            <!-- Short description -->
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $product->short_description }}</p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    @if($product->sale_price)
                                        <span class="text-lg font-bold text-red-600">{{ number_format($product->sale_price, 0, ',', ' ') }} ₽</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                                    @endif
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="text-sm text-gray-600 ml-1">{{ number_format($product->average_rating, 1) }}</span>
                                </div>
                            </div>

                            <div class="flex space-x-2">
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   class="flex-1 bg-gray-200 text-gray-800 px-4 py-2 rounded text-center hover:bg-gray-300 transition duration-300">
                                    Подробнее
                                </a>
                                @if($product->stock > 0)
                                    <button onclick="addToCart({{ $product->id }})" 
                                            class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                        В корзину
                                    </button>
                                @else
                                    <button disabled
                                            class="flex-1 bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed">
                                        Нет в наличии
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Товары не найдены</h3>
                    <p class="text-gray-500">Попробуйте изменить параметры поиска</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
