<?php

declare(strict_types=1);

use App\Enums\LandingStatus;
use App\Models\Category;
use App\Models\Location;
use App\Models\Landing;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new
#[Layout('layouts.admin')]
class extends Component
{
    use WithPagination;

    #[Url(as: 's')]
    public string $search = '';

    #[Url(as: 'category')]
    public ?int $categoryId = null;

    #[Url(as: 'location')]
    public ?int $locationId = null;

    #[Url(as: 'status')]
    public string $status = 'all'; // all | draft | scheduled | published

    public function updating(): void
    {
        $this->resetPage();
    }

    public function publishNow(int $id): void
    {
        Landing::findOrFail($id)->update([
            'status' => LandingStatus::Published,
            'publish_at' => null,
        ]);
    }

    public function unpublish(int $id): void
    {
        Landing::findOrFail($id)->update([
            'status' => LandingStatus::Draft,
            'publish_at' => null,
        ]);
    }

    public function deleteLanding(int $id): void
    {
        Landing::findOrFail($id)->delete();
    }

    /**
     * @return \Illuminate\Support\Collection<int, Category>
     */
    #[Computed]
    public function categories(): \Illuminate\Support\Collection
    {
        return Category::orderBy('name')->get(['id', 'name']);
    }

    /**
     * @return \Illuminate\Support\Collection<int, Location>
     */
    #[Computed]
    public function locations(): \Illuminate\Support\Collection
    {
        return Location::orderBy('name')->get(['id', 'name']);
    }

    #[Computed]
    public function landings(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Landing::query()
            ->with(['category:id,name,slug', 'location:id,name,slug'])
            ->when($this->search !== '', fn ($q) => $q->where('slug', 'like', "%{$this->search}%"))
            ->when($this->categoryId, fn ($q) => $q->where('category_id', $this->categoryId))
            ->when($this->locationId, fn ($q) => $q->where('location_id', $this->locationId))
            ->when(in_array($this->status, ['draft', 'scheduled', 'published'], true), fn ($q) => $q->where('status', $this->status))
            ->orderByDesc('updated_at')
            ->paginate(25);
    }
};
?>

<div class="space-y-6 p-8">
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Landings</flux:heading>
        <div class="flex gap-2">
            <flux:button :href="route('admin.landings.matrix')" variant="ghost" icon="squares-2x2">Matriz</flux:button>
            <flux:button :href="route('admin.landings.create')" variant="primary" icon="plus">Nueva landing</flux:button>
        </div>
    </div>

    <div class="grid gap-3 md:grid-cols-4">
        <flux:input wire:model.live.debounce.300ms="search" type="search" placeholder="Buscar por slug…" icon="magnifying-glass" />
        <flux:select variant="listbox" searchable clearable wire:model.live="categoryId" placeholder="Todas las categorías">
            @foreach ($this->categories as $category)
                <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:select variant="listbox" searchable clearable wire:model.live="locationId" placeholder="Todas las ubicaciones">
            @foreach ($this->locations as $location)
                <flux:select.option value="{{ $location->id }}">{{ $location->name }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:select wire:model.live="status">
            <flux:select.option value="all">Todos los estados</flux:select.option>
            <flux:select.option value="draft">Borrador</flux:select.option>
            <flux:select.option value="scheduled">Programada</flux:select.option>
            <flux:select.option value="published">Publicada</flux:select.option>
        </flux:select>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>URL</flux:table.column>
            <flux:table.column>Categoría</flux:table.column>
            <flux:table.column>Ubicación</flux:table.column>
            <flux:table.column>Estado</flux:table.column>
            <flux:table.column>Acciones</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($this->landings as $landing)
                <flux:table.row wire:key="landing-{{ $landing->id }}">
                    <flux:table.cell>
                        <a href="{{ url('/'.$landing->slug) }}" target="_blank" class="text-blue-600 hover:underline">
                            /{{ $landing->slug }}
                        </a>
                    </flux:table.cell>
                    <flux:table.cell>{{ $landing->category?->name ?? '—' }}</flux:table.cell>
                    <flux:table.cell>{{ $landing->location?->name ?? 'sólo categoría' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$landing->status->color()" size="sm">{{ $landing->status->label() }}</flux:badge>
                        @if ($landing->status === \App\Enums\LandingStatus::Scheduled && $landing->publish_at)
                            <flux:text size="sm" class="mt-1 text-zinc-500">{{ $landing->publish_at->format('d/m/Y') }}</flux:text>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell class="flex gap-2">
                        @if ($landing->status === \App\Enums\LandingStatus::Published)
                            <flux:button wire:click="unpublish({{ $landing->id }})" size="xs" variant="ghost" icon="eye-slash" title="Despublicar" />
                        @else
                            <flux:button wire:click="publishNow({{ $landing->id }})" size="xs" variant="ghost" icon="rocket-launch" title="Publicar ahora" />
                        @endif
                        <flux:button :href="route('admin.landings.edit', $landing)" size="xs" variant="ghost" icon="pencil-square" />
                        <flux:button
                            wire:click="deleteLanding({{ $landing->id }})"
                            wire:confirm="¿Eliminar la landing /{{ $landing->slug }}? La URL devolverá 404."
                            size="xs" variant="ghost" icon="trash" />
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center text-zinc-500">
                        No hay landings con esos filtros.
                    </flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

    {{ $this->landings->links() }}
</div>
