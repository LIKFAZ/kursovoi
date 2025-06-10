@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Оформление заказа</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Order Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-6">Данные для доставки</h3>
            
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Адрес доставки *</label>
                    <textarea name="shipping_address" rows="3" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Укажите полный адрес доставки">{{ auth()->user()->address }}</textarea>
                    @error('shipping_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Способ доставки *</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="delivery_method" value="delivery" class="mr-2" checked>
                            <span>Доставка курьером (бесплатно)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="delivery_method" value="pickup" class="mr-2">
                            <span>Самовывоз из магазина</span>
                        </label>
                    </div>
                    @error('delivery_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Способ оплаты *</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="cash" class="mr-2" checked>
                            <span>Наличными при получении</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="card" class="mr-2">
                            <span>Картой при получении</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="payment_method" value="transfer" class="mr-2">
                            <span>Банковский перевод</span>
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Комментарий к заказу</label>
                    <textarea name="notes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Дополнительные пожелания или комментарии"></textarea>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                    Подтвердить заказ
                </button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-6">Ваш заказ</h3>
            
            <div class="space-y-4 mb-6">
                @foreach($cartItems as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" 
                                 class="w-12 h-12 object-cover rounded">
                            <div class="ml-3">
                                <h4 class="font-medium">{{ $item['product']->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $item['quantity'] }} шт. × {{ number_format($item['product']->current_price, 0, ',', ' ') }} ₽</p>
                            </div>
                        </div>
                        <span class="font-semibold">{{ number_format($item['subtotal'], 0, ',', ' ') }} ₽</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t pt-4">
                <div class="flex justify-between mb-2">
                    <span>Товары</span>
                    <span>{{ number_format($total, 0, ',', ' ') }} ₽</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Доставка</span>
                    <span>Бесплатно</span>
                </div>
                <div class="flex justify-between font-semibold text-lg border-t pt-2">
                    <span>Итого</span>
                    <span>{{ number_format($total, 0, ',', ' ') }} ₽</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
