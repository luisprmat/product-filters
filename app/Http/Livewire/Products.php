<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public array $selected = [
        'prices' => [],
        'categories' => [],
        'manufacturers' => [],
    ];

    protected $listeners = ['updatedSidebar' => 'setSelected'];

    public function setSelected($selected): void
    {
        $this->selected = $selected;
        $this->resetPage();
    }

    public function render(): View
    {
        $products = Product::withFilters(
            $this->selected['prices'],
            $this->selected['categories'],
            $this->selected['manufacturers']
        )->paginate(6);

        return view('livewire.products', compact('products'));
    }
}
