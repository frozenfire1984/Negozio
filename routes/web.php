<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;

Route::get('/', function () {
    return view('welcome');
});


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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
