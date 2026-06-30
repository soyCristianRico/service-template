<?php

declare(strict_types=1);

use App\Models\Location;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new
#[Layout('layouts.admin')]
class extends Component
{
    public string $search = '';

    public function deleteLocation(int $id): void
    {
        Location::findOrFail($id)->delete();
    }

    /**
     * Flat list of [location, depth] ordered depth-first from each root.
     * Filters by search if present.
     *
     * @return array<int, array{location: Location, depth: int}>
     */
    #[Computed]
    public function tree(): array
    {
        $locations = Location::with('children')->orderBy('name')->get();

        if ($this->search !== '') {
            $needle = mb_strtolower($this->search);
            $matches = $locations->filter(fn (Location $c) => str_contains(mb_strtolower($c->name), $needle));

            return $matches->map(fn (Location $c) => ['location' => $c, 'depth' => 0])->values()->all();
        }

        $byParent = $locations->groupBy('parent_id');
        $rows = [];

        $walk = function (?int $parentId, int $depth) use (&$walk, $byParent, &$rows): void {
            foreach ($byParent->get((string) $parentId, collect()) as $node) {
                $rows[] = ['location' => $node, 'depth' => $depth];
                $walk($node->id, $depth + 1);
            }
        };

        $walk(null, 0);

        return $rows;
    }
};
?>

<div class="space-y-6 p-8">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Ubicaciones</flux:heading>
        <flux:button :href="route('admin.locations.create')" variant="primary" icon="plus">Nueva ubicación</flux:button>
    </div>

    <flux:input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar por nombre…" icon="magnifying-glass" class="max-w-md" />

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Nombre</flux:table.column>
            <flux:table.column>Slug</flux:table.column>
            <flux:table.column>Tipo</flux:table.column>
            <flux:table.column>Población</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($this->tree as $row)
                @php($location = $row['location'])
                @php($depth = $row['depth'])
                <flux:table.row wire:key="location-{{ $location->id }}">
                    <flux:table.cell>
                        <span style="padding-left: {{ $depth * 20 }}px">
                            @if ($depth > 0) <span class="text-zinc-300">└ </span> @endif
                            {{ $location->name }}
                        </span>
                    </flux:table.cell>
                    <flux:table.cell><code class="text-xs">{{ $location->slug }}</code></flux:table.cell>
                    <flux:table.cell><flux:badge size="sm">{{ $location->type->label() }}</flux:badge></flux:table.cell>
                    <flux:table.cell>{{ $location->population ? number_format($location->population, 0, ',', '.') : '—' }}</flux:table.cell>
                    <flux:table.cell class="flex gap-2">
                        <flux:button :href="route('admin.locations.edit', $location)" size="xs" variant="ghost" icon="pencil-square" />
                        <flux:button
                            wire:click="deleteLocation({{ $location->id }})"
                            wire:confirm="¿Eliminar {{ $location->name }}? Sus hijos se quedan sin padre."
                            size="xs" variant="ghost" icon="trash" />
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center text-zinc-500">
                        No hay ubicaciones. <a href="{{ route('admin.locations.create') }}" class="underline">Crea la primera</a>.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>
