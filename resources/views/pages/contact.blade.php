@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-4">Свяжитесь с нами</h1>
            <p class="text-xl">Мы всегда готовы помочь вам</p>
        </div>
    </div>

    <!-- Contact Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-2xl font-bold mb-6">Отправить сообщение</h2>
                
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Имя *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Тема *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Сообщение *</label>
                        <textarea name="message" rows="6" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300">
                        Отправить сообщение
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div>
                <h2 class="text-2xl font-bold mb-6">Контактная информация</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-map-marker-alt text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1">Адрес</h3>
                            <p class="text-gray-600">г. Москва, ул. Рыбацкая, д. 123, офис 45</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-phone text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1">Телефон</h3>
                            <p class="text-gray-600">+7 (999) 123-45-67</p>
                            <p class="text-gray-600">+7 (999) 765-43-21</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-envelope text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1">Email</h3>
                            <p class="text-gray-600">info@fishstore.ru</p>
                            <p class="text-gray-600">support@fishstore.ru</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-1">Время работы</h3>
                            <p class="text-gray-600">Пн-Пт: 9:00 - 18:00</p>
                            <p class="text-gray-600">Сб-Вс: 10:00 - 16:00</p>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="mt-8">
                    <h3 class="font-semibold mb-4">Мы в социальных сетях</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition duration-300">
                            <i class="fab fa-vk"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-500 text-white rounded-lg flex items-center justify-center hover:bg-blue-600 transition duration-300">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-red-600 text-white rounded-lg flex items-center justify-center hover:bg-red-700 transition duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-600 text-white rounded-lg flex items-center justify-center hover:bg-pink-700 transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Map -->
                <div class="mt-8">
                    <h3 class="font-semibold mb-4">Как нас найти</h3>
                    <div class="bg-gray-200 h-64 rounded-lg flex items-center justify-center">
                        <p class="text-gray-600">Здесь будет карта</p>
                        <!-- Здесь можно интегрировать Яндекс.Карты или Google Maps -->
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-center mb-8">Часто задаваемые вопросы</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="font-semibold mb-2">Как оформить заказ?</h3>
                    <p class="text-gray-600">Добавьте товары в корзину, перейдите к оформлению заказа, заполните данные и выберите способ доставки и оплаты.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Какие способы оплаты доступны?</h3>
                    <p class="text-gray-600">Мы принимаем оплату наличными при получении, банковскими картами и банковским переводом.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Сколько стоит доставка?</h3>
                    <p class="text-gray-600">Доставка по Москве бесплатная при заказе от 3000 рублей. По России - от 300 рублей в зависимости от региона.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Можно ли вернуть товар?</h3>
                    <p class="text-gray-600">Да, вы можете вернуть товар в течение 14 дней с момента получения, если он не был в употреблении.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
