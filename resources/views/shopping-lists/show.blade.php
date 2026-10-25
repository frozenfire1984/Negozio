<x-site-layout>
    <div class="stack">
        <div class="btn-group">
            <a class="btn" href="{{ route('shopping-lists.edit', ['id' => $list->id ]) }}">Редактировать список покупок</a>
            <a class="btn btn_wire" href="{{ route('shopping-lists.delete', ['id' => $list->id ]) }}">Удалить список покупок</a>
            <a class="btn btn_wire" href="{{ route('shopping-lists.index') }}">Обратно к спискам покупок</a>
        </div>
        
        <hr>
        
        <strong>{{ $list->name }}</strong>
        
        <hr>
        
        @if($list->notes)
            <dl>
                <dt>Заметки:</dt>
                <dd>{{ $list->notes }}</dd>
            </dl>
        @endif
    </div>
</x-site-layout>