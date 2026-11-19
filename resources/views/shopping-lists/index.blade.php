<x-main-layout>
    <div class="stack">
        <h1 class="page-title">Списки</h1>
        
        <div class="btn-group">
            <a class="btn" href="{{ route('shopping-lists.create') }}">Создать новый список покупок</a>
        </div>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
        @endif
        
        <ul class="list">
            @forelse($lists as $list)
                <li class="s-list__item">
                    <a class="s-list__link" href="{{ route('shopping-lists.show', ['id' => $list->id]) }}">
                        {{ $list->name }}
                        
                        @if($list->shop)
                           <small>({{ $list->shop?->display_name ?? $list->shop->name }})</small>
                        @endif
                    </a>
                </li>
            @empty
                <li>Нет списков товаров</li>
            @endforelse
        </ul>
    </div>
</x-main-layout>