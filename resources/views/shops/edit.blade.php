<x-site-layout>
    <div>
        <form class="form-container " method="POST" action="{{ route('shops.update', ['id' => $shop->id]) }}">
            @method('PUT')
            
            <fieldset class="form-fieldset">
                
                <legend class="form-fieldset__title">Редактировать магазин</legend>
                
                @csrf
                
                <div class="form-row">
                    <label for="name">Имя</label>
                    <input class="form-input" type="text" name="name" id="name" value="{{ old('name', $shop->name ?? '') }}"  />
                    
                    @error('name')
                    <div class="form-err">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-row">
                    <label for="display_name">Отображаемое имя</label>
                    <input class="form-input" type="text" name="display_name" id="display_name" value="{{ old('display_name', $shop->display_name ?? '') }}" />
                    
                    @error('display_name')
                    <div class="form-err">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-row">
                    <label for="address">Адрес</label>
                    <textarea class="form-textarea" name="address" id="address">{{ old('address', $shop->address ?? '') }}</textarea>
                    
                    @error('address')
                    <div class="form-err">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="btn-group">
                    <button class="btn" type="submit">Сохранить</button>
                    <a class="btn btn_wire" href="{{ route('shops.index') }}">Отмена</a>
                </div>
            </fieldset>
        </form>
    </div>
</x-site-layout>