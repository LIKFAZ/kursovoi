@extends('layouts.app')

@section('title', 'Главная - Рыболовный магазин')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-6">Добро пожаловать в FishShop</h1>
        <p class="text-xl mb-8">Лучшие рыболовные товары для настоящих рыбаков</p>
        <a href="{{ route('products.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            Перейти в каталог
        </a>
    </div>
</section>

<!-- категории на главной -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="old text-centtext-3xl font-ber mb-12">Популярные категории</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
            <div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-fish text-2xl text-blue-600"></i>
                </div>
                <h3 class="font-semibold mb-2">{{ $category->name }}</h3>
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                   class="text-blue-600 hover:text-blue-800">Смотреть товары</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- реки -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Рекомендуемые товары</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ $product->brand }}</p>
                    <div class="flex items-center justify-between">
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
                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route('products.show', $product->slug) }}" 
                           class="flex-1 bg-gray-200 text-gray-800 px-4 py-2 rounded text-center hover:bg-gray-300 transition duration-300">
                            Подробнее
                        </a>
                        <button onclick="addToCart({{ $product->id }})" 
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                            В корзину
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shipping-fast text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Быстрая доставка</h3>
                <p class="text-gray-600">Доставляем заказы по всей России в кратчайшие сроки</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-medal text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Качественные товары</h3>
                <p class="text-gray-600">Только проверенные бренды и качественная продукция</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Поддержка 24/7</h3>
                <p class="text-gray-600">Наши специалисты всегда готовы помочь вам</p>
            </div>
        </div>
    </div>
</section>
@endsection
    