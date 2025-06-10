@extends('layouts.app')

@section('title', 'Мои заказы')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Мои заказы</h1>

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold">Заказ {{ $order->order_number }}</h3>
                            <p class="text-gray-600">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                @switch($order->status)
                                    @case('pending') bg-yellow-100 text-yellow-800 @break
                                    @case('processing') bg-blue-100 text-blue-800 @break
                                    @case('shipped') bg-purple-100 text-purple-800 @break
                                    @case('delivered') bg-green-100 text-green-800 @break
                                    @case('cancelled') bg-red-100 text-red-800 @break
                                @endswitch">
                                @switch($order->status)
                                    @case('pending') Ожидает обработки @break
                                    @case('processing') В обработке @break
                                    @case('shipped') Отправлен @break
                                    @case('delivered') Доставлен @break
                                    @case('cancelled') Отменен @break
                                @endswitch
                            </span>
                            <p class="text-lg font-bold mt-2">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600"><strong>Способ доставки:</strong> 
                                {{ $order->delivery_method == 'delivery' ? 'Доставка курьером' : 'Самовывоз' }}
                            </p>
                            <p class="text-sm text-gray-600"><strong>Способ оплаты:</strong> 
                                @switch($order->payment_method)
                                    @case('cash') Наличными @break
                                    @case('card') Картой @break
                                    @case('transfer') Банковский перевод @break
                                @endswitch
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600"><strong>Товаров:</strong> {{ $order->items->sum('quantity') }} шт.</p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            @foreach($order->items->take(3) as $item)
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                     class="w-12 h-12 object-cover rounded">
                            @endforeach
                            @if($order->items->count() > 3)
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-sm text-gray-600">
                                    +{{ $order->items->count() - 3 }}
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('orders.show', $order) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                            Подробнее
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">У вас пока нет заказов</h3>
            <p class="text-gray-500 mb-6">Оформите первый заказ в нашем магазине</p>
            <a href="{{ route('products.index') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                Перейти к покупкам
            </a>
        </div>
    @endif
</div>
@endsection
