<x-main-layout>
    <div class="stack">
        <strong>Удалить магазин<em>"{{ $shop->name }}"</em>?</strong>
        
        <form method="POST" action="{{ route('shops.destroy', ['id' => $shop->id]) }}">
            @csrf
            @method('DELETE')
            
            @if(session('success'))
                <div class="flash-msg">{{ session('success') }}</div>
            @endif
            
            @if($related_lists->isNotEmpty())
                <p>К этому магазину привязаны следующие списки покупок:</p>
                
                <ul class="list list_min-gap">
                    @foreach($related_lists as $list)
                        <li>
                            <a href="{{ route('shopping-lists.show', ['id' => $list->id]) }}">
                                {{ $list->name }}
                            </a>
                            <input type="hidden" name="confirmed_list_ids[]" value="{{ $list->id }}">
                        </li>
                    @endforeach
                </ul>
                <p>Вы точно хотите удалить этот магазин?</p>
            @endif
            <div class="btn-group">
                <button class="btn" type="submit">Удалить</button>
                <a class="btn btn_wire" href="{{ url()->previous() }}">Отмена</a>
            </div>
        </form>
    </div>
</x-main-layout>