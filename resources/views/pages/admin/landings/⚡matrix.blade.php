<?php

declare(strict_types=1);

use App\Enums\LandingStatus;
use App\Models\Category;
use App\Models\Location;
use App\Models\Landing;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new
#[Layout('layouts.admin')]
class extends Component
{
    /** @var array<int, int> */
    public array $categoryIds = [];

    /** @var array<int, int> */
    public array $locationIds = [];

    public bool $includeCategoryOnly = true;

    /**
     * Map of "category_id-city_id_or_none" => bool. Holds which combinations
     * the admin wants active after the next applyChanges() call.
     *
     * @var array<string, bool>
     */
    public array $checked = [];

    public ?string $statusMessage = null;

    public function mount(): void
    {
        $this->categoryIds = Category::orderBy('name')->pluck('id')->take(10)->all();
        $this->locationIds = Location::orderBy('name')->pluck('id')->take(10)->all();

        $this->loadCurrentState();
    }

    /**
     * Build the initial $checked map from the active Landings that match
     * the current category/city subset.
     */
    protected function loadCurrentState(): void
    {
        $this->checked = [];

        if ($this->categoryIds === []) {
            return;
        }

        $landings = Landing::published()
            ->whereIn('category_id', $this->categoryIds)
            ->where(function ($q): void {
                $q->whereIn('location_id', $this->locationIds);
                if ($this->includeCategoryOnly) {
                    $q->orWhereNull('location_id');
                }
            })
            ->get(['category_id', 'location_id']);

        foreach ($landings as $landing) {
            $this->checked[$this->cellKey($landing->category_id, $landing->location_id)] = true;
        }
    }

    public function updatedCategoryIds(): void
    {
        $this->loadCurrentState();
    }

    public function updatedCityIds(): void
    {
        $this->loadCurrentState();
    }

    public function updatedIncludeCategoryOnly(): void
    {
        $this->loadCurrentState();
    }

    public function cellKey(int $categoryId, ?int $locationId): string
    {
        return $categoryId.'-'.($locationId ?? 'none');
    }

    public function applyChanges(): void
    {
        $created = 0;
        $reactivated = 0;
        $deactivated = 0;

        foreach ($this->categoryIds as $categoryId) {
            $combos = collect($this->locationIds)->map(fn (int $id): ?int => $id);
            if ($this->includeCategoryOnly) {
                $combos = $combos->prepend(null);
            }

            foreach ($combos as $locationId) {
                $key = $this->cellKey($categoryId, $locationId);
                $shouldBeActive = (bool) ($this->checked[$key] ?? false);

                $existing = Landing::forCombination($categoryId, $locationId)->first();

                if ($shouldBeActive) {
                    if ($existing === null) {
                        Landing::create([
                            'category_id' => $categoryId,
                            'location_id' => $locationId,
                            'status' => LandingStatus::Published,
                        ]);
                        $created++;
                    } elseif (! $existing->isPublished()) {
                        $existing->update(['status' => LandingStatus::Published, 'publish_at' => null]);
                        $reactivated++;
                    }
                } elseif ($existing && $existing->isPublished()) {
                    $existing->update(['status' => LandingStatus::Draft]);
                    $deactivated++;
                }
            }
        }

        $parts = [];
        if ($created > 0) {
            $parts[] = "$created creadas";
        }
        if ($reactivated > 0) {
            $parts[] = "$reactivated reactivadas";
        }
        if ($deactivated > 0) {
            $parts[] = "$deactivated desactivadas";
        }

        $this->statusMessage = $parts === [] ? 'Sin cambios.' : implode(', ', $parts).'.';

        $this->loadCurrentState();
    }

    /**
     * @return \Illuminate\Support\Collection<int, Category>
     */
    #[Computed]
    public function allCategories(): \Illuminate\Support\Collection
    {
        return Category::orderBy('name')->get(['id', 'name']);
    }

