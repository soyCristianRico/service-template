<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Catalog;

use App\Enums\LandingStatus;
use App\Models\Landing;
use Illuminate\Validation\Rule;
use Livewire\Form;

class LandingForm extends Form
{
    public ?int $id = null;

    public ?int $category_id = null;

    public ?int $location_id = null;

    public string $slug = '';

    public ?string $title = null;

    public ?string $meta_description = null;

    public string $contentJson = '';

    public LandingStatus $status = LandingStatus::Draft;

    public ?string $publish_at = null;

    public function setLanding(Landing $landing): void
    {
        $this->id = $landing->id;
        $this->category_id = $landing->category_id;
        $this->location_id = $landing->location_id;
        $this->slug = $landing->slug;
        $this->title = $landing->title;
        $this->meta_description = $landing->meta_description;
        $this->contentJson = $landing->content !== null
            ? json_encode($landing->content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            : '';
        $this->status = $landing->status;
        $this->publish_at = $landing->publish_at?->format('Y-m-d');
    }

    /**
     * Setting a publish date schedules the landing; clearing it on a scheduled
     * landing sends it back to draft.
     */
    public function syncStatusFromDate(): void
    {
        if (filled($this->publish_at)) {
            $this->status = LandingStatus::Scheduled;
        } elseif ($this->status === LandingStatus::Scheduled) {
            $this->status = LandingStatus::Draft;
        }
    }

    /**
     * Only scheduled landings keep a publish date.
     */
    public function syncDateFromStatus(): void
    {
        if ($this->status !== LandingStatus::Scheduled) {
            $this->publish_at = null;
        }
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'location_id' => ['nullable', 'exists:locations,id'],
            'slug' => [
                'required',
                'string',
                'max:200',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('landings', 'slug')->ignore($this->id),
            ],
            'title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'contentJson' => ['nullable', 'string', function (string $attribute, $value, $fail): void {
                if (blank($value)) {
                    return;
                }
                if (json_decode((string) $value, true) === null && json_last_error() !== JSON_ERROR_NONE) {
                    $fail('El contenido debe ser JSON válido.');
                }
            }],
            'status' => [Rule::enum(LandingStatus::class)],
            'publish_at' => [
                'nullable',
                'date',
                Rule::requiredIf(fn (): bool => $this->status === LandingStatus::Scheduled),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'publish_at.required' => 'Indica la fecha de publicación para programar la landing.',
        ];
    }

    public function save(): Landing
    {
        $this->syncDateFromStatus();
        $this->validate();

        $content = blank($this->contentJson) ? null : json_decode($this->contentJson, true);

        $attributes = [
            'category_id' => $this->category_id,
            'location_id' => $this->location_id,
            'slug' => $this->slug,
            'title' => $this->title,
            'meta_description' => $this->meta_description,
            'content' => $content,
            'status' => $this->status,
            'publish_at' => $this->status === LandingStatus::Scheduled ? $this->publish_at : null,
        ];

        if ($this->id) {
            $landing = Landing::findOrFail($this->id);
            $landing->update($attributes);
        } else {
            $landing = Landing::create($attributes);
            $this->id = $landing->id;
        }

        return $landing;
    }
}
