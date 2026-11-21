<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use App\Models\ShoppingList;

class ItemPolicy
{
    public function index(User $user, ShoppingList $shoppingList): bool
    {
        return $user->id === $shoppingList->user_id;
    }

    public function show(User $user, Item $item): bool
    {
        return $user->id === $item->shoppingList->user_id;
    }

    public function create(User $user, ShoppingList $shoppingList): bool
    {
        return $user->id === $shoppingList->user_id;
    }

    public function update(User $user, Item $item): bool
    {
        return $user->id === $item->shoppingList->user_id;
    }

    public function transfer(User $user, Item $item): bool
    {
        return $user->id === $item->shoppingList->user_id;
    }

    public function delete(User $user, Item $item): bool
    {
        return $user->id === $item->shoppingList->user_id;
    }
}
