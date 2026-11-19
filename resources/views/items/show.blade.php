<x-main-layout>
    <div class="stack">
        <h1 class="page-title">Товар <em>"{{ $item->name }}"</em></h1>
        
        <div class="btn-group">
            <a class="btn" href="{{ route('items.edit', ['id' => $item->id ]) }}">Редактировать товар</a>
            <a class="btn" href="{{ route('items.transfer', ['id' => $item->id ]) }}">Перенести в другой список</a>
            <a class="btn btn_wire" href="{{ route('items.delete', ['id' => $item->id ]) }}">Удалить товар</a>
            {{--<a class="btn btn_wire" href="{{ route('items.index') }}">Обратно в список товаров</a>--}}
        </div>
        
        <hr>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
        @endif
        
        @if($item->note)
            <dl class="dl-flex">
                <dt>Заметки:</dt>
                <dd>{{ $item->note }}</dd>
            </dl>
        @endif
        
        @if($list)
            <dl class="dl-flex">
                <dt>Список:</dt>
                <dd>{{ $list->name }}</dd>
            </dl>
        @endif
        
        @if($shop_name)
            <dl class="dl-flex">
                <dt>Магазин:</dt>
                <dd>{{ $shop_name }}</dd>
            </dl>
        @endif
    </div>
</x-main-layout>