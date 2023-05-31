<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;

class Products extends Component
{
    protected $selected = [
        'prices' => [],
        'categories' => [],
        'manufacturers' => [],
    ];

    protected $listeners = ['updatedSidebar' => 'setSelected'];

    public function setSelected($selected): void
    {
        $this->selected = $selected;
    }

    public function render(): View
    {
        $products = Product::withFilters(
            $this->selected['prices'],
            $this->selected['categories'],
            $this->selected['manufacturers']
        )->get();

        return view('livewire.products', compact('products'));
    }
}
