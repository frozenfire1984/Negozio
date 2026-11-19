<x-main-layout>
    <div class="stack">
        <h1 class="page-title">Удалить <em>"{{ $list->name }}"</em>?</h1>
        
        <form method="POST" action="{{ route('shopping-lists.destroy', ['id' => $list->id]) }}">
            @csrf
            @method('DELETE')
            <div class="btn-group">
            <button class="btn" type="submit">Удалить</button>
            <a class="btn btn_wire" href="{{ url()->previous() }}">Отмена</a>
            </div>
        </form>
    </div>
</x-main-layout>