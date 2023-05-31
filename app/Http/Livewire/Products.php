<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;

class Products extends Component
{
    public function render(): View
    {
        $products = Product::all();

        return view('livewire.products', compact('products'));
    }
}
