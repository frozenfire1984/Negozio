<x-site-layout>
    <div class="stack">
        <strong>Удалить <em>"{{ $shop->name }}"</em>?</strong>
        
        <form method="POST" action="{{ route('shops.destroy', ['id' => $shop->id]) }}">
            @csrf
            @method('DELETE')
            <div class="btn-group">
                <button class="btn" type="submit">Удалить</button>
                <a class="btn btn_wire" href="{{ url()->previous() }}">Отмена</a>
            </div>
        </form>
    </div>
</x-site-layout>