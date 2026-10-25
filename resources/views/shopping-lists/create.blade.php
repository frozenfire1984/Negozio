<x-site-layout>
    <div>
        <form class="form-container" method="POST" action="{{ route('shopping-lists.store') }}">
            <fieldset class="form-fieldset">
                
                <legend class="form-fieldset__title">Новый список покупок</legend>
                
                @csrf
                
                <div class="form-row">
                    <label for="name">Имя</label>
                    <input list="dev-data" class="form-input" type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="off" />
                    
                    @error('name')
                        <div class="form-err">{{ $message }}</div>
                    @enderror
                    
                    <datalist id="dev-data">
                        <option>Список покупок для </option>
                    </datalist>
                </div>
                
                <div class="form-row">
                    <label for="notes">Заметки</label>
                    <textarea class="form-textarea" name="notes" id="notes">{{ old('notes', $list->notes ?? '') }}</textarea>
                    
                    @error('notes')
                        <div class="form-err">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="btn-group">
                    <button class="btn" type="submit">Создать</button>
                    <a class="btn btn_wire" href="{{ url()->previous() }}">Отмена</a>
                </div>
            </fieldset>
        </form>
    </div>
</x-site-layout>