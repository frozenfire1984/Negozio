<x-site-layout>
    <div class="stack">
        <a class="btn" href="{{ route('shopping-lists.create') }}">Создать новый список покупок</a>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
        @endif
        
        <ul class="list">
            @forelse($lists as $list)
                <li class="s-list__item">
                    <a class="s-list__link" href="{{ route('shopping-lists.show', ['id' => $list->id]) }}">
                        {{ $list->name }}
                    </a>
                </li>
            @empty
                <li>Список покупок пуст</li>
            @endforelse
        </ul>
    </div>
</x-site-layout>