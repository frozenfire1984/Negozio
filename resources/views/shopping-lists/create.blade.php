<x-site-layout>
    <div>
        <form class="s-list-form" method="POST" action="{{ route('shopping-lists.store') }}">
            <fieldset class="s-list-fieldset">
                
                <legend class="s-list-fieldset__title">New Item</legend>
                
                @csrf
                
                <div>
                    <label for="name">Имя</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}">
                    
                    @error('name')
                        <div class="form-err">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label for="notes">Заметки</label>
                    <textarea name="notes" id="notes">{{ old('notes', $list->notes ?? '') }}</textarea>
                    
                    @error('notes')
                        <div class="form-err">{{ $message }}</div>
                    @enderror
                </div>
                
                <button class="btn" type="submit">Create new</button>
            </fieldset>
        </form>
    </div>
</x-site-layout>