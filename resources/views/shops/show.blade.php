<x-site-layout>
    <div class="stack">
        <div class="btn-group">
            <a class="btn" href="{{ route('shops.edit', ['id' => $shop->id ]) }}">Редактировать магазин</a>
            <a class="btn btn_wire" href="{{ route('shops.delete', ['id' => $shop->id ]) }}">Удалить магазин</a>
            <a class="btn btn_wire" href="{{ route('shops.index') }}">Обратно к магазинам</a>
        </div>
        <hr>
        
        <div>
            <strong>{{ $shop->name }}</strong>
            
            @if($shop->display_name)
                <p>{{ $shop->display_name }}</p>
            @endif
        </div>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
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