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
        'quantity',
        'weight',
        'estimated_price',
        'price',
        'currency',
        'photo_path',
    ];

    protected function casts(): array
    {
        return [
            'is_priority' => 'boolean',
            'quantity' => 'integer',
            'weight' => 'decimal:3',
            'estimated_price' => 'decimal:2',
            'price' => 'decimal:2',
            'is_unplanned' => 'boolean',
            'is_added_by_other_user' => 'boolean',
        ];
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function shoppingList(): BelongsTo {
        return $this->belongsTo(ShoppingList::class);
    }
}
