<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Рыболовный магазин')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <!-- лого -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                        <i class="fas fa-fish mr-2"></i>
                        FishShop
                    </a>
                </div>

                <!-- навигация -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">Главная</a>
                    <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('products.*') ? 'text-blue-600 font-semibold' : '' }}">Каталог</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('about') ? 'text-blue-600 font-semibold' : '' }}">О нас</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 {{ request()->routeIs('contact') ? 'text-blue-600 font-semibold' : '' }}">Контакты</a>
                </nav>

                
                <div class="flex items-center space-x-4">
                    <!-- поиск -->
                    <form action="{{ route('products.index') }}" method="GET" class="hidden md:block">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Поиск товаров..." 
                                   class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ request('search') }}">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </form>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-blue-600">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                        </span>
                    </a>

                    <!-- User Menu -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600">
                                <i class="fas fa-user mr-1"></i>
                                {{ Auth::user()->name }}
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Профиль
                                </a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Мои заказы
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Админ панель
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Выйти
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Войти</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Регистрация
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 mx-4 mt-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 mx-4 mt-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">FishShop</h3>
                    <p class="text-gray-300">Лучший магазин рыболовных товаров с широким ассортиментом и доступными ценами.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Каталог</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="{{ route('products.index', ['category' => 'udocki']) }}" class="hover:text-white">Удочки</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'katuski']) }}" class="hover:text-white">Катушки</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'snasti']) }}" class="hover:text-white">Снасти</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'leski']) }}" class="hover:text-white">Лески</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Информация</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="{{ route('about') }}" class="hover:text-white">О нас</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white">Контакты</a></li>
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="hover:text-white">Мои заказы</a></li>
                            <li><a href="{{ route('profile.show') }}" class="hover:text-white">Профиль</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-white">Вход</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white">Регистрация</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Контакты</h3>
                    <div class="space-y-2 text-gray-300">
                        <p><i class="fas fa-phone mr-2"></i> +7 (999) 123-45-67</p>
                        <p><i class="fas fa-envelope mr-2"></i> info@fishstore.ru</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i> г. Москва, ул. Рыбацкая, 123</p>
                        <div class="flex space-x-3 mt-4">
                            <a href="#" class="text-gray-300 hover:text-white" title="ВКонтакте">
                                <i class="fab fa-vk text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white" title="Telegram">
                                <i class="fab fa-telegram text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white" title="YouTube">
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white" title="Instagram">
                                <i class="fab fa-instagram text-xl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2024 FishShop. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <!-- Обновим функцию addToCart в JavaScript для обработки ошибок -->
<script>
    // CSRF token для AJAX запросов
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}'
    };

    // Функция добавления товара в корзину
    function addToCart(productId, quantity = 1) {
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Произошла ошибка при добавлении товара в корзину');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('cart-count').textContent = data.cart_count;
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message);
        });
    }
</script>
    @stack('scripts')
</body>
</html>
