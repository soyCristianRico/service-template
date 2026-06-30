<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LandingStatus;
use Database\Factories\LandingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Landing extends Model
{
    /** @use HasFactory<LandingFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'location_id',
        'slug',
        'title',
        'meta_description',
        'content',
        'status',
        'publish_at',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
            'status' => LandingStatus::class,
            'publish_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $landing): void {
            if (blank($landing->slug)) {
                $landing->slug = $landing->buildSlug();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function buildSlug(): string
    {
        $categorySlug = $this->category?->slug ?? Category::find($this->category_id)?->slug;
        $locationSlug = $this->location?->slug ?? ($this->location_id ? Location::find($this->location_id)?->slug : null);

        $separator = (string) config('seo.landing_slug_separator', '');

        if ($locationSlug === null) {
            return (string) $categorySlug;
        }

        return $separator !== ''
            ? "{$categorySlug}-{$separator}-{$locationSlug}"
            : "{$categorySlug}-{$locationSlug}";
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', LandingStatus::Published);
    }

    public function scopeDueForPublishing(Builder $query): Builder
    {
        return $query
            ->where('status', LandingStatus::Scheduled)
            ->whereNotNull('publish_at')
            ->where('publish_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->status === LandingStatus::Published;
    }

    public function publish(): void
    {
        $this->update(['status' => LandingStatus::Published]);
    }

    public function scopeForCombination(Builder $query, int $categoryId, ?int $locationId): Builder
    {
        return $query
            ->where('category_id', $categoryId)
            ->when($locationId === null, fn (Builder $q) => $q->whereNull('location_id'))
            ->when($locationId !== null, fn (Builder $q) => $q->where('location_id', $locationId));
    }
}
