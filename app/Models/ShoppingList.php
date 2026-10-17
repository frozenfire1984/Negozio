<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoppingList extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'shop_id',
        'date_for_future',
        'mode',
        'notes',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function shop(): BelongsTo {
        return $this->belongsTo(Shop::class);
    }

    public function items(): HasMany {
        return $this->hasMany(Item::class);
    }
}
