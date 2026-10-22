<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;
use App\Models\Shop;
use Illuminate\Support\Facades\Gate;

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

        return view('shopping-lists.show', [
            'list' => $list,
        ]);
    }


    public function create()
    {
        return view('shopping-lists.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'notes' => 'nullable|string|max:200',
        ]);

        ShoppingList::create([
            'name' => $request->name,
            'notes' => $request->notes,
            'user_id' => auth()->id(),

        ]);
        return redirect()->route('shopping-lists.index')->with('success', 'Лист успешно добавлен');
    }


    public function edit(string $id)
    {
        $list = ShoppingList::findOrFail($id);

        Gate::authorize('update', $list);

        return view('shopping-lists.edit', [
            'list' => $list,
        ]);
    }


    public function update(Request $request, string $id)
    {
        $list = ShoppingList::findOrFail($id);

        Gate::authorize('update', $list);

        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'notes' => 'nullable|string|max:200',
        ]);

        $list->update([
            'name' => $request->name,
            'notes' => $request->notes,
            //'user_id' => auth()->id(),
        ]);
        return redirect()->route('shopping-lists.index')->with('success', 'Лист успешно обновлен');
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

        Gate::authorize('delete', $list);

        $list->delete();

        return redirect()->route('shopping-lists.index')->with('success', 'Лист успешно удален');
    }
}
