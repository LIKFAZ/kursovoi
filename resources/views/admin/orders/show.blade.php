@extends('layouts.app')

@section('title', 'Заказ ' . $order->order_number)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Назад к заказам
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold">Заказ {{ $order->order_number }}</h1>
                <p class="text-gray-600">Оформлен {{ $order->created_at->format('d.m.Y в H:i') }}</p>
            </div>
            
            <!-- Status Update Form -->
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center space-x-2">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Ожидает обработки</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В обработке</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Отправлен</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Доставлен</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменен</option>
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Customer Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Информация о клиенте</h3>
                <div class="space-y-2">
                    <p><strong>Имя:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p><strong>Телефон:</strong> {{ $order->user->phone ?? 'Не указан' }}</p>
                </div>
            </div>

            <!-- Order Details -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Детали заказа</h3>
                <div class="space-y-2">
                    <p><strong>Способ доставки:</strong> 
                        {{ $order->delivery_method == 'delivery' ? 'Доставка курьером' : 'Самовывоз' }}
                    </p>
                    <p><strong>Способ оплаты:</strong> 
                        @switch($order->payment_method)
                            @case('cash') Наличными при получении @break
                            @case('card') Картой при получении @break
                            @case('transfer') Банковский перевод @break
                        @endswitch
                    </p>
                    <p><strong>Адрес доставки:</strong></p>
                    <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $order->shipping_address }}</p>
                    @if($order->notes)
                        <p><strong>Комментарий:</strong></p>
                        <p class="text-gray-700 bg-gray-50 p-3 rounded">{{ $order->notes }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4">Товары в заказе</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center p-4 border border-gray-200 rounded-lg">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                             class="w-16 h-16 object-cover rounded">
                        
                        <div class="flex-1 ml-4">
                            <h4 class="font-semibold">{{ $item->product->name }}</h4>
                            <p class="text-gray-600 text-sm">{{ $item->product->brand }}</p>
                            <p class="text-sm text-gray-600">{{ $item->quantity }} шт. × {{ number_format($item->price, 0, ',', ' ') }} ₽</p>
                        </div>

                        <div class="text-right">
                            <p class="font-semibold">{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} ₽</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="border-t pt-6">
            <div class="flex justify-end">
                <div class="w-64">
                    <div class="flex justify-between mb-2">
                        <span>Товары ({{ $order->items->sum('quantity') }} шт.)</span>
                        <span>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Доставка</span>
                        <span>Бесплатно</span>
                    </div>
                    <div class="border-t pt-2">
                        <div class="flex justify-between font-semibold text-lg">
                            <span>Итого</span>
                            <span>{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
