<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShoppingList;
use Illuminate\Http\Request;
use App\Models\Item;

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
        $shop = $item->shoppingList->shop;

        return view('items.show', compact('item', 'shop'));
    }

    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {

    }

    public function edit(string $id)
    {

    }


    public function update(Request $request, string $id)
    {

    }

    public function transfer_view(string $id)
    {

    }

    public function transfer(string $id)
    {

    }


    public function delete(string $id)
    {

    }

    public function destroy(string $id)
    {

    }
}
