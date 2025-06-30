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
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Имя *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Тема *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('subject') border-red-500 @enderror">
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Сообщение *</label>
                        <textarea name="message" rows="6" required
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
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
                            <p class="text-gray-600">{{ $mapData['address'] }}</p>
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
                        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="w-10 h-10 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition duration-300">
                            <i class="fab fa-vk"></i>
                        </a>
                        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="w-10 h-10 bg-blue-500 text-white rounded-lg flex items-center justify-center hover:bg-blue-600 transition duration-300">
                            <i class="fab fa-telegram"></i>
                        </a>
                        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="w-10 h-10 bg-red-600 text-white rounded-lg flex items-center justify-center hover:bg-red-700 transition duration-300">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="w-10 h-10 bg-pink-600 text-white rounded-lg flex items-center justify-center hover:bg-pink-700 transition duration-300">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Map -->
                <div class="mt-8">
                    <h3 class="font-semibold mb-4">Как нас найти</h3>
                    <div class="h-64 rounded-lg overflow-hidden shadow-md">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2244.7!2d37.6173!3d55.7558!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b54a50b315e573%3A0xa886bf5a3d9b2e68!2z0KDQtdC00L3QsNGPINC_0LvQvtGJ0LDQtNGMLCDQnNC-0YHQutCy0LAsINCg0L7RgdGB0LjRjw!5e0!3m2!1sru!2sru!4v1234567890123!5m2!1sru!2sru"
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
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
