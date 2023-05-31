<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Services\PriceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;

class Sidebar extends Component
{
    public array $selected = [
        'prices' => [],
        'categories' => [],
        'manufacturers' => [],
    ];

    public function updatedSelected(): void
    {
        $this->emit('updatedSidebar', $this->selected);
    }

    public function render(PriceService $priceService): View
    {
        $prices = $priceService->getPrices(
            [],
            $this->selected['categories'],
            $this->selected['manufacturers']
        );

        $categories = Category::withCount(['products' => function (Builder $query) {
            $query->withFilters(
                $this->selected['prices'],
                [],
                $this->selected['manufacturers']
            );
        }])->get();

        $manufacturers = Manufacturer::withCount(['products' => function (Builder $query) {
            $query->withFilters(
                $this->selected['prices'],
                $this->selected['categories'],
                []
            );
        }])->get();

        return view('livewire.sidebar', compact('prices', 'categories', 'manufacturers'));
    }
}
