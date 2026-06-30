<?php

declare(strict_types=1);

namespace Tests\Support\Livewire;

use App\Livewire\Forms\Catalog\LandingForm;
use Livewire\Component;

class LandingFormTestComponent extends Component
{
    public LandingForm $form;

    public function save(): void
    {
        $this->form->save();
    }

    public function syncStatusFromDate(): void
    {
        $this->form->syncStatusFromDate();
    }

    public function syncDateFromStatus(): void
    {
        $this->form->syncDateFromStatus();
    }

    public function render(): string
    {
        return <<<'BLADE'
            <div></div>
        BLADE;
    }
}
