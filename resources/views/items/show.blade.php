<x-main-layout>
    <div class="stack">
        <div class="btn-group">
            <a class="btn" href="{{ route('items.edit', ['id' => $item->id ]) }}">Редактировать товар</a>
            <a class="btn btn_wire" href="{{ route('items.delete', ['id' => $item->id ]) }}">Удалить товар</a>
            {{--<a class="btn btn_wire" href="{{ route('items.index') }}">Обратно в список товаров</a>--}}
        </div>
        
        <hr>
        
        <h1 class="page-title">{{ $item->name }}</h1>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
        @endif
        
       
        
        @if($item->notes)
            <dl>
                <dt>Заметки:</dt>
                <dd>{{ $item->note }}</dd>
            </dl>
        @endif
        
        @if($item->shoppingList)
            <dl>
                <dt>Список:</dt>
                <dd>{{ $item->shoppingList->name }}</dd>
            </dl>
        @endif
        
        @if($shop)
            <dl>
                <dt>Магазин:</dt>
                <dd>{{ $shop->display_name ?? $shop->name }}</dd>
            </dl>
        @endif
    </div>
</x-main-layout>