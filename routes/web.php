<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return view('home');
})->name('home');;

Route::prefix('/shopping-lists')->middleware('auth')->group(function() {
    Route::get('/', [ShoppingListController::class, 'index'])->name('shopping-lists.index');
    Route::get('/{id}/show', [ShoppingListController::class, 'show'])->name('shopping-lists.show');
    Route::get('/create', [ShoppingListController::class, 'create'])->name('shopping-lists.create');
    Route::post('/', [ShoppingListController::class, 'store'])->name('shopping-lists.store');
    Route::get('/{id}/edit', [ShoppingListController::class, 'edit'])->name('shopping-lists.edit');
    Route::put('/{id}', [ShoppingListController::class, 'update'])->name('shopping-lists.update');
    Route::get('/{id}/delete', [ShoppingListController::class, 'delete'])->name('shopping-lists.delete');
    Route::delete('/{id}', [ShoppingListController::class, 'destroy'])->name('shopping-lists.destroy');
});

Route::prefix('/shops')->middleware('auth')->group(function() {
    Route::get('/', [ShopController::class, 'index'])->name('shops.index');
    Route::get('/{id}/show', [ShopController::class, 'show'])->name('shops.show');
    Route::get('/create', [ShopController::class, 'create'])->name('shops.create');
    Route::post('/', [ShopController::class, 'store'])->name('shops.store');
    Route::get('/{id}/edit', [ShopController::class, 'edit'])->name('shops.edit');
    Route::put('/{id}', [ShopController::class, 'update'])->name('shops.update');
    Route::get('/{id}/delete', [ShopController::class, 'delete'])->name('shops.delete');
    Route::delete('/{id}', [ShopController::class, 'destroy'])->name('shops.destroy');
});

Route::prefix('/items')->middleware('auth')->group(function() {
    Route::get('/{shopping_list_id}', [ItemController::class, 'index'])->name('items.index');
    Route::get('/{id}/show', [ItemController::class, 'show'])->name('items.show');
    Route::get('/{shopping_list_id}/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/{shopping_list_id}/', [ItemController::class, 'store'])->name('items.store');
    Route::get('/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::get('/{id}/transfer_view', [ItemController::class, 'transfer_view'])->name('items.transfer_view');
    Route::put('/{id}/transfer', [ItemController::class, 'transfer'])->name('items.transfer');
    Route::get('/{id}/delete', [ItemController::class, 'delete'])->name('items.delete');
    Route::delete('/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
