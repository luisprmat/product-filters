<div class="col-lg-3 mb-4">
    <h1 class="mt-4 text-4xl">Filtros</h1>

    <div x-data="{ open: true }">
        <h3 class="mt-2 mb-1 text-2xl">
            <button @click="open = !open" class="flex w-full items-center justify-between text-left">
                Precio
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 transform duration-300" :class="{'rotate-180': open}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </button>
        </h3>
        <div x-show="open"
            x-transition.scale.origin.top
            x-transition:enter.duration.500ms
            x-transition:leave.duration.500ms
        >
            @foreach($prices as $index => $price)
                <div>
                    <input type="checkbox" id="price{{ $index }}" value="{{ $index }}" wire:model="selected.prices">
                    <label for="price{{ $index }}">
                        {{ $price['name'] }} ({{ $price['products_count'] }})
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <div x-data="{
        open: true,
        search: '',
        startIndex: 0,
        endIndex: 2,
        options: @entangle('categories'),
        selected: @entangle('selected.categories'),
        get searchResults() {
            return this.options.filter(
                i => i.name.toLowerCase().includes(this.search.toLowerCase())
            )
        },
        get results() {
          return this.options.filter((val, index) => {
            return index >= this.startIndex && index <= this.endIndex
          })
        }
    }">
        <h3 class="mt-2 mb-1 text-2xl">
            <button @click="open = !open" class="flex w-full items-center justify-between text-left">
                Categorías
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 transform duration-300" :class="{'rotate-180': open}">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </button>
        </h3>
        <div x-show="open"
            x-transition.scale.origin.top
            x-transition:enter.duration.300ms
            x-transition:leave.duration.300ms
        >
            <input x-model="search" class="mb-2 w-full rounded-md border border-gray-400 px-2 py-1 text-sm" placeholder="Buscar categorías">
            <template x-if="search.length > 0">
                <div>
                    <template x-for="(option, index) in searchResults" :key="option.id">
                        <div>
                            <input type="checkbox" :id="'category' + index" :value="option.id" x-model="selected">
                            <label :for="'category' + index" x-text="option.name + ' (' + option.products_count + ')'"></label>
                        </div>
                    </template>
                </div>
            </template>
            <template x-if="search.length === 0">
                <div>
                    <template x-for="(option, index) in results" :key="option.id">
                        <div>
                            <input type="checkbox" :id="'category' + index" :value="option.id" x-model="selected">
                            <label :for="'category' + index" x-text="option.name + ' (' + option.products_count + ')'"></label>
                        </div>
                    </template>
                    <template x-if="endIndex != options.length">
                        <div class="mt-1 cursor-pointer font-medium text-indigo-500" @click="endIndex = options.length">Mostrar más ...</div>
                    </template>
                    <template x-if="endIndex === options.length">
                        <div class="mt-1 cursor-pointer font-medium text-indigo-500" @click="endIndex = 2">Mostrar menos ...</div>
                    </template>
                </div>
            </template>
        </div>
    </div>

    <h3 class="mt-2 mb-1 text-3xl">Fabricantes</h3>
    @foreach($manufacturers as $index => $manufacturer)
        <div>
            <input type="checkbox" id="manufacturer{{ $index }}" value="{{ $manufacturer['id'] }}" wire:model="selected.manufacturers">
            <label for="manufacturer{{ $index }}">
                {{ $manufacturer['name'] }} ({{ $manufacturer['products_count'] }})
            </label>
        </div>
    @endforeach
</div>
