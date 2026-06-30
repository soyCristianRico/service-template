<?php

declare(strict_types=1);

namespace App\Services\Lead;

use App\Enums\LeadStatus;
use App\Mail\Lead\NewLeadMail;
use App\Models\Lead;
use App\Models\User;
use App\Notifications\Lead\LeadCapturedNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class LeadService
{
    /**
     * Persist a lead and fire post-capture side effects (email, Discord).
     *
     * The caller is responsible for input validation (typically via the Lead
     * form Livewire component) — this method assumes well-formed data.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function capture(array $attributes): Lead
    {
        $lead = Lead::create([...$attributes, 'status' => $attributes['status'] ?? LeadStatus::New]);

        $this->notify($lead);

        return $lead;
    }

    protected function notify(Lead $lead): void
    {
        $email = $this->resolveNotifyEmail();
        if ($email !== null) {
            Mail::to($email)->queue(new NewLeadMail($lead));
        }

        if (is_string(config('services.discord.webhook_url')) && config('services.discord.webhook_url') !== '') {
            Notification::route('discord', null)->notify(new LeadCapturedNotification($lead));
        }
    }

    /**
     * Resolve the lead notification recipient.
     *
     * Falls back to the first registered user (typically the site owner) when
     * LEAD_NOTIFY_EMAIL is not configured, so notifications are never silently
     * lost on a fresh deploy.
     */
    protected function resolveNotifyEmail(): ?string
    {
        $configured = config('leads.notify_email');
        if (is_string($configured) && $configured !== '') {
            return $configured;
        }

        return User::oldest('id')->value('email');
    }
}
