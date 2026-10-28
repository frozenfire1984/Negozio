<x-main-layout>
    <div class="stack">
        <div class="btn-group">
            <a class="btn" href="{{ route('shopping-lists.edit', ['id' => $list->id ]) }}">Редактировать список покупок</a>
            <a class="btn btn_wire" href="{{ route('shopping-lists.delete', ['id' => $list->id ]) }}">Удалить список покупок</a>
            <a class="btn btn_wire" href="{{ route('shopping-lists.index') }}">Обратно к спискам покупок</a>
        </div>
        
        <hr>
        
        <strong>{{ $list->name }}</strong>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
        @endif
        
        <hr>
        
        @if($list->shop)
            <dl>
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
    </div>
</x-main-layout>