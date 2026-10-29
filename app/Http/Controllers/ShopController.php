<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShopController extends Controller
{

    public function index()
    {
        $shops = Shop::where('user_id', auth()->id())->get();

        $count = $shops->count();
        return view('shops.index', compact('shops', 'count'));
    }

    public function show(string $id)
    {
        $shop = Shop::findOrFail($id);

        Gate::authorize('show', $shop);

        return view('shops.show', compact('shop'));
    }


    public function create()
    {
        return view('shops.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'display_name' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:200',
        ]);

        Shop::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'address' => $request->address,
            'user_id' => auth()->id(),
        ]);
        return redirect()->route('shops.index')->with('success', 'Магазин "' . $request->name . '" успешно добавлен');
    }


    public function edit(string $id)
    {
        $shop = Shop::findOrFail($id);

        Gate::authorize('update', $shop);

        return view('shops.edit', compact('shop'));
    }


    public function update(Request $request, string $id)
    {
        $shop = Shop::findOrFail($id);

        Gate::authorize('update', $shop);

        $request->validate([
            'name' => 'required|string|min:2|max:50',
            'display_name' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:200',
        ]);

        $shop->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'address' => $request->address,
        ]);
        return redirect()->route('shops.show', $shop->id)->with('success', 'Магазин "' . $request->name . '" успешно обновлен');
    }

    public function delete(string $id)
    {
        $shop = Shop::findOrFail($id);

        Gate::authorize('delete', $shop);

        return view('shops.delete', compact('shop'));
    }


    public function destroy(string $id)
    {
        $shop = Shop::findOrFail($id);
        $shop_name = $shop->name;

        Gate::authorize('delete', $shop);

        $shop->delete();

        return redirect()->route('shops.index')->with('success', 'Магазин "' . $shop_name . '" успешно удален');
    }
}
