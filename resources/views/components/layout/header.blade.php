<header class="header">
    <div class="container">
        <nav class="nav">
            <ul>
                <li><a href="/" class="{{ request()->routeIs('home') ? 'active' : null }}">Главная</a></li>
                <li><a href="{{ route('shopping-lists.index') }}" class="{{ request()->routeIs('shopping-lists.*') ? 'active' : null }}">Список покупок</a></li>
                <li><a href="{{ route('shops.index') }}" class="{{ request()->routeIs('shops.*') ? 'active' : null }}">Магазины</a></li>
                <li>
                    @auth
                        <a href="{{ route('dashboard') }}" target="_blank">Профиль</a>
                    @else
                        <a href="{{ route('login') }}" target="_blank">Войти</a>
                    @endauth
                </li>
            </ul>
        </nav>
    </div>
</header>