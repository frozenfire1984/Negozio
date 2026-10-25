<x-site-layout>
    <div class="stack">
        <strong>Delete <em>"{{ $shop->name }}"</em>?</strong>
        
        <form method="POST" action="{{ route('shops.destroy', ['id' => $shop->id]) }}">
            @csrf
            @method('DELETE')
            <div class="btn-group">
                <button class="btn" type="submit">Delete</button>
                <a class="btn btn_wire" href="{{ url()->previous() }}">Cancel</a>
            </div>
        </form>
    </div>
</x-site-layout>