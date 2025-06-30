@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Images -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg">
            </div>
        </div>

        <!-- Product Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
            
            <div class="flex items-center mb-4">
                <div class="flex items-center mr-4">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $product->average_rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                    <span class="ml-2 text-gray-600">({{ $product->reviews->count() }} отзывов)</span>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-gray-600 mb-2"><strong>Бренд:</strong> {{ $product->brand }}</p>
                <p class="text-gray-600 mb-2"><strong>Категория:</strong> {{ $product->category->name }}</p>
                <p class="text-gray-600 mb-2">
                    <strong>Наличие:</strong> 
                    @if($product->stock > 0)
                        <span class="text-green-600">{{ $product->stock }} шт.</span>
                    @else
                        <span class="text-red-600">Нет в наличии</span>
                    @endif
                </p>
            </div>

            <div class="mb-6">
                @if($product->sale_price)
                    <div class="flex items-center">
                        <span class="text-3xl font-bold text-red-600">{{ number_format($product->sale_price, 0, ',', ' ') }} ₽</span>
                        <span class="text-xl text-gray-500 line-through ml-4">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm ml-4">
                            Скидка {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                        </span>
                    </div>
                @else
                    <span class="text-3xl font-bold text-gray-900">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                @endif
            </div>

            @if($product->stock > 0)
                <div class="mb-6" x-data="{ quantity: 1 }">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Количество</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center border rounded-lg">
                            <button @click="quantity = Math.max(1, quantity - 1)" 
                                    class="px-3 py-2 text-gray-600 hover:text-gray-800">-</button>
                            <input type="number" x-model="quantity" min="1" max="{{ $product->stock }}"
                                class="w-16 text-center border-0 focus:ring-0">
                            <button @click="quantity = Math.min({{ $product->stock }}, quantity + 1)" 
                                    class="px-3 py-2 text-gray-600 hover:text-gray-800">+</button>
                        </div>
                        <button @click="addToCart({{ $product->id }}, quantity)" 
                                class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                            Добавить в корзину
                        </button>
                    </div>
                </div>
            @else
                <div class="mb-6">
                    <button disabled
                            class="bg-gray-400 text-white px-8 py-3 rounded-lg cursor-not-allowed w-full">
                        Нет в наличии
                    </button>
                    <p class="text-sm text-gray-600 mt-2">Товар временно отсутствует на складе. Пожалуйста, проверьте наличие позже.</p>
                </div>
            @endif

            <!-- Description with toggle -->
            <div class="border-t pt-6" x-data="{ expanded: false }">
                <h3 class="text-lg font-semibold mb-3">Описание</h3>
                <div class="text-gray-700 leading-relaxed">
                    <div x-show="!expanded">
                        <p>{{ $product->short_description }}</p>
                        @if(mb_strlen($product->description) > 150)
                            <button @click="expanded = true" 
                                    class="text-blue-600 hover:text-blue-800 mt-2 font-medium">
                                Показать полное описание
                            </button>
                        @endif
                    </div>
                    <div x-show="expanded" x-transition>
                        <p>{{ $product->description }}</p>
                        @if(mb_strlen($product->description) > 150)
                            <button @click="expanded = false" 
                                    class="text-blue-600 hover:text-blue-800 mt-2 font-medium">
                                Скрыть описание
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-12">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-2xl font-bold mb-6">Отзывы</h3>
            
            @auth
                @if(!$userHasReview)
                    <!-- Add Review Form -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                        <h4 class="text-lg font-semibold mb-4">Оставить отзыв</h4>
                        <form action="{{ route('products.reviews.store', $product) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Рейтинг</label>
                                <div class="flex space-x-1" x-data="{ rating: 5 }">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" @click="rating = {{ $i }}" 
                                                class="text-2xl focus:outline-none"
                                                :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    @endfor
                                    <input type="hidden" name="rating" x-model="rating">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Комментарий</label>
                                <textarea name="comment" rows="4" required
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Поделитесь своим мнением о товаре..."></textarea>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                Отправить отзыв
                            </button>
                        </form>
                    </div>
                @else
                    <!-- User already has review notification -->
                    <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Вы уже оставили отзыв к этому товару. Каждый пользователь может оставить только один отзыв на товар.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Login prompt for guests -->
                <div class="mb-8 p-4 bg-gray-50 rounded-lg text-center">
                    <p class="text-gray-600 mb-4">Чтобы оставить отзыв, необходимо войти в систему</p>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                        Войти
                    </a>
                </div>
            @endauth

            <!-- Reviews List -->
            @if($product->reviews->count() > 0)
                <div class="space-y-6">
                    @foreach($product->reviews as $review)
                        <div class="border-b border-gray-200 pb-6">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <h5 class="font-semibold">{{ $review->user->name }}</h5>
                                    <div class="flex ml-4">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->format('d.m.Y') }}</span>
                            </div>
                            <p class="text-gray-700">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Пока нет отзывов о данном товаре</p>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h3 class="text-2xl font-bold mb-6">Похожие товары</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-semibold mb-2">{{ $relatedProduct->name }}</h4>
                            <p class="text-gray-600 text-sm mb-2">{{ $relatedProduct->brand }}</p>
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($relatedProduct->sale_price)
                                        <span class="text-lg font-bold text-red-600">{{ number_format($relatedProduct->sale_price, 0, ',', ' ') }} ₽</span>
                                        <span class="text-sm text-gray-500 line-through ml-2">{{ number_format($relatedProduct->price, 0, ',', ' ') }} ₽</span>
                                    @else
                                        <span class="text-lg font-bold text-gray-900">{{ number_format($relatedProduct->price, 0, ',', ' ') }} ₽</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 flex space-x-2">
                                <a href="{{ route('products.show', $relatedProduct->slug) }}" 
                                   class="flex-1 bg-gray-200 text-gray-800 px-4 py-2 rounded text-center hover:bg-gray-300 transition duration-300">
                                    Подробнее
                                </a>
                                <button onclick="addToCart({{ $relatedProduct->id }})" 
                                        class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                                    В корзину
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
