<?php

use Livewire\Component;
use App\Models\Field;

new class extends Component {
    public string $search = '';
    public string $type = 'all';
    public array $selectedLocations = [];
    public int $maxPrice = 500;
    public string $sortBy = 'recommended';

    public $fields;
    public array $availableLocations = [];

    public function mount(): void
    {
        $this->availableLocations = Field::query()
            ->where('status', 'active')
            ->pluck('localisation')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->type = 'all';
        $this->selectedLocations = [];
        $this->maxPrice = 500;
        $this->sortBy = 'recommended';
    }

    public function getFilteredFieldsProperty(): array
    {
        $search = mb_strtolower(trim($this->search));
        $today = strtolower(now()->englishDayOfWeek);

        $query = Field::query()
            ->where('status', 'active')
            ->with([
                'prices',
                'reviews',
            ])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('localisation', 'like', "%{$search}%");
            });
        }

        if ($this->type !== 'all') {
            $query->where('type', $this->type);
        }

        if (!empty($this->selectedLocations)) {
            $query->whereIn('localisation', $this->selectedLocations);
        }

        $fields = $query->get()->map(function ($field) use ($today) {
            $todayPrice = $field->prices
                ->firstWhere('day_of_week', $today);

            $minPrice = $field->prices->min('price');

            $field->display_price = $todayPrice?->price ?? $minPrice ?? 0;
            $field->display_rating = $field->reviews_avg_rating
                ? round($field->reviews_avg_rating, 1)
                : 0;

            return $field;
        })->filter(function ($field) {
            return $field->display_price <= $this->maxPrice;
        });

        $fields = match ($this->sortBy) {
            'price_asc' => $fields->sortBy('display_price'),
            'price_desc' => $fields->sortByDesc('display_price'),
            'highest_rated' => $fields->sortByDesc('display_rating'),
            default => $fields->sortByDesc(function ($field) {
                return ($field->display_rating * 1000) + $field->reviews_count;
            }),
        };

        return $fields->values()->all();
    }
};

?>

<div class="min-h-screen bg-gray-50 py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-10">
            <h1 class="mb-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                Explore Fields
            </h1>

            <p class="mb-8 max-w-2xl text-lg text-gray-500">
                Find the perfect pitch for your next game. Filter by location, type, and price.
            </p>

            <div class="flex flex-col gap-4 md:flex-row">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 1 1-14 0a7 7 0 0 1 14 0Z" />
                        </svg>
                    </span>

                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Search by stadium name or location..."
                        class="h-14 w-full rounded-2xl border border-gray-200 bg-white pl-11 pr-4 text-base shadow-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                    >
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-8 lg:flex-row">
            <aside class="hidden w-72 shrink-0 space-y-6 lg:block">

                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 font-bold text-gray-900">Field Type</h3>

                    <div class="flex flex-col gap-2">
                        @foreach (['all', '5v5', '7v7'] as $fieldType)
                            <button
                                type="button"
                                wire:click="setType('{{ $fieldType }}')"
                                class="rounded-xl px-4 py-3 text-left text-sm font-medium transition
                                    {{ $type === $fieldType
                                        ? 'border border-green-200 bg-green-50 text-green-700'
                                        : 'text-gray-600 hover:bg-gray-50' }}"
                            >
                                {{ $fieldType === 'all' ? 'All fields' : $fieldType }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 font-bold text-gray-900">Location</h3>

                    <div class="space-y-3">
                        @foreach ($availableLocations as $location)
                            <label class="flex cursor-pointer items-center gap-3">
                                <input
                                    type="checkbox"
                                    value="{{ $location }}"
                                    wire:model.live="selectedLocations"
                                    class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                >
                                <span class="text-sm font-medium text-gray-600">{{ $location }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="font-bold text-gray-900">Max Price</h3>
                        <span class="text-sm font-semibold text-green-700">{{ $maxPrice }} MAD</span>
                    </div>

                    <input
                        type="range"
                        min="0"
                        max="500"
                        step="10"
                        wire:model.live="maxPrice"
                        class="w-full accent-green-600"
                    >

                    <div class="mt-2 flex justify-between text-sm font-medium text-gray-500">
                        <span>0</span>
                        <span>500+</span>
                    </div>
                </div> -->
            </aside>

            <section class="flex-1">
                <div class="mb-6 flex gap-2 overflow-x-auto pb-2 lg:hidden">
                    @foreach (['all', '5v5', '7v7'] as $fieldType)
                        <button
                            type="button"
                            wire:click="setType('{{ $fieldType }}')"
                            class="whitespace-nowrap rounded-full px-5 py-2.5 text-sm font-semibold transition
                                {{ $type === $fieldType
                                    ? 'bg-gray-900 text-white shadow-md'
                                    : 'border border-gray-200 bg-white text-gray-600' }}"
                        >
                            {{ $fieldType === 'all' ? 'All Fields' : $fieldType }}
                        </button>
                    @endforeach
                </div>

                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <span class="font-medium text-gray-500">
                        {{ count($this->filteredFields) }} Result
                    </span>

                    <select
                        wire:model.live="sortBy"
                        class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm outline-none focus:ring-2 focus:ring-green-500"
                    >
                        <option value="recommended">The Best</option>
                        <option value="price_asc">Price: From lowest to highest</option>
                        <option value="price_desc">Price: From highest to lowest</option>
                        <option value="highest_rated">Highest Rated</option>
                    </select>
                </div>

                @if (count($this->filteredFields) > 0)
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($this->filteredFields as $field)
                            <article class="group flex h-full flex-col overflow-hidden rounded-3xl bg-white shadow-sm transition duration-300 hover:shadow-xl">
                                <div class="relative h-56 w-full overflow-hidden">
                                    <img 
                                        src="{{ Storage::disk('r2')->url($field->image_path) }}" 
                                        alt="{{ $field->name }}"
                                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    >

                                    <div class="absolute left-4 top-4 inline-flex items-center gap-1 rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-gray-900 shadow-sm backdrop-blur-sm">
                                        {{ $field->type }}
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col p-5">
                                    <div class="mb-2 flex items-start justify-between gap-3">
                                        <h3 class="line-clamp-1 text-xl font-bold text-gray-900">
                                            {{ $field->name }}
                                        </h3>

                                        <div class="flex shrink-0 items-center gap-1 text-sm font-bold text-gray-900">
                                            ⭐ {{ $field->display_rating }}
                                        </div>
                                    </div>

                                    <div class="mb-1 text-sm text-gray-400">
                                        {{ $field->reviews_count }} Reviews
                                    </div>

                                    <div class="mb-4 text-sm text-gray-500">
                                        {{ $field->localisation }}
                                    </div>

                                    <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-4">
                                        <div>
                                            <span class="text-xl font-bold text-gray-900">{{ number_format($field->display_price, 2) }}</span>
                                            <span class="text-xs text-gray-500">MAD / Hour</span>
                                        </div>

                                        <a
                                            href="{{ route('public.fields.show' , $field->id) }}"
                                            class="inline-flex h-10 items-center justify-center rounded-xl bg-gray-900 px-5 text-sm font-medium text-white transition hover:bg-gray-800"
                                        >
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-3xl border border-gray-100 bg-white py-20 text-center shadow-sm">
                        <h3 class="mb-2 text-lg font-bold text-gray-900">No matching stadiums</h3>
                        <p class="text-gray-500">Try changing the filters or search term.</p>

                        <button
                            type="button"
                            wire:click="clearFilters"
                            class="mt-6 inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                        >
                            Clear filters
                        </button>
                    </div>
                @endif
            </section>
        </div>
    </div>
</div>