<x-main-layout>
    <div class="stack">
        
        <h1 class="page-title">Список <em>"{{ $list->name }}"</em></h1>
        
        <div class="btn-group">
            <a class="btn btn_wire" href="{{ route('shopping-lists.index') }}">← Обратно к спискам покупок</a>
            <a class="btn" href="{{ route('shopping-lists.edit', ['id' => $list->id ]) }}">Редактировать список покупок</a>
            <a class="btn" href="{{ route('items.index', ['shopping_list_id' => $list->id ]) }}">Показать все товары</a>
            <a class="btn btn_wire" href="{{ route('shopping-lists.delete', ['id' => $list->id ]) }}">Удалить список покупок</a>
            
        </div>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
        @endif
        
        <hr>
        
        @if($list->shop)
            <dl class="dl-flex">
                <dt>Магазин:</dt>
                <dd>{{ $list->shop->display_name ?? $list->shop->name }}</dd>
            </dl>
        @endif
        
        @if($list->notes)
            <dl>
                <dt>Заметки:</dt>
                <dd>{{ $list->notes }}</dd>
            </dl>
        @endif
        
        <hr>
        
        <section>
            <h2 class="page-sub-title">Последние добавленные товары:</h2>
            
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
        </section>
    </div>
</x-main-layout>