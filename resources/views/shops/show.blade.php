<x-site-layout>
    <div class="stack">
        <div class="btn-group">
            <a class="btn" href="{{ route('shops.edit', ['id' => $shop->id ]) }}">Редактировать магазин</a>
            <a class="btn btn_wire" href="{{ route('shops.delete', ['id' => $shop->id ]) }}">Удалить магазин</a>
            <a class="btn btn_wire" href="{{ route('shops.index') }}">Обратно к магазинам</a>
        </div>
        <hr>
        <strong>{{ $shop->name }}</strong>
        
        @if($shop->display_name)
            <p>{{ $shop->display_name }}</p>
        @endif
        
        <hr>
        
        @if($shop->address)
            <dl>
                <dt>Адрес:</dt>
                <dd>{{ $shop?->address }}</dd>
            </dl>
        @endif
    </div>
</x-site-layout>