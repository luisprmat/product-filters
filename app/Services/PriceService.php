<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class PriceService
{
    private array $prices;

    private array $categories;

    private array $manufacturers;

    public function getPrices($prices, $categories, $manufacturers): array
    {
        $this->manufacturers = $manufacturers;
        $this->categories = $categories;
        $this->prices = $prices;
        $formattedPrices = [];

        foreach (Product::PRICES as $index => $name) {
            $formattedPrices[] = [
                'name' => $name,
                'products_count' => $this->getProductCount($index),
            ];
        }

        return $formattedPrices;
    }

    private function getProductCount($index): int
    {
        return Product::when($index == 0, function (Builder $query) {
            $query->where('price', '<', '5000');
        })
            ->when($index == 1, function (Builder $query) {
                $query->whereBetween('price', ['5000', '10000']);
            })
            ->when($index == 2, function (Builder $query) {
                $query->whereBetween('price', ['10000', '50000']);
            })
            ->when($index == 3, function (Builder $query) {
                $query->where('price', '>', '50000');
            })
            ->count();
    }
}
