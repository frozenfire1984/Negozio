<x-main-layout>
    <div class="stack">
        
        <h1 class="page-title">{{ $list->name }}</h1>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
        @endif
        
        @if($list->shop)
            Магазин: {{ $list->shop?->display_name ?? $list->shop->name }}
        @endif
        
        <ul class="list">
            @forelse($items as $item)
                <li class="s-list__item">
                    <a class="s-list__link" href="{{ route('items.show', ['id' => $item->id]) }}">
                        {{ $item->name }}
                    </a>
                </li>
            @empty
                <li>Список покупок пуст</li>
            @endforelse
        </ul>
    </div>
</x-main-layout>