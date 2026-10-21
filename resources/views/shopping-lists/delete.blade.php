<x-site-layout>
    <div class="s-list-details">
        Delete {{ $list->name }}?
        
        <form method="POST" action="{{ route('shopping-lists.destroy', ['id' => $list->id]) }}">
            @csrf
            @method('DELETE')
            <button class="btn" type="submit">Delete</button>
            <a href="{{ url()->previous() }}">Cancel</a>
        </form>
    </div>
</x-site-layout>