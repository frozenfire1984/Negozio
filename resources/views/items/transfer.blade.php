<x-main-layout>
    <h1 class="page-title">Товар <b>"{{ $item->name }}"</b></h1>
    <form class="form-container" method="POST" action="{{ route('items.transfer_update', ['id' => $item->id ]) }}">
        @method('PUT')
        @csrf
        <fieldset class="form-fieldset">
            <legend class="form-fieldset__title">Перенести в другой список</legend>
            
            <div>Текущий список: <b>"{{ $current_list->name }}"</b></div>
            
            @if($shop_name)
                <div>Для похода в магазин <b>"{{ $shop_name }}"</b></div>
            @endif
            
            <div class="form-row">
                <label for="new_shopping_list_id">Перенести в список:</label>
                <select class="form-input" id="new_shopping_list_id" name="new_shopping_list_id">
                    <option value="" selected>Выбрать</option>
                    @foreach($lists as $list)
                        <option value="{{$list->id}}">
                            {{ $list->name }}
                        </option>
                    @endforeach
                </select>
                
                @error('new_shopping_list_id')
                    <div class="form-err">{{ $message }}</div>
                @enderror
                
                @error('old_shopping_list_id')
                    <div class="form-err">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="btn-group">
                <button class="btn" type="submit">Перенести</button>
                <a class="btn btn_wire" href="{{ url()->previous() }}">Отмена</a>
            </div>
        </fieldset>
    </form>
</x-main-layout>