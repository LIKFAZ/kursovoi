@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Мой профиль</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Profile Navigation -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="font-semibold">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ auth()->user()->email }}</p>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('profile.show') }}" 
                           class="block px-4 py-2 text-blue-600 bg-blue-50 rounded-lg">
                            <i class="fas fa-user mr-2"></i>Профиль
                        </a>
                        <a href="{{ route('orders.index') }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg">
                            <i class="fas fa-shopping-bag mr-2"></i>Мои заказы
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg">
                            <i class="fas fa-edit mr-2"></i>Редактировать
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-6">Личная информация</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Имя</label>
                            <p class="mt-1 text-gray-900">{{ auth()->user()->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-gray-900">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Телефон</label>
                            <p class="mt-1 text-gray-900">{{ auth()->user()->phone ?? 'Не указан' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Адрес</label>
                            <p class="mt-1 text-gray-900">{{ auth()->user()->address ?? 'Не указан' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Дата регистрации</label>
                            <p class="mt-1 text-gray-900">{{ auth()->user()->created_at->format('d.m.Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('profile.edit') }}" 
                           class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                            Редактировать профиль
                        </a>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h2 class="text-xl font-semibold mb-6">Последние заказы</h2>
                    
                    @php
                        $recentOrders = auth()->user()->orders()->latest()->take(3)->get();
                    @endphp

                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg">
                                    <div>
                                        <h4 class="font-semibold">{{ $order->order_number }}</h4>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d.m.Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</p>
                                        <span class="inline-block px-2 py-1 rounded text-xs
                                            @switch($order->status)
                                                @case('pending') bg-yellow-100 text-yellow-800 @break
                                                @case('processing') bg-blue-100 text-blue-800 @break
                                                @case('shipped') bg-purple-100 text-purple-800 @break
                                                @case('delivered') bg-green-100 text-green-800 @break
                                                @case('cancelled') bg-red-100 text-red-800 @break
                                            @endswitch">
                                            @switch($order->status)
                                                @case('pending') Ожидает @break
                                                @case('processing') В обработке @break
                                                @case('shipped') Отправлен @break
                                                @case('delivered') Доставлен @break
                                                @case('cancelled') Отменен @break
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('orders.index') }}" 
                               class="text-blue-600 hover:text-blue-800">
                                Посмотреть все заказы →
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500">У вас пока нет заказов</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
