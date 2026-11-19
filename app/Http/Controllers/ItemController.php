<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShoppingList;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{

    public function index(Request $request)
    {
        $items = Item::where('shopping_list_id', $request->shopping_list_id)->get();
        $list = ShoppingList::with('shop')->findOrFail($request->shopping_list_id);

        $count = $items->count();
        return view('items.index', compact('items', 'list', 'count'));
    }

    public function show(string $id)
    {
        $item = Item::with('shoppingList')->findOrFail($id);
        $list = $item->shoppingList;

        $shop_name = "";

        if ($list->shop) {
            $shop = $list->shop;
            $shop_name = $shop->display_name ?? $shop->name;
        }

        return view('items.show', compact('item', 'list', 'shop_name'));
    }

    public function create(string $shopping_list_id)
    {
        $list = ShoppingList::with('shop')->findOrFail($shopping_list_id);

        $shop_name = "";

        if ($list->shop) {
            $shop = $list->shop;
            $shop_name = $shop->display_name ?? $shop->name;
        }

        return view('items.create', compact('list', 'shop_name'));
    }

    public function store(Request $request, string $shopping_list_id)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'note' => 'nullable|string|max:200',
        ]);

        Item::create([
            'name' => $request->name,
            'note' => $request->notes,
            'shopping_list_id' => $shopping_list_id,
        ]);
        return redirect()->route('items.index', ['shopping_list_id' => $shopping_list_id ])->with('success', 'товар "' . $request->name . '" успешно добавлен');
    }

    public function edit(string $id)
    {
        $item = Item::with('shoppingList')->findOrFail($id);
        $list = $item->shoppingList;

        $shop_name = "";

        if ($list->shop) {
            $shop = $list->shop;
            $shop_name = $shop->display_name ?? $shop->name;
        }

        return view('items.edit', compact('item', 'list', 'shop_name'));
    }


    public function update(Request $request, string $id)
    {
        $item = Item::with('shoppingList')->findOrFail($id);
        $list = $item->shoppingList;


        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'note' => 'nullable|string|max:200',
        ]);

        $item->update([
            'name' => $request->name,
            'note' => $request->notes,
        ]);
        return redirect()->route('items.index', ['shopping_list_id' => $list->id ])->with('success', 'товар "' . $request->name . '" успешно обновлен');
    }

    public function transfer(string $id)
    {
        $item = Item::with('shoppingList')->findOrFail($id);
        $current_list = $item->shoppingList;
        $lists = ShoppingList::with('shop')
            ->where('user_id', auth()->id())
            ->whereNot('id', $current_list->id)
            ->get();

        $shop_name = "";

        if ($current_list->shop) {
            $shop = $current_list->shop;
            $shop_name = $shop->display_name ?? $shop->name;
        }

        return view('items.transfer', compact('item', 'current_list', 'shop_name', 'lists'));
    }

    public function transfer_update(Request $request, string $id)
    {
        $item = Item::with('shoppingList')->findOrFail($id);
        $old_list = $item->shoppingList;

        $request->validate([
            'new_shopping_list_id' => ['required', Rule::exists('shopping_lists', 'id')->where('user_id', auth()->id())],
        ]);

        $new_list = ShoppingList::findOrFail($request->new_shopping_list_id);

        $item->update([
            'shopping_list_id' => $request->new_shopping_list_id,
        ]);

        $sus_msg_text = <<<MSG
товар "{$item->name}"
успешно перенесен из списка "{$old_list->name}"
в список "{$new_list->name}"
MSG;
        return redirect()
            ->route('items.show', ['id' => $item->id ])
            ->with('success', $sus_msg_text );
    }


    public function delete(string $id)
    {
        $item = Item::with('shoppingList')->findOrFail($id);
        $list = $item->shoppingList;

        $shop_name = "";

        if ($list->shop) {
            $shop = $list->shop;
            $shop_name = $shop->display_name ?? $shop->name;
        }

        return view('items.delete', compact('item', 'list', 'shop_name'));
    }

    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item_name = $item->name;
        $list = $item->shoppingList;

        $item->delete();

        return redirect()->route('items.index', ['shopping_list_id' => $list->id ])->with('success', 'товар "' . $item_name . '" успешно удален');
    }
}
