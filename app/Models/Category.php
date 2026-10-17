<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'private_of_user_id',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'private_of_user_id');
    }

    public function items(): HasMany {
        return $this->hasMany(Item::class);
    }
}
