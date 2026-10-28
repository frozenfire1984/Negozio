<x-main-layout>
    <div class="stack">
        <a class="btn" href="{{ route('shops.create') }}">Создать магазин</a>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
        @endif

        <ul class="list">
            @forelse($shops as $shop)
                <li class="s-list__item">
                    <a class="s-list__link" href="{{ route('shops.show', ['id' => $shop->id]) }}">
                        {{ $shop->display_name ?? $shop->name }}
                    </a>
                </li>
            @empty
                <li>Список магазинов пуст</li>
            @endforelse
        </ul>
    </div>
</x-main-layout>