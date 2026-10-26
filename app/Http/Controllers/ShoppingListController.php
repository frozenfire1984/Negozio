<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;
use App\Models\Shop;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ShoppingListController extends Controller
{
    public function index()
    {
        $lists = ShoppingList::with('shop')->where('user_id', auth()->id())->get();

        $count = $lists->count();
        return view('shopping-lists.index', compact('lists', 'count'));
    }

    public function show(string $id)
    {
        $list = ShoppingList::findOrFail($id);

        Gate::authorize('show', $list);

        return view('shopping-lists.show', compact('list'));
    }


    public function create()
    {
        $shops = Shop::where('user_id', auth()->id())->get();

        return view('shopping-lists.create', compact('shops'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'notes' => 'nullable|string|max:200',
            'shop_id' => ['nullable', Rule::exists('shops', 'id')->where('user_id', auth()->id())],
            //'shop_id' => ['nullable', Rule::exists('shops', 'id')]
        ]);

        ShoppingList::create([
            'name' => $request->name,
            'notes' => $request->notes,
            'user_id' => auth()->id(),
            'shop_id' => $request->shop_id,
        ]);
        return redirect()->route('shopping-lists.index')->with('success', 'Список покупок "' . $request->name . '" успешно добавлен');
    }

    public function edit(string $id)
    {
        $list = ShoppingList::findOrFail($id);

        Gate::authorize('update', $list);

        $shops = Shop::where('user_id', auth()->id())->get();

        return view('shopping-lists.edit', compact('list', 'shops'));
    }


    public function update(Request $request, string $id)
    {
        $list = ShoppingList::findOrFail($id);

        Gate::authorize('update', $list);

        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'notes' => 'nullable|string|max:200',
            'shop_id' => ['nullable', Rule::exists('shops', 'id')->where('user_id', auth()->id())],
            //'shop_id' => ['nullable', Rule::exists('shops', 'id')]
        ]);

        $list->update([
            'name' => $request->name,
            'notes' => $request->notes,
            'shop_id' => $request->shop_id
        ]);
        return redirect()->route('shopping-lists.show', $list->id)->with('success', 'Список покупок "' . $request->name . '" успешно обновлен');
    }


    public function delete(string $id)
    {
        $list = ShoppingList::findOrFail($id);

        Gate::authorize('delete', $list);

        return view('shopping-lists.delete', [
            'list' => $list,
        ]);
    }

    public function destroy(string $id)
    {
        $list = ShoppingList::findOrFail($id);
        $list_name = $list->name;

        Gate::authorize('delete', $list);

        $list->delete();

        return redirect()->route('shopping-lists.index')->with('success', 'Список покупок "' . $list_name . '" успешно удален');
    }
}
