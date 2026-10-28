<x-main-layout>
    <div>
        <form class="form-container" method="POST" action="{{ route('shopping-lists.store') }}">
            @csrf
            <fieldset class="form-fieldset">
                <legend class="form-fieldset__title">Новый список покупок</legend>
                
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
                
                @if($shops->isNotEmpty())
                    <div class="form-row">
                        <label for="shop_id">Магазин</label>
                        
                        <select class="form-input" id="shop_id" name="shop_id">
                            <option value="">Без магазина</option>
                            @foreach($shops as $shop)
                                <option value="{{$shop->id}}" {{ $shop->id == old('shop_id') ? 'selected' : null }}>
                                    {{ $shop->display_name ?? $shop->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        @error('shop_id')
                            <div class="form-err">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
                
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
</x-main-layout>