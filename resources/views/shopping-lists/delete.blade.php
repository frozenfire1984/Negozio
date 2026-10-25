<x-site-layout>
    <div class="stack">
        <strong>Удалить <em>"{{ $list->name }}"</em>?</strong>
        
        <form method="POST" action="{{ route('shopping-lists.destroy', ['id' => $list->id]) }}">
            @csrf
            @method('DELETE')
            <div class="btn-group">
            <button class="btn" type="submit">Удалить</button>
            <a class="btn btn_wire" href="{{ url()->previous() }}">Отмена</a>
            </div>
        </form>
    </div>
</x-site-layout>