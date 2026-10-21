<x-site-layout>
    <div class="s-list-details">
        <a href="{{ route('shopping-lists.edit', ['id' => $list->id ]) }}">Edit this list</a>
        <a href="{{ route('shopping-lists.delete', ['id' => $list->id ]) }}">Remove this list</a>
        
        {{ $list->name }} <br>
        {{ $list?->notes }}
    </div>
</x-site-layout>