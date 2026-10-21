<x-site-layout>
    
    <a href="{{ route('shopping-lists.create') }}">Create new list</a>
    
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    
    <ul class="s-list">
    @foreach($lists as $list)
        <li class="s-list__item">
            <a class="s-list__link" href="{{ route('shopping-lists.show', ['id' => $list->id]) }}">
                {{ $list->name }}
            </a>
        </li>
    @endforeach
    </ul>
</x-site-layout>