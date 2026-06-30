<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Lead;

use App\Models\Landing;
use App\Services\Lead\LeadService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LeadForm extends Form
{
    #[Validate('required|string|max:120')]
    public string $name = '';

    #[Validate('required|email:rfc|max:160')]
    public string $email = '';

    #[Validate('nullable|string|max:30')]
    public string $phone = '';

    #[Validate('nullable|string|max:2000')]
    public string $message = '';

    /**
     * Honeypot field — bots will fill anything; humans never see it.
     * Tests intentionally leave it empty.
     */
    public string $website = '';

    public function submit(?Landing $landing, string $sourceUrl, LeadService $service): bool
    {
        if (filled($this->website)) {
            // Pretend it succeeded to avoid revealing the honeypot.
            $this->reset();

            return true;
        }

        $this->validate();

        $service->capture([
            'landing_id' => $landing?->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone !== '' ? $this->phone : null,
            'message' => $this->message !== '' ? $this->message : null,
            'source_url' => $sourceUrl,
            'ip' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 1000),
        ]);

        $this->reset();

        return true;
    }
}
