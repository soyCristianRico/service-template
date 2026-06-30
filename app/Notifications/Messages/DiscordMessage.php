<?php

declare(strict_types=1);

namespace App\Notifications\Messages;

class DiscordMessage
{
    public ?string $webhookUrl = null;

    public ?string $content = null;

    public ?string $username = null;

    public ?string $avatarUrl = null;

    /** @var array<int, array<string, mixed>> */
    protected array $embeds = [];

    /**
     * Create a new Discord message instance.
     */
    public static function create(): self
    {
        return new self;
    }

    /**
     * Set the webhook URL (overrides config).
     */
    public function to(string $webhookUrl): self
    {
        $this->webhookUrl = $webhookUrl;

        return $this;
    }

    /**
     * Set the message content (plain text).
     */
    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the bot username.
     */
    public function username(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set the bot avatar URL.
     */
    public function avatar(string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    /**
     * Add an embed to the message.
     *
     * @param  array<string, mixed>  $embed
     */
    public function embed(array $embed): self
    {
        $this->embeds[] = $embed;

        return $this;
    }

    /**
     * Add a simple embed with title and description.
     */
    public function title(string $title, ?string $description = null, ?string $url = null): self
    {
        $embed = ['title' => $title];

        if ($description !== null) {
            $embed['description'] = $description;
        }

        if ($url !== null) {
            $embed['url'] = $url;
        }

        $this->embeds[] = $embed;

        return $this;
    }

    /**
     * Set the color of the last embed (or create one).
     * Accepts hex color (e.g., '#3498db' or '3498db') or int.
     */
    public function color(string|int $color): self
    {
        if ($this->embeds === []) {
            $this->embeds[] = [];
        }

        $lastIndex = count($this->embeds) - 1;

        if (is_string($color)) {
            $color = hexdec(ltrim($color, '#'));
        }

        $this->embeds[$lastIndex]['color'] = $color;

        return $this;
    }

    /**
     * Add a field to the last embed.
     */
    public function field(string $name, string $value, bool $inline = false): self
    {
        if ($this->embeds === []) {
            $this->embeds[] = [];
        }

        $lastIndex = count($this->embeds) - 1;

        if (! isset($this->embeds[$lastIndex]['fields'])) {
            $this->embeds[$lastIndex]['fields'] = [];
        }

        $this->embeds[$lastIndex]['fields'][] = [
            'name' => $name,
            'value' => $value,
            'inline' => $inline,
        ];

        return $this;
    }

    /**
     * Add a footer to the last embed.
     */
    public function footer(string $text, ?string $iconUrl = null): self
    {
        if ($this->embeds === []) {
            $this->embeds[] = [];
        }

        $lastIndex = count($this->embeds) - 1;
        $this->embeds[$lastIndex]['footer'] = ['text' => $text];

        if ($iconUrl !== null) {
            $this->embeds[$lastIndex]['footer']['icon_url'] = $iconUrl;
        }

        return $this;
    }

    /**
     * Add a timestamp to the last embed.
     */
    public function timestamp(?\DateTimeInterface $timestamp = null): self
    {
        if ($this->embeds === []) {
            $this->embeds[] = [];
        }

        $lastIndex = count($this->embeds) - 1;
        $this->embeds[$lastIndex]['timestamp'] = ($timestamp ?? now())->format('c');

        return $this;
    }

    /**
     * Convert the message to an array for the Discord API.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        if ($this->content !== null) {
            $payload['content'] = $this->content;
        }

        if ($this->username !== null) {
            $payload['username'] = $this->username;
        }

        if ($this->avatarUrl !== null) {
            $payload['avatar_url'] = $this->avatarUrl;
        }

        if ($this->embeds !== []) {
            $payload['embeds'] = $this->embeds;
        }

        return $payload;
    }

    // -------------------------------------------------------------------------
    // Preset colors (Discord brand colors)
    // -------------------------------------------------------------------------

    public function success(): self
    {
        return $this->color('#57F287');
    }

    public function warning(): self
    {
        return $this->color('#FEE75C');
    }

    public function error(): self
    {
        return $this->color('#ED4245');
    }

    public function info(): self
    {
        return $this->color('#5865F2');
    }
}
