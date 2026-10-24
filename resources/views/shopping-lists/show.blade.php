<x-site-layout>
    <div class="stack">
        <div class="btn-group">
            <a class="btn" href="{{ route('shopping-lists.edit', ['id' => $list->id ]) }}">Edit this list</a>
            <a class="btn btn_wire" href="{{ route('shopping-lists.delete', ['id' => $list->id ]) }}">Remove this list</a>
            <a class="btn btn_wire" href="{{ route('shopping-lists.index') }}">Back to list</a>
        </div>
        <hr>
        <strong>{{ $list->name }}</strong>
        <p>{{ $list?->notes }}</p>
    </div>
</x-site-layout>