@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Панель администратора</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Всего заказов</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-box text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Товаров</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Клиентов</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-ruble-sign text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Выручка</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} ₽</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Быстрые действия</h2>
            <div class="space-y-3">
                <a href="{{ route('admin.categories.create') }}" 
                   class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Добавить категорию
                </a>
                <a href="{{ route('admin.products.create') }}" 
                   class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                    <i class="fas fa-plus mr-2"></i>Добавить товар
                </a>
                <a href="{{ route('admin.categories.index') }}" 
                   class="block w-full bg-purple-600 text-white text-center py-2 px-4 rounded-lg hover:bg-purple-700 transition duration-300">
                    <i class="fas fa-list mr-2"></i>Управление категориями
                </a>
                <a href="{{ route('admin.products.index') }}" 
                   class="block w-full bg-gray-600 text-white text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300">
                    <i class="fas fa-box mr-2"></i>Управление товарами
                </a>
                <a href="{{ route('admin.orders.index') }}" 
                   class="block w-full bg-orange-600 text-white text-center py-2 px-4 rounded-lg hover:bg-orange-700 transition duration-300">
                    <i class="fas fa-shopping-cart mr-2"></i>Управление заказами
                </a>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Последние заказы</h2>
            @if($recentOrders->count() > 0)
                <div class="space-y-3">
                    @foreach($recentOrders as $order)
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-semibold">{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
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
                    <a href="{{ route('admin.orders.index') }}" 
                       class="text-blue-600 hover:text-blue-800">
                        Посмотреть все заказы →
                    </a>
                </div>
            @else
                <p class="text-gray-500">Нет заказов</p>
            @endif
        </div>
    </div>
</div>
@endsection
