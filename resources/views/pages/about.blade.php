@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">О нашем магазине</h1>
            <p class="text-xl">Ваш надежный партнер в мире рыбалки</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold mb-6">Наша история</h2>
                <p class="text-gray-700 mb-4">
                    FishShop был основан в 2015 году группой энтузиастов рыбалки, которые хотели создать 
                    место, где каждый рыболов мог бы найти качественное снаряжение по доступным ценам.
                </p>
                <p class="text-gray-700 mb-4">
                    За годы работы мы завоевали доверие тысяч клиентов по всей России, предлагая только 
                    проверенные бренды и качественную продукцию.
                </p>
                <p class="text-gray-700">
                    Сегодня FishShop - это современный интернет-магазин с широким ассортиментом товаров 
                    для рыбалки, быстрой доставкой и профессиональной поддержкой клиентов.
                </p>
            </div>
            <div>
                <img src="/placeholder.svg?height=400&width=600" alt="О нас" 
                     class="w-full h-96 object-cover rounded-lg shadow-lg">
            </div>
        </div>

        <!-- Features -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-award text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Качество</h3>
                <p class="text-gray-600">
                    Мы работаем только с проверенными производителями и гарантируем качество каждого товара.
                </p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shipping-fast text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Быстрая доставка</h3>
                <p class="text-gray-600">
                    Отправляем заказы в день оформления. Доставка по России от 1 до 5 рабочих дней.
                </p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-2xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Поддержка</h3>
                <p class="text-gray-600">
                    Наши консультанты помогут выбрать подходящее снаряжение и ответят на все вопросы.
                </p>
            </div>
        </div>

        <!-- Team -->
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-8">Наша команда</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <img src="/placeholder.svg?height=200&width=200" alt="Алексей Иванов" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <h4 class="text-lg font-semibold">Алексей Иванов</h4>
                    <p class="text-gray-600">Основатель и CEO</p>
                    <p class="text-sm text-gray-500 mt-2">Рыболов с 20-летним стажем</p>
                </div>
                <div class="text-center">
                    <img src="/placeholder.svg?height=200&width=200" alt="Мария Петрова" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <h4 class="text-lg font-semibold">Мария Петрова</h4>
                    <p class="text-gray-600">Менеджер по продажам</p>
                    <p class="text-sm text-gray-500 mt-2">Эксперт по снастям</p>
                </div>
                <div class="text-center">
                    <img src="/placeholder.svg?height=200&width=200" alt="Дмитрий Сидоров" 
                         class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <h4 class="text-lg font-semibold">Дмитрий Сидоров</h4>
                    <p class="text-gray-600">Технический директор</p>
                    <p class="text-sm text-gray-500 mt-2">Разработчик платформы</p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="bg-gray-50 rounded-lg p-8">
            <h2 class="text-3xl font-bold text-center mb-8">Наши достижения</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">5000+</div>
                    <div class="text-gray-600">Довольных клиентов</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">1500+</div>
                    <div class="text-gray-600">Товаров в каталоге</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">50+</div>
                    <div class="text-gray-600">Брендов</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">9</div>
                    <div class="text-gray-600">Лет на рынке</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
