<x-site-layout>
    <div class="stack">
        <div class="btn-group">
            <a class="btn" href="{{ route('shops.edit', ['id' => $shop->id ]) }}">Edit this shop</a>
            <a class="btn btn_wire" href="{{ route('shops.delete', ['id' => $shop->id ]) }}">Remove this shop</a>
            <a class="btn btn_wire" href="{{ route('shops.index') }}">Back to shops</a>
        </div>
        <hr>
        <strong>{{ $shop->name }}</strong>
        
        @if($shop->display_name)
            <p>{{ $shop->display_name }}</p>
        @endif
        
        <hr>
        
        @if($shop->address)
        <dl>
            <dt>Address:</dt>
            <dd>{{ $shop?->address }}</dd>
        </dl>
        @endif
    </div>
</x-site-layout>