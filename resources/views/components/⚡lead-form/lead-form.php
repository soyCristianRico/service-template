<?php

use App\Livewire\Forms\Lead\LeadForm;
use App\Models\Landing;
use App\Services\Lead\LeadService;
use Livewire\Component;

new class extends Component
{
    public ?Landing $landing = null;

    public string $sourceUrl = '';

    public LeadForm $form;

    public bool $submitted = false;

    public function mount(?Landing $landing = null): void
    {
        $this->landing = $landing;
        $this->sourceUrl = $landing ? url('/'.$landing->slug) : request()->url();
    }

    public function save(LeadService $service): void
    {
        $this->form->submit($this->landing, $this->sourceUrl, $service);
        $this->submitted = true;
    }
};
