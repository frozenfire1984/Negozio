<x-site-layout>
    
    <div class="stack">
    
        <a class="btn" href="{{ route('shopping-lists.create') }}">Create new list</a>
        
        @if(session('success'))
            <div class="flash-msg">{{ session('success') }}</div>
        @endif
        
        <ul class="list">
        @foreach($lists as $list)
            <li class="s-list__item">
                <a class="s-list__link" href="{{ route('shopping-lists.show', ['id' => $list->id]) }}">
                    {{ $list->name }}
                </a>
            </li>
        @endforeach
        </ul>
    
    </div>
</x-site-layout>