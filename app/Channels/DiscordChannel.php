<?php

declare(strict_types=1);

namespace App\Channels;

use App\Notifications\Messages\DiscordMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiscordChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $message = $notification->toDiscord($notifiable);

        if (! $message instanceof DiscordMessage) {
            return;
        }

        $webhookUrl = $message->webhookUrl ?? $this->getWebhookUrl($notifiable);

        if (! $webhookUrl) {
            Log::warning('Discord webhook URL not configured');

            return;
        }

        $response = Http::post($webhookUrl, $message->toArray());

        if ($response->failed()) {
            Log::error('Discord notification failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }
    }

    /**
     * Get the webhook URL for the notifiable.
     */
    protected function getWebhookUrl(object $notifiable): ?string
    {
        if (method_exists($notifiable, 'routeNotificationForDiscord')) {
            return $notifiable->routeNotificationForDiscord();
        }

        return config('services.discord.webhook_url');
    }
}