    /**
     * @return \Illuminate\Support\Collection<int, Location>
     */
    #[Computed]
    public function allLocations(): \Illuminate\Support\Collection
    {
        return Location::orderBy('name')->get(['id', 'name']);
    }

    /**
     * @return \Illuminate\Support\Collection<int, Category>
     */
    #[Computed]
    public function pickedCategories(): \Illuminate\Support\Collection
    {
        return Category::whereIn('id', $this->categoryIds)->orderBy('name')->get(['id', 'name', 'slug']);
    }

    /**
     * @return \Illuminate\Support\Collection<int, Location>
     */
    #[Computed]
    public function pickedLocations(): \Illuminate\Support\Collection
    {
        return Location::whereIn('id', $this->locationIds)->orderBy('name')->get(['id', 'name', 'slug']);
    }
};
?>

<div class="space-y-6 p-8">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Matriz de landings</flux:heading>
        <flux:button :href="route('admin.landings.index')" variant="ghost" icon="arrow-left">Volver al listado</flux:button>
    </div>

    <flux:text class="text-zinc-600">
        Marca las combinaciones que quieres tener activas. Al aplicar:
        las nuevas se crean, las existentes inactivas se reactivan y las desmarcadas se desactivan
        (no se borran — el contenido editado se conserva).
    </flux:text>

    @if ($statusMessage)
        <flux:callout icon="check-circle" color="green">{{ $statusMessage }}</flux:callout>
    @endif

    <div class="grid gap-4 md:grid-cols-2">
        <flux:field>
            <flux:label>Categorías incluidas</flux:label>
            <flux:select variant="listbox" searchable multiple wire:model.live="categoryIds" placeholder="Selecciona categorías…">
                @foreach ($this->allCategories as $category)
                    <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </flux:field>

        <flux:field>
            <flux:label>Ubicaciones incluidas</flux:label>
            <flux:select variant="listbox" searchable multiple wire:model.live="locationIds" placeholder="Selecciona ubicaciones…">
                @foreach ($this->allLocations as $location)
                    <flux:select.option value="{{ $location->id }}">{{ $location->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </flux:field>
    </div>

    <flux:checkbox wire:model.live="includeCategoryOnly" label="Incluir columna 'sin ubicación' (landing genérica por categoría)" />

    @if ($this->pickedCategories->isEmpty())
        <flux:callout icon="information-circle" color="zinc">
            Selecciona al menos una categoría para ver la matriz.
        </flux:callout>
    @else
        <div class="overflow-x-auto rounded-lg border border-zinc-200">
            <table class="min-w-full divide-y divide-zinc-200 text-sm">
                <thead class="bg-zinc-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-zinc-700">Categoría</th>
                        @if ($includeCategoryOnly)
                            <th class="px-4 py-2 text-center font-medium text-zinc-700">
                                <em>sin ubicación</em>
                            </th>
                        @endif
                        @foreach ($this->pickedLocations as $location)
                            <th class="px-4 py-2 text-center font-medium text-zinc-700">{{ $location->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
                    @foreach ($this->pickedCategories as $category)
                        <tr wire:key="row-{{ $category->id }}">
                            <td class="px-4 py-2 font-medium text-zinc-900">{{ $category->name }}</td>
                            @if ($includeCategoryOnly)
                                <td class="px-4 py-2 text-center">
                                    <input
                                        type="checkbox"
                                        wire:model="checked.{{ $this->cellKey($category->id, null) }}"
                                        class="size-4 rounded border-zinc-300"
                                        data-test="cell-{{ $category->id }}-none">
                                </td>
                            @endif
                            @foreach ($this->pickedLocations as $location)
                                <td class="px-4 py-2 text-center">
                                    <input
                                        type="checkbox"
                                        wire:model="checked.{{ $this->cellKey($category->id, $location->id) }}"
                                        class="size-4 rounded border-zinc-300"
                                        data-test="cell-{{ $category->id }}-{{ $location->id }}">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end">
            <flux:button wire:click="applyChanges" variant="primary">Aplicar cambios</flux:button>
        </div>
    @endif
</div>
