<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LocationType;
use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'type',
        'population',
        'latitude',
        'longitude',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'type' => LocationType::class,
            'population' => 'integer',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function descendants(): Collection
    {
        return $this->children->flatMap(fn (self $child) => collect([$child])->merge($child->descendants()));
    }

    public function ancestors(): Collection
    {
        $chain = collect();
        $node = $this->parent;
        while ($node) {
            $chain->push($node);
            $node = $node->parent;
        }

        return $chain;
    }

    public function scopeOfType(Builder $query, LocationType $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeRoots(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }
}
