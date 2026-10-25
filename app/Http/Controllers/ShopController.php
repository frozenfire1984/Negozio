<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index()
    {
        $shops = Shop::all();

        $count = $shops->count();
        return view('shops.index', compact('shops', 'count'));
    }

    public function show(string $id)
    {
        $shop = Shop::findOrFail($id);

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
        ]);
        return redirect()->route('shops.index')->with('success', 'Магазин "' . $request->name . '" успешно добавлен');
    }


    public function edit(string $id)
    {
        $shop = Shop::findOrFail($id);

        return view('shops.edit', compact('shop'));
    }


    public function update(Request $request, string $id)
    {
        $shop = Shop::findOrFail($id);

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
        return redirect()->route('shops.index')->with('success', 'Магазин "' . $request->name . '" успешно обновлен');
    }

    public function delete(string $id)
    {
        $shop = Shop::findOrFail($id);

        return view('shops.delete', compact('shop'));
    }


    public function destroy(string $id)
    {
        $shop = Shop::findOrFail($id);
        $shop_name = $shop->name;

        $shop->delete();

        return redirect()->route('shops.index')->with('success', 'Магазин "' . $shop_name . '" успешно удален');
    }
}
