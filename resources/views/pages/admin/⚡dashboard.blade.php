<?php

use Livewire\Component;

new
#[\Livewire\Attributes\Layout('layouts.admin')]
class extends Component
{
    public function with(): array
    {
        return [
            'userName' => auth()->user()?->name,
        ];
    }
};
?>

<div class="space-y-6 p-8">
    <flux:heading size="xl">Dashboard</flux:heading>

    <flux:text>
        Hola {{ $userName }}. Este es el panel admin del services-template. Cada sitio que clona este
        template lo personaliza con sus métricas (leads del mes, servicios sin foto, landings sin contenido…).
    </flux:text>

    <flux:callout icon="information-circle" color="zinc">
        Las secciones del menú lateral aún no están implementadas. Se construyen en las siguientes fases
        (modelos + admin CRUD).
    </flux:callout>
</div>
