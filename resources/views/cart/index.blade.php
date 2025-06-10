@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Корзина</h1>

    @if(count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    @foreach($cartItems as $item)
                        <div class="flex items-center p-6 border-b border-gray-200">
                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" 
                                 class="w-20 h-20 object-cover rounded-lg">
                            
                            <div class="flex-1 ml-4">
                                <h3 class="font-semibold">{{ $item['product']->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $item['product']->brand }}</p>
                                <p class="text-lg font-bold text-blue-600">
                                    {{ number_format($item['product']->current_price, 0, ',', ' ') }} ₽
                                </p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <!-- Quantity Controls -->
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                    <div class="flex items-center border rounded-lg">
                                        <button type="button" onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] - 1 }})"
                                                class="px-3 py-2 text-gray-600 hover:text-gray-800">-</button>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" 
                                               min="1" max="{{ $item['product']->stock }}"
                                               class="w-16 text-center border-0 focus:ring-0">
                                        <button type="button" onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] + 1 }})"
                                                class="px-3 py-2 text-gray-600 hover:text-gray-800">+</button>
                                    </div>
                                </form>

                                <!-- Subtotal -->
                                <div class="text-right">
                                    <p class="font-semibold">{{ number_format($item['subtotal'], 0, ',', ' ') }} ₽</p>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4">Итого</h3>
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between">
                            <span>Товары ({{ array_sum(array_column($cartItems, 'quantity')) }} шт.)</span>
                            <span>{{ number_format($total, 0, ',', ' ') }} ₽</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Доставка</span>
                            <span>Бесплатно</span>
                        </div>
                        <div class="border-t pt-2">
                            <div class="flex justify-between font-semibold text-lg">
                                <span>Итого</span>
                                <span>{{ number_format($total, 0, ',', ' ') }} ₽</span>
                            </div>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('orders.create') }}" 
                           class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 block text-center">
                            Оформить заказ
                        </a>
                    @else
                        <div class="text-center">
                            <p class="text-gray-600 mb-4">Для оформления заказа необходимо войти в систему</p>
                            <a href="{{ route('login') }}" 
                               class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 block">
                                Войти
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Корзина пуста</h3>
            <p class="text-gray-500 mb-6">Добавьте товары в корзину, чтобы оформить заказ</p>
            <a href="{{ route('products.index') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                Перейти к покупкам
            </a>
        </div>
    @endif
</div>

<script>
function updateQuantity(productId, quantity) {
    if (quantity < 1) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("cart.update") }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    
    const methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'PATCH';
    
    const productIdField = document.createElement('input');
    productIdField.type = 'hidden';
    productIdField.name = 'product_id';
    productIdField.value = productId;
    
    const quantityField = document.createElement('input');
    quantityField.type = 'hidden';
    quantityField.name = 'quantity';
    quantityField.value = quantity;
    
    form.appendChild(csrfToken);
    form.appendChild(methodField);
    form.appendChild(productIdField);
    form.appendChild(quantityField);
    
    document.body.appendChild(form);
    form.submit();
}
</script>
@endsection
