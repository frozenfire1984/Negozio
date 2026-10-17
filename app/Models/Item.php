<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_priority',
        'note',
        'shopping_list_id',
        'category_id',
        'status',
        'quantity',
        'weight',
        'estimated_price',
        'price',
        'currency',
        'photo_path',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function shoppingList(): BelongsTo {
        return $this->belongsTo(ShoppingList::class);
    }
}
