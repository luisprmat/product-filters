<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function scopeWithFilters(Builder $query, array $prices, array $categories, array $manufacturers)
    {
        return $query->when(count($manufacturers), function (Builder $query) use ($manufacturers) {
            $query->whereIn('manufacturer_id', $manufacturers);
        })
            ->when(count($categories), function (Builder $query) use ($categories) {
                $query->whereIn('category_id', $categories);
            })
            ->when(count($prices), function (Builder $query) use ($prices) {
                $query->where(function (Builder $query) use ($prices) {
                    $query->when(in_array(0, $prices), function (Builder $query) {
                        $query->orWhere('price', '<', '5000');
                    })
                        ->when(in_array(1, $prices), function (Builder $query) {
                            $query->orWhereBetween('price', ['5000', '10000']);
                        })
                        ->when(in_array(2, $prices), function (Builder $query) {
                            $query->orWhereBetween('price', ['10000', '50000']);
                        })
                        ->when(in_array(3, $prices), function (Builder $query) {
                            $query->orWhere('price', '>', '50000');
                        });
                });
            });
    }
}
