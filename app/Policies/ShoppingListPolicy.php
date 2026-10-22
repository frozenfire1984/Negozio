<?php

namespace App\Policies;

use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShoppingListPolicy
{

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function show(User $user, ShoppingList $shoppingList): bool
    {
        return $user->id === $shoppingList->user_id;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ShoppingList $shoppingList): bool
    {
        return $user->id === $shoppingList->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ShoppingList $shoppingList): bool
    {
        return $user->id === $shoppingList->user_id;
    }

    public function restore(User $user, ShoppingList $shoppingList): bool
    {
        return false;
    }

    public function forceDelete(User $user, ShoppingList $shoppingList): bool
    {
        return false;
    }
}
