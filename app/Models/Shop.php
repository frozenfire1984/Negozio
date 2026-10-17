<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'address',
        'type',
        'country',
        'city',
        'open_at',
        'close_at',
        'week_schedule',
        'notes_for_week_schedule',
    ];

    public function shoppingLists(): HasMany {
        return $this->hasMany(ShoppingList::class);
    }
}
