<x-main-layout>
    <h1 class="page-title">Товар <em>"{{ $item->name }}"</em></h1>
    <form class="form-container" method="POST" action="{{ route('items.update', ['id' => $item->id ]) }}">
        @method('PUT')
        @csrf
        <fieldset class="form-fieldset">
            <legend class="form-fieldset__title">Редактировать</legend>
            
            <div>Список: <b>"{{ $list->name }}"</b></div>
            
            @if($shop_name)
                <div>Для похода в магазин <b>"{{ $shop_name }}"</b></div>
            @endif
            
            <div class="form-row">
                <label for="name">Название товара</label>
                <input class="form-input" type="text" name="name" id="name" value="{{ old('name', $item->name ?? '') }}" autocomplete="off" />
                
                @error('name')
                <div class="form-err">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-row">
                <label for="note">Заметки</label>
                <textarea class="form-textarea" name="note" id="note">{{ old('note', $item->note ?? '') }}</textarea>
                
                @error('note')
                    <div class="form-err">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="btn-group">
                <button class="btn" type="submit">Сохранить</button>
                <a class="btn btn_wire" href="{{ url()->previous() }}">Отмена</a>
            </div>
        </fieldset>
    </form>
</x-main-layout>