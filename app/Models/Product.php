<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category_id', 'manufacturer_id'];

    const PRICES = [
        'Menos de $5.000',
        'Entre $5.000 y $10.000',
        'Entre $10.000 y $50.000',
        'Más de $50.000',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
