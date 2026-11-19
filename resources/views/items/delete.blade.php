<x-main-layout>
    <div class="stack">
        <h1 class="page-title">Удалить <em>"{{ $item->name }}"</em>?</h1>
        
        <form method="POST" action="{{ route('items.destroy', ['id' => $item->id]) }}">
            @csrf
            @method('DELETE')
            <div class="btn-group">
                <button class="btn" type="submit">Удалить товар</button>
                <a class="btn btn_wire" href="{{ url()->previous() }}">Отмена</a>
            </div>
        </form>
        
        <hr>
        
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
